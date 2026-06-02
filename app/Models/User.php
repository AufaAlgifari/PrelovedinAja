<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'unsoed_faculty',
        'unsoed_major',
        'avatar_url',
        'rating_cache',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'rating_cache'      => 'float',
    ];

    // ── Relationships ──────────────────────────────────────

    // Produk yang dijual user ini
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    // Keranjang belanja milik user ini
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Transaksi sebagai pembeli
    public function purchases()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    // Pesan yang dikirim user ini
    public function sentMessages()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    // Pesan yang diterima user ini
    public function receivedMessages()
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    // Ulasan yang pernah ditulis user ini
    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    // Ulasan yang diterima user ini (sebagai penjual)
    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    // Laporan yang dibuat user ini
    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    // ── Helper ────────────────────────────────────────────

    // Recalculate dan update rating_cache dari semua review yang diterima
    public function recalculateRating(): void
    {
        $avg = $this->receivedReviews()->avg('rating') ?? 0;
        $this->update(['rating_cache' => round($avg, 2)]);
    }
}