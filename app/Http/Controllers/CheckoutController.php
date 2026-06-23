<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Cart;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /**
     * Initialize Midtrans configuration parameters.
     */
    private function initMidtrans()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        
        // Fix SSL certificate issue on Windows for development
        if (!Config::$isProduction) {
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => [],
            ];
        }
    }

    /**
     * Display the manual checkout page for a specific product.
     * 
     * @param Product $product
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Product $product)
    {
        // Hanya izinkan checkout jika produk masih Available
        if (!$product->isAvailable()) {
            return redirect()->route('home')->with('error', 'Produk ini sudah terjual atau dipesan oleh pengguna lain.');
        }

        $user = auth()->user();

        // Jika tidak login, asumsikan user 1 untuk kemudahan demo (atau redirect)
        if (!$user) {
            $user = \App\Models\User::first();
        }

        return view('checkout.index', compact('product', 'user'));
    }

    /**
     * Process checkout form, save transaction and update product status.
     * 
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Product $product)
    {
        $buyerId = $request->input('buyer_id');
        $user = auth()->user();

        if (!$user && $buyerId) {
            $user = \App\Models\User::find($buyerId);
        }

        if (!$user) {
            $user = \App\Models\User::first();
        }

        // Validasi ketersediaan produk (mencegah race condition)
        if (!$product->isAvailable()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['error' => 'Maaf, produk ini baru saja dibeli oleh pengguna lain.'], 400);
            }
            return redirect()->route('home')->with('error', 'Maaf, produk ini baru saja dibeli oleh pengguna lain.');
        }

        $request->validate([
            'metode_pengiriman' => 'required|in:cod,do',
            'alamat_pengiriman' => 'required_if:metode_pengiriman,do',
            'metode_pembayaran' => 'required|in:qris,dana,gopay,shopeepay',
        ]);

        $orderIdMidtrans = 'ORDER-BUY-' . microtime(true) * 1000 . '-' . Str::random(8) . '-' . $user->id;

        // 1. Simpan data transaksi
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'buyer_id' => $user->id,
            'seller_id' => $product->seller_id,
            'product_id' => $product->id,
            'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
            'order_id_midtrans' => $orderIdMidtrans,
            'amount' => $product->price,
            'status' => 'pending',
            'metode_pengiriman' => $request->metode_pengiriman,
            'alamat_pengiriman' => $request->metode_pengiriman === 'do' ? $request->alamat_pengiriman : null,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        // 2. Ubah status produk menjadi Terjual ('Sold')
        $product->update([
            'status' => 'Sold'
        ]);

        // 3. Hapus produk ini dari keranjang semua user
        Cart::where('product_id', $product->id)->delete();

        // 4. Kirim notifikasi ke penjual bahwa ada pesanan baru
        try {
            $seller = User::find($product->seller_id);
            if ($seller) {
                $seller->notify(new NewOrderNotification($transaction->load(['user', 'product'])));
            }
        } catch (\Exception $e) {
            // Silently ignore notification errors so checkout still works
        }

        // 4. Generate Midtrans Snap Token
        $this->initMidtrans();
        
        $params = [
            'transaction_details' => [
                'order_id' => $orderIdMidtrans,
                'gross_amount' => (int) $product->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone_number ?? '08123456789',
            ],
            'item_details' => [
                [
                    'id' => (string) $product->id,
                    'price' => (int) $product->price,
                    'quantity' => 1,
                    'name' => substr($product->title, 0, 50),
                ]
            ],
            'enabled_payments' => [
                'credit_card', 'gcg_payment', 'bank_transfer', 'bank_bca', 
                'cimb_clicks', 'bca_klikbca', 'mandiri_clickpay', 
                'echannel', 'permata_va', 'bri_epay', 'telkomsel_cash',
                'gopay', 'shopeepay'
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            $transaction->update([
                'snap_token' => $snapToken,
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'snap_token' => $snapToken,
                    'client_key' => config('midtrans.client_key'),
                    'transaction_id' => $transaction->id,
                    'redirect_url' => route('transactions.history'),
                ]);
            }

            return redirect()->route('transactions.history')->with('success', 'Pemesanan berhasil! Silakan selesaikan pembayaran.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal membuat Midtrans Snap Token: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Gagal menghubungi server pembayaran: ' . $e->getMessage(),
                    'redirect_url' => route('transactions.history'),
                ], 500);
            }

            return redirect()->route('transactions.history')->with('success', 'Pemesanan berhasil dibuat (manual)!');
        }
    }
}
