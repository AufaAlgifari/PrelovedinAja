<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // GET /users/{id}/reviews
    public function index(int $id)
    {
        $reviews = Review::with('reviewer:id,name,avatar_url')
            ->where('reviewee_id', $id)
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }

    // POST /reviews
    public function store(Request $request)
    {
        $data = $request->validate([
            'transaction_id' => 'required|integer|exists:transactions,id',
            'rating'         => 'required|integer|min:1|max:5',
            'comment'        => 'nullable|string|max:1000',
        ]);

        $transaction = Transaction::with('product.seller')
            ->where('buyer_id', $request->user()->id)
            ->findOrFail($data['transaction_id']);

        // Hanya bisa review jika transaksi sudah Completed
        if (! $transaction->canBeReviewed()) {
            return response()->json([
                'message' => 'Transaksi belum selesai atau sudah pernah diulas.',
            ], 422);
        }

        $review = Review::create([
            'transaction_id' => $transaction->id,
            'reviewer_id'    => $request->user()->id,
            'reviewee_id'    => $transaction->product->seller->id,
            'rating'         => $data['rating'],
            'comment'        => $data['comment'] ?? null,
        ]);

        // Update rating_cache penjual
        $transaction->product->seller->recalculateRating();

        return response()->json([
            'message' => 'Ulasan berhasil dikirim. Terima kasih!',
            'review'  => $review,
        ], 201);
    }
}