<?php

use Illuminate\Support\Facades\Route;

// Halaman Utama / Home (Menampilkan produk preloved)
Route::get('/', function () {
    return view('home');
})->name('home');

// Halaman Login & Register
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Halaman Detail Produk
Route::get('/products/{id}', function ($id) {
    // Di controller asli, kamu bisa passing data product ke view
    return view('products.show', compact('id'));
})->name('products.show');

// Halaman Keranjang Belanja
Route::get('/cart', function () {
    return view('cart.index');
})->name('cart.index');

// Halaman Riwayat Transaksi & Ulasan
Route::get('/transactions/history', function () {
    return view('transactions.history');
})->name('transactions.history');