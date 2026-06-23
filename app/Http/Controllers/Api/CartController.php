<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // GET /cart
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // Ambil data keranjang user saat ini
        $userCarts = Cart::where('user_id', $userId)
            ->with('product')
            ->get();

        $unavailableProductIds = [];
        $removedTitles = [];

        foreach ($userCarts as $cart) {
            // Jika produk tidak ditemukan (sudah dihapus) atau statusnya tidak 'Available'
            if (!$cart->product || !$cart->product->isAvailable()) {
                $unavailableProductIds[] = $cart->product_id;
                $removedTitles[] = $cart->product ? $cart->product->title : 'Produk tidak dikenal';
            }
        }

        if (!empty($unavailableProductIds)) {
            // Hapus produk dari keranjang SEMUA user yang menyimpannya
            Cart::whereIn('product_id', $unavailableProductIds)->delete();
        }

        // Ambil kembali keranjang terupdate
        $carts = Cart::with([
            'product.seller:id,name,avatar_url',
        ])
        ->where('user_id', $userId)
        ->get();

        return response()->json($carts)
            ->header('X-Removed-Items', json_encode($removedTitles))
            ->header('Access-Control-Expose-Headers', 'X-Removed-Items'); // Agar JS di frontend bisa mengakses custom header ini
    }

    // POST /cart
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = Product::findOrFail($data['product_id']);

        // Business rule 1: tidak bisa tambah produk sendiri
        if ($product->isOwnedBy($request->user()->id)) {
            return response()->json([
                'message' => 'Kamu tidak bisa menambahkan produk milik sendiri ke keranjang.',
            ], 422);
        }

        // Business rule 2: hanya produk Available
        if (! $product->isAvailable()) {
            return response()->json([
                'message' => 'Produk ini sudah tidak tersedia.',
            ], 422);
        }

        // Business rule 3: cek duplikat (jaga-jaga, DB juga ada unique constraint)
        $exists = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            $existingCart = Cart::where('user_id', $request->user()->id)
                ->where('product_id', $product->id)
                ->first();
            return response()->json([
                'message' => 'Produk ini sudah ada di keranjang kamu.',
                'cart'    => $existingCart->load('product'),
            ], 200);
        }

        $cart = Cart::create([
            'user_id'    => $request->user()->id,
            'product_id' => $product->id,
            'added_at'   => now(),
        ]);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'cart'    => $cart->load('product'),
        ], 201);
    }

    // DELETE /cart/{id}
    public function destroy(Request $request, int $id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $cart->delete();

        return response()->json(['message' => 'Produk berhasil dihapus dari keranjang.']);
    }
}