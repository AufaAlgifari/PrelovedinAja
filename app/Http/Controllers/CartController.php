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
        $carts = Cart::with([
            'product.seller:id,name,avatar_url',
        ])
        ->where('user_id', $request->user()->id)
        ->get();

        return response()->json($carts);
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
            return response()->json([
                'message' => 'Produk ini sudah ada di keranjang kamu.',
            ], 422);
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