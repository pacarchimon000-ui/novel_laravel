<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\CoinTransaction;
use Midtrans\Snap;
use Midtrans\Config;

class CoinController extends Controller
{
    /**
     * Daftar paket coin yang tersedia
     */
    private array $packages = [
        'basic' => ['coins' => 50, 'amount' => 10000],
        'standard' => ['coins' => 120, 'amount' => 20000],
        'premium' => ['coins' => 320, 'amount' => 50000],
        'ultimate' => ['coins' => 700, 'amount' => 100000],
    ];

    /**
     * Tampilkan halaman coin dengan paket top up
     */
    public function index(Request $request): View
    {
        return view('coins.index', [
            'user' => $request->user(),
            'packages' => $this->packages,
            'rewards' => $request->user()->readingRewards()->with('chapter.novel')->latest()->paginate(10),
            'transactions' => $request->user()->coinTransactions()->latest()->paginate(5),
        ]);
    }

    /**
     * Buat transaksi top up dan generate Snap Token
     */
    public function topup(Request $request): RedirectResponse
    {
        $request->validate([
            'package' => 'required|in:' . implode(',', array_keys($this->packages)),
        ]);

        $package = $this->packages[$request->package];
        $user = $request->user();

        // Buat order ID unik
        $orderId = 'COIN-' . $user->id . '-' . time();

        // Buat transaksi
        $transaction = CoinTransaction::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'package_code' => $request->package,
            'coins' => $package['coins'],
            'amount' => $package['amount'],
            'status' => 'pending',
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Parameter untuk Snap
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $package['amount'],
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $request->package,
                    'price' => $package['amount'],
                    'quantity' => 1,
                    'name' => $package['coins'] . ' Coins',
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);

            return redirect()->route('coins.payment', $transaction->id);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman pembayaran
     */
    public function payment(CoinTransaction $transaction): View
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        return view('coins.payment', [
            'transaction' => $transaction,
            'clientKey' => config('services.midtrans.client_key'),
            'isProduction' => config('services.midtrans.is_production', false),
        ]);
    }

    /**
     * Handle callback dari Midtrans
     */
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $transaction = CoinTransaction::where('order_id', $request->order_id)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($request->transaction_status === 'capture' || $request->transaction_status === 'settlement') {
            $transaction->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // Tambah coin ke user
            $transaction->user->increment('coins', $transaction->coins);
        } elseif (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
            $transaction->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'OK']);
    }
}