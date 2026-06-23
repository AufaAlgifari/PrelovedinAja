<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Api\NotificationController;

// ── Public Routes (tidak perlu login) ─────────────────────
Route::prefix('v1')->group(function () {

    // Auth
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password',  [AuthController::class, 'resetPassword']);

    // Browse produk (bisa dilihat tanpa login)
    Route::get('/products',        [ProductController::class, 'index']);
    Route::get('/products/{id}',   [ProductController::class, 'show']);

});

// ── Protected Routes (wajib login) ────────────────────────
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::get('/me',       [AuthController::class, 'me']);
    Route::put('/me',       [AuthController::class, 'update']);

    // Products (CRUD milik sendiri)
    Route::post('/products',            [ProductController::class, 'store']);
    Route::put('/products/{id}',        [ProductController::class, 'update']);
    Route::delete('/products/{id}',     [ProductController::class, 'destroy']);

    // Cart
    Route::get('/cart',                 [CartController::class, 'index']);
    Route::post('/cart',                [CartController::class, 'store']);
    Route::delete('/cart/{id}',         [CartController::class, 'destroy']);

    // Transactions
    Route::get('/transactions',                         [TransactionController::class, 'index']);
    Route::post('/transactions',                        [TransactionController::class, 'store']);
    Route::get('/transactions/{id}',                    [TransactionController::class, 'show']);
    Route::patch('/transactions/{id}/confirm-payment',  [TransactionController::class, 'confirmPayment']);
    Route::patch('/transactions/{id}/complete',         [TransactionController::class, 'complete']);
    Route::patch('/transactions/{id}/cancel',           [TransactionController::class, 'cancel']);
    
    // Payment (Cart Checkout)
    Route::post('/payment/cart-checkout',               [PaymentController::class, 'createSnapTokenFromCart']);

    // Chat
    Route::get('/chats',                [ChatController::class, 'index']);      // list semua kontak
    Route::get('/chats/{userId}',       [ChatController::class, 'show']);       // riwayat percakapan
    Route::post('/chats',               [ChatController::class, 'store']);      // kirim pesan
    Route::patch('/chats/{userId}/read',[ChatController::class, 'markAsRead']); // tandai sudah dibaca

    // Reviews
    Route::post('/reviews',             [ReviewController::class, 'store']);
    Route::get('/users/{id}/reviews',   [ReviewController::class, 'index']);

    // Reports
    Route::post('/reports',             [ReportController::class, 'store']);
    Route::patch('/admin/reports/{id}/resolve', [ReportController::class, 'resolve'])->middleware('admin');

    // Notifications
    Route::get('/notifications',             [NotificationController::class, 'index']);
    Route::patch('/notifications/read-all',  [NotificationController::class, 'markAllAsRead']);
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);

});

Broadcast::routes(['prefix' => 'api/v1', 'middleware' => ['auth:sanctum']]);