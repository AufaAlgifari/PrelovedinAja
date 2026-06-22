<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'cart_id',
        'transaction_id',
        'order_id_midtrans',
        'amount',
        'status',
        'payment_type',
        'snap_token',
        'shipping_method',
    ];

    protected $casts = [
        'amount' => 'integer',
        'snap_token' => 'string',
    ];

    // ── Relationships ──────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Satu transaksi punya satu ulasan
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // ── Helper ────────────────────────────────────────────

    public function isCompleted(): bool
    {
        return $this->status === 'success';
    }

    public function canBeReviewed(): bool
    {
        return $this->isCompleted() && is_null($this->review);
    }
}