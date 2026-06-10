<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'product_id',
    ];

    // ── Relationships ──────────────────────────────────────

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Hubungan ke pesan-pesan di dalam chat room ini
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // ── Scope ─────────────────────────────────────────────

    // Ambil chat room antara dua user
    public function scopeBetween($query, int $userA, int $userB)
    {
        return $query->where(function ($q) use ($userA, $userB) {
            $q->where('buyer_id', $userA)->where('seller_id', $userB);
        })->orWhere(function ($q) use ($userA, $userB) {
            $q->where('buyer_id', $userB)->where('seller_id', $userA);
        });
    }
}