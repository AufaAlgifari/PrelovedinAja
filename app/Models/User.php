<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
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
        'role',
        'is_verified',
        'no_kampus',
        'verification_token',
        'token_expired_at',
        'last_login_at',
        'status',
        'suspend_reason',
        'suspended_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'rating_cache'      => 'float',
        'is_verified'       => 'boolean',
        'token_expired_at'  => 'datetime',
        'last_login_at'     => 'datetime',
        'suspended_at' => 'datetime',
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

    // Chat room sebagai pembeli
    public function chatsAsBuyer()
    {
        return $this->hasMany(Chat::class, 'buyer_id');
    }

    // Chat room sebagai penjual
    public function chatsAsSeller()
    {
        return $this->hasMany(Chat::class, 'seller_id');
    }

    // Pesan-pesan yang dikirim user ini
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
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