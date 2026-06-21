<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('seller:id,name,unsoed_faculty');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json($products);
    }

    public function destroy(Request $request, Product $product)
    {
        $title = $product->title;
        $productId = $product->id;

        $product->delete();

        AuditLogController::record(
            $request->user()->id,
            'delete_listing',
            'Product',
            $productId,
            "Menghapus listing \"{$title}\" oleh admin."
        );

        return response()->json(['message' => 'Listing berhasil dihapus.']);
    }
}