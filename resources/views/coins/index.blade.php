@extends('layouts.app')

@section('title', 'Coin')

@section('content')
<div class="container" style="padding: 2rem 0 4rem; max-width: 1000px;">
    <div class="section-header" style="margin-bottom: 1.5rem;">
        <div>
            <p class="eyebrow">Reward membaca</p>
            <h1><span class="coin-badge coin-badge-large" aria-hidden="true">C</span> Coin Anda: {{ auth()->user()->coins }}</h1>
            <p>{{ auth()->user()->reading_points }} poin membaca · Level {{ auth()->user()->reading_level }}</p>
        </div>
    </div>

    @php
        $points = (int) auth()->user()->reading_points;
        $levelProgress = $points % 100;
        $pointsToNextLevel = 100 - $levelProgress;
    @endphp

    <div class="reward-overview">
        <div class="reward-overview-header">
            <div>
                <span class="reward-label">Progress level {{ auth()->user()->reading_level }}</span>
                <strong>{{ $levelProgress }}/100 poin</strong>
            </div>
            <span class="reward-next">{{ $pointsToNextLevel }} poin lagi untuk reward berikutnya</span>
        </div>
        <div class="reward-progress" role="progressbar" aria-valuenow="{{ $levelProgress }}" aria-valuemin="0" aria-valuemax="100">
            <span style="width: {{ $levelProgress }}%"></span>
        </div>
        <p class="reward-helper">Selesaikan membaca chapter untuk mendapatkan 10 poin. Setiap 100 poin memberi 1 atau 2 coin secara bergantian.</p>
    </div>

    <div class="reward-history" style="margin-top: 2rem;">
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
@endsection
