@extends('layouts.app')

@section('title', 'Coin')

@section('content')
<div class="container" style="padding: 2rem 0 4rem; max-width: 1000px;">
    {{-- Flash Messages --}}
    @if(request('status') === 'success')
        <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <strong>Berhasil!</strong> Pembayaran berhasil, coin sudah ditambahkan ke akun Anda.
        </div>
    @elseif(request('status') === 'pending')
        <div style="background: #fef3c7; color: #92400e; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <strong>Menunggu Pembayaran</strong> Silakan selesaikan pembayaran Anda.
        </div>
    @elseif(request('status') === 'error')
        <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <strong>Gagal</strong> Terjadi kesalahan saat pembayaran. Silakan coba lagi.
        </div>
    @endif

    {{-- Header --}}
    <div class="section-header" style="margin-bottom: 2rem;">
        <div>
            <p class="eyebrow">Koin Anda</p>
            <h1><span class="coin-badge coin-badge-large" aria-hidden="true">C</span> {{ number_format($user->coins) }}</h1>
            <p>{{ $user->reading_points }} poin membaca · Level {{ $user->reading_level }}</p>
        </div>
    </div>

    {{-- Top Up Packages --}}
    <div class="topup-section" style="margin-bottom: 3rem;">
        <h2 style="margin-bottom: 1rem;">Top Up Coin</h2>
        <div class="topup-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            @foreach($packages as $code => $pkg)
                <div class="topup-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 1.5rem; color: white; text-align: center; cursor: pointer; transition: transform 0.2s;" onclick="selectPackage('{{ $code }}', {{ $pkg['coins'] }}, {{ $pkg['amount'] }})">
                    <div style="font-size: 2.5rem; font-weight: bold;">{{ $pkg['coins'] }}</div>
                    <div style="font-size: 0.875rem; opacity: 0.9;">Coins</div>
                    <div style="margin-top: 0.5rem; font-size: 1.25rem; font-weight: 600;">Rp {{ number_format($pkg['amount']) }}</div>
                </div>
            @endforeach
        </div>

        <form id="topup-form" action="{{ route('coins.topup') }}" method="POST" style="margin-top: 1.5rem;">
            @csrf
            <input type="hidden" name="package" id="selected-package">
            <button type="submit" id="topup-btn" class="btn btn-primary" disabled style="width: 100%; padding: 0.875rem; font-size: 1rem;">
                Pilih Paket untuk Top Up
            </button>
        </form>
    </div>

    {{-- Progress Reward --}}
    @php
        $points = (int) $user->reading_points;
        $levelProgress = $points % 100;
        $pointsToNextLevel = 100 - $levelProgress;
    @endphp

    <div class="reward-overview" style="margin-bottom: 2rem;">
        <div class="reward-overview-header">
            <div>
                <span class="reward-label">Progress Level {{ $user->reading_level }}</span>
                <strong>{{ $levelProgress }}/100 poin</strong>
            </div>
            <span class="reward-next">{{ $pointsToNextLevel }} poin lagi untuk reward berikutnya</span>
        </div>
        <div class="reward-progress" role="progressbar" aria-valuenow="{{ $levelProgress }}" aria-valuemin="0" aria-valuemax="100">
            <span style="width: {{ $levelProgress }}%"></span>
        </div>
    </div>

    {{-- Transaction History --}}
    <div class="transaction-history" style="margin-bottom: 2rem;">
        <h2 style="margin-bottom: 1rem;">Riwayat Transaksi</h2>
        @if($transactions->count() > 0)
            <div class="transaction-list">
                @foreach($transactions as $tx)
                    <div class="transaction-item" style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; border-bottom: 1px solid #e5e7eb;">
                        <div>
                            <strong>{{ $tx->coins }} Coins</strong>
                            <div style="font-size: 0.875rem; color: #6b7280;">{{ $tx->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-weight: 600;">Rp {{ number_format($tx->amount) }}</div>
                            <span style="font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 9999px; {{ $tx->status === 'paid' ? 'background: #d1fae5; color: #065f46;' : ($tx->status === 'pending' ? 'background: #fef3c7; color: #92400e;' : 'background: #fee2e2; color: #991b1b;') }}">
                                {{ $tx->status === 'paid' ? 'Sukses' : ($tx->status === 'pending' ? 'Menunggu' : 'Gagal') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: #6b7280;">Belum ada transaksi top up.</p>
        @endif
    </div>

    {{-- Reading Rewards --}}
    <div class="reward-history">
        <div class="reward-history-header">
            <h2>Riwayat Reward Membaca</h2>
            <span>{{ $rewards->total() }} aktivitas</span>
        </div>
        <div class="reward-history-body">
            @forelse($rewards as $reward)
                <div class="reward-history-item">
                    <div>
                        <strong>{{ $reward->chapter->novel->title }}</strong>
                        <span>Chapter {{ $reward->chapter->chapter_number }} · {{ $reward->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="reward-values">
                        <span>+{{ $reward->points }} poin</span>
                        @if($reward->coins > 0)<b>+{{ $reward->coins }} coin</b>@endif
                    </div>
                </div>
            @empty
                <p class="reward-empty">Belum ada reward. Mulai membaca chapter pertamamu.</p>
            @endforelse
            {{ $rewards->links() }}
        </div>
    </div>
</div>

<script>
let selectedPackage = null;

function selectPackage(code, coins, amount) {
    selectedPackage = code;
    document.getElementById('selected-package').value = code;
    document.getElementById('topup-btn').disabled = false;
    document.getElementById('topup-btn').textContent = `Top Up ${coins} Coins - Rp ${amount.toLocaleString('id-ID')}`;
    
    // Highlight selected card
    document.querySelectorAll('.topup-card').forEach(card => {
        card.style.transform = '';
        card.style.boxShadow = '';
    });
    event.currentTarget.style.transform = 'scale(1.05)';
    event.currentTarget.style.boxShadow = '0 10px 40px rgba(0,0,0,0.2)';
}
</script>
@endsection
