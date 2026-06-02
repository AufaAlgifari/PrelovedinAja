<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // GET /transactions
    public function index(Request $request)
    {
        $transactions = Transaction::with(['product.seller:id,name', 'product'])
            ->where('buyer_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($transactions);
    }

    // GET /transactions/{id}
    public function show(Request $request, int $id)
    {
        $transaction = Transaction::with(['product.seller', 'buyer', 'review'])
            ->where('buyer_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($transaction);
    }

    // POST /transactions — checkout
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'     => 'required|integer|exists:products,id',
            'payment_method' => 'required|string|in:Transfer,QRIS,COD',
            'shipping_method'=> 'required|in:COD,Courier',
        ]);

        $product = Product::findOrFail($data['product_id']);

        // Validasi produk masih tersedia
        if (! $product->isAvailable()) {
            return response()->json(['message' => 'Produk ini sudah tidak tersedia.'], 422);
        }

        // Tidak bisa beli produk sendiri
        if ($product->isOwnedBy($request->user()->id)) {
            return response()->json(['message' => 'Kamu tidak bisa membeli produk milik sendiri.'], 422);
        }

        // Jalankan dalam transaksi DB agar atomic
        $transaction = DB::transaction(function () use ($request, $data, $product) {

            // Buat record transaksi
            $tx = Transaction::create([
                'buyer_id'           => $request->user()->id,
                'product_id'         => $product->id,
                'total_amount'       => $product->price,
                'payment_method'     => $data['payment_method'],
                'payment_status'     => 'Pending',
                'transaction_status' => 'Processing',
                'shipping_method'    => $data['shipping_method'],
            ]);

            // Ubah status produk menjadi Reserved
            $product->update(['status' => 'Reserved']);

            // Hapus dari keranjang jika ada
            Cart::where('user_id', $request->user()->id)
                ->where('product_id', $product->id)
                ->delete();

            return $tx;
        });

        return response()->json([
            'message'     => 'Checkout berhasil. Silakan lakukan pembayaran.',
            'transaction' => $transaction->load('product'),
        ], 201);
    }

    // PATCH /transactions/{id}/confirm-payment
    public function confirmPayment(Request $request, int $id)
    {
        $transaction = Transaction::where('buyer_id', $request->user()->id)
            ->findOrFail($id);

        if ($transaction->payment_status !== 'Pending') {
            return response()->json(['message' => 'Status pembayaran tidak valid untuk dikonfirmasi.'], 422);
        }

        $transaction->update(['payment_status' => 'Paid']);

        return response()->json([
            'message'     => 'Pembayaran berhasil dikonfirmasi.',
            'transaction' => $transaction->fresh(),
        ]);
    }

    // PATCH /transactions/{id}/complete — barang sudah diterima
    public function complete(Request $request, int $id)
    {
        $transaction = Transaction::with('product')
            ->where('buyer_id', $request->user()->id)
            ->findOrFail($id);

        if ($transaction->payment_status !== 'Paid') {
            return response()->json(['message' => 'Pembayaran belum dikonfirmasi.'], 422);
        }

        if ($transaction->transaction_status !== 'Processing') {
            return response()->json(['message' => 'Transaksi tidak dalam status yang bisa diselesaikan.'], 422);
        }

        DB::transaction(function () use ($transaction) {
            $transaction->update(['transaction_status' => 'Completed']);
            $transaction->product->update(['status' => 'Sold']);
        });

        return response()->json([
            'message'     => 'Transaksi selesai. Kamu bisa memberikan ulasan sekarang.',
            'transaction' => $transaction->fresh(),
        ]);
    }

    // PATCH /transactions/{id}/cancel
    public function cancel(Request $request, int $id)
    {
        $transaction = Transaction::with('product')
            ->where('buyer_id', $request->user()->id)
            ->findOrFail($id);

        if ($transaction->transaction_status !== 'Processing') {
            return response()->json(['message' => 'Transaksi tidak bisa dibatalkan.'], 422);
        }

        DB::transaction(function () use ($transaction) {
            $transaction->update([
                'transaction_status' => 'Cancelled',
                'payment_status'     => 'Failed',
            ]);
            // Kembalikan status produk ke Available
            $transaction->product->update(['status' => 'Available']);
        });

        return response()->json([
            'message'     => 'Transaksi berhasil dibatalkan.',
            'transaction' => $transaction->fresh(),
        ]);
    }
}