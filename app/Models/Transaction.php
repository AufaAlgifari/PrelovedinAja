<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'product_id',
        'total_amount',
        'payment_method',
        'payment_status',
        'transaction_status',
        'shipping_method',
    ];

    protected $casts = [
        'total_amount' => 'integer',
    ];

    // ── Relationships ──────────────────────────────────────

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Satu transaksi punya satu ulasan
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // ── Helper ────────────────────────────────────────────

    public function isCompleted(): bool
    {
        return $this->transaction_status === 'Completed';
    }

    public function canBeReviewed(): bool
    {
        // Hanya bisa diulas jika sudah Completed dan belum punya review
        return $this->isCompleted() && is_null($this->review);
    }
}