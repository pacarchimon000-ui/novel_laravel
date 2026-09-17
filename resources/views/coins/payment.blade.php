@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container" style="padding: 2rem 0 4rem; max-width: 500px;">
    <div class="payment-card" style="background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 2rem;">
        <h1 style="margin-bottom: 0.5rem; text-align: center;">Pembayaran</h1>
        <p style="text-align: center; color: #6b7280; margin-bottom: 1.5rem;">
            Selesaikan pembayaran untuk mendapatkan coin
        </p>

        <div style="background: #f3f4f6; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Paket</span>
                <strong>{{ $transaction->coins }} Coins</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Total</span>
                <strong>Rp {{ number_format($transaction->amount) }}</strong>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 1.5rem;">
            <span style="font-size: 0.875rem; color: #6b7280;">Order ID: {{ $transaction->order_id }}</span>
        </div>

        <button id="pay-button" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem;">
            Bayar Sekarang
        </button>

        <div style="text-align: center; margin-top: 1rem;">
            <a href="{{ route('coins.index') }}" style="color: #6b7280; font-size: 0.875rem;">Batalkan</a>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
<script>
document.getElementById('pay-button').onclick = function() {
    snap.pay('{{ $transaction->snap_token }}', {
        onSuccess: function(result) {
            window.location.href = '{{ route("coins.index") }}?status=success';
        },
        onPending: function(result) {
            window.location.href = '{{ route("coins.index") }}?status=pending';
        },
        onError: function(result) {
            window.location.href = '{{ route("coins.index") }}?status=error';
        },
        onClose: function() {
            alert('Pembayaran dibatalkan. Anda bisa melanjutkan pembayaran nanti.');
        }
    });
};
</script>
@endsection