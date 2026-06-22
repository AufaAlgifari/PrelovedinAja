<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
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
     * @return \Illuminate\Http\RedirectResponse
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
            return redirect()->route('home')->with('error', 'Maaf, produk ini baru saja dibeli oleh pengguna lain.');
        }

        $request->validate([
            'metode_pengiriman' => 'required|in:cod,do',
            'alamat_pengiriman' => 'required_if:metode_pengiriman,do',
            'metode_pembayaran' => 'required|in:qris,dana,gopay,shopeepay',
        ]);

        // 1. Simpan data transaksi
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'buyer_id' => $user->id,
            'seller_id' => $product->seller_id,
            'product_id' => $product->id,
            'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
            'order_id_midtrans' => null, // Tidak dipakai lagi
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

        // 4. Redirect ke halaman riwayat pesanan (transactions.history) dengan notifikasi
        return redirect()->route('transactions.history')->with('success', 'Pemesanan berhasil! Silakan hubungi penjual untuk koordinasi pengiriman.');
    }
}
