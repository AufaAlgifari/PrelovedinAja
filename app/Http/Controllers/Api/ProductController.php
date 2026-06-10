<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // GET /products
    public function index(Request $request)
    {
        $query = Product::with('seller:id,name,avatar_url,rating_cache')
            ->available();

        // Filter opsional
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest(),
        };

        return response()->json($query->paginate(12));
    }

    // GET /products/{id}
    public function show(int $id)
    {
        $product = Product::with([
            'seller:id,name,avatar_url,rating_cache,unsoed_faculty,unsoed_major',
        ])->findOrFail($id);

        return response()->json($product);
    }

    // POST /products
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|integer|min:1000',
            'condition'   => 'required|in:New,Like New,Good,Well Used',
            'category'    => 'required|string|max:100',
            'images'      => 'required|array|min:1|max:5',
        ]);

        // Upload gambar (mendukung file biner multipart maupun base64 fallback)
        $imageUrls = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('products', 'public');
                    $imageUrls[] = Storage::url($path);
                }
            }
        } else {
            foreach ($data['images'] as $imgData) {
                if (is_string($imgData) && str_starts_with($imgData, 'data:image')) {
                    // Ekstraksi data base64
                    @list($type, $imgData) = explode(';', $imgData);
                    @list(, $imgData)      = explode(',', $imgData);
                    $imageDecoded = base64_decode($imgData);
                    $fileName = 'products/' . uniqid() . '.png';
                    Storage::disk('public')->put($fileName, $imageDecoded);
                    $imageUrls[] = Storage::url($fileName);
                } else if (is_string($imgData)) {
                    $imageUrls[] = $imgData;
                }
            }
        }

        if (empty($imageUrls)) {
            $imageUrls[] = 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';
        }

        // Cari category_id berdasarkan nama kategori
        $categoryModel = \App\Models\Category::where('name', $data['category'])->first();

        $product = Product::create([
            'seller_id'   => $request->user()->id,
            'title'       => $data['title'],
            'description' => $data['description'],
            'price'       => $data['price'],
            'condition'   => $data['condition'],
            'category'    => $data['category'],
            'category_id' => $categoryModel ? $categoryModel->id : null,
            'status'      => 'Available',
            'image_urls'  => $imageUrls,
        ]);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan.',
            'product' => $product,
        ], 201);
    }

    // PUT /products/{id}
    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        // Hanya penjual yang bisa edit
        if ($product->seller_id !== $request->user()->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        // Produk yang sudah terjual tidak bisa diedit
        if ($product->status === 'Sold') {
            return response()->json(['message' => 'Produk yang sudah terjual tidak dapat diedit.'], 422);
        }

        $data = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price'       => 'sometimes|integer|min:1000',
            'condition'   => 'sometimes|in:New,Like New,Good,Well Used',
            'category'    => 'sometimes|string|max:100',
        ]);

        $product->update($data);

        return response()->json([
            'message' => 'Produk berhasil diperbarui.',
            'product' => $product->fresh(),
        ]);
    }

    // DELETE /products/{id}
    public function destroy(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        if ($product->seller_id !== $request->user()->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        if (in_array($product->status, ['Reserved', 'Sold'])) {
            return response()->json(['message' => 'Produk yang sedang dalam transaksi tidak dapat dihapus.'], 422);
        }

        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus.']);
    }
}