<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'description',
        'price',
        'condition',
        'category',
        'status',
        'image_urls',
    ];

    protected $casts = [
        'image_urls' => 'array',  // otomatis encode/decode JSON
        'price'      => 'integer',
    ];

    // ── Relationships ──────────────────────────────────────

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_product_id');
    }

    // ── Scopes ────────────────────────────────────────────

    // Hanya ambil produk yang masih tersedia
    public function scopeAvailable($query)
    {
        return $query->where('status', 'Available');
    }

    // Filter berdasarkan kategori
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // ── Helper ────────────────────────────────────────────

    public function isOwnedBy(int $userId): bool
    {
        return $this->seller_id === $userId;
    }

    public function isAvailable(): bool
    {
        return $this->status === 'Available';
    }
}