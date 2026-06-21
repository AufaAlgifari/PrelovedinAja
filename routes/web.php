<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;

// Helper function to return beautiful mock products
function getMockProducts() {
    return [
        [
            'id' => 1,
            'title' => 'Buku Referensi Kalkulus Purcell Ed. 9',
            'description' => 'Buku Kalkulus legendaris edisi 9, kondisi masih sangat bagus, tidak ada coretan pulpen, hanya highlight stabilo kuning tipis di bab 2. Sangat berguna untuk mahasiswa Teknik atau MIPA tingkat awal.',
            'price' => 120000,
            'condition' => 'Like New',
            'category' => 'Textbooks',
            'status' => 'Available',
            'image_urls' => [
                'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=600&q=80'
            ],
            'seller' => (object)[
                'name' => 'Fadhil - FT Unsoed',
                'avatar_url' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 4.9,
                'unsoed_faculty' => 'Teknik',
                'unsoed_major' => 'Teknik Elektro'
            ]
        ],
        [
            'id' => 2,
            'title' => 'iPad Air 4 64GB WiFi + Apple Pencil 2',
            'description' => 'Jual cepat buat bayar UKT. iPad Air 4 warna Space Gray, mulus 98%, no minus, iCloud aman tinggal reset. Bonus Apple Pencil 2 original, case, dan paperlike screen protector sudah terpasang.',
            'price' => 5400000,
            'condition' => 'Good',
            'category' => 'Electronics',
            'status' => 'Available',
            'image_urls' => [
                'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1589739900243-4b52cd9b104e?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?auto=format&fit=crop&w=600&q=80'
            ],
            'seller' => (object)[
                'name' => 'Amelia - FEB Unsoed',
                'avatar_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 4.8,
                'unsoed_faculty' => 'Ekonomi dan Bisnis',
                'unsoed_major' => 'Manajemen'
            ]
        ],
        [
            'id' => 3,
            'title' => 'Kemeja Flanel Uniqlo Hijau Hitam (Size L)',
            'description' => 'Bahan flanel tebal khas Uniqlo, adem dipakai kuliah. Dipakai baru 3 kali, warna masih pekat, tidak ada sobek atau jahitan lepas. Alasan jual karena kekecilan.',
            'price' => 135000,
            'condition' => 'Like New',
            'category' => 'Apparel',
            'status' => 'Available',
            'image_urls' => [
                'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=600&q=80'
            ],
            'seller' => (object)[
                'name' => 'Rian - Faperta',
                'avatar_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 4.7,
                'unsoed_faculty' => 'Pertanian',
                'unsoed_major' => 'Agroteknologi'
            ]
        ],
        [
            'id' => 4,
            'title' => 'Kulkas Mini Portable Changhong 50L',
            'description' => 'Kulkas mini portable watt kecil (hanya 80 watt), pas banget buat ditaruh di kamar kost. Dingin merata, ada freezer kecil di dalam. Dipakai 1 tahun, kondisi normal jaya.',
            'price' => 750000,
            'condition' => 'Good',
            'category' => 'Dorm Life',
            'status' => 'Available',
            'image_urls' => [
                'https://images.unsplash.com/photo-1571175432240-a38f381c855a?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1536330263887-faab2b2a65d8?auto=format&fit=crop&w=600&q=80'
            ],
            'seller' => (object)[
                'name' => 'Dina - FK Unsoed',
                'avatar_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 5.0,
                'unsoed_faculty' => 'Kedokteran',
                'unsoed_major' => 'Pendidikan Dokter'
            ]
        ],
        [
            'id' => 5,
            'title' => 'Kalkulator Scientific Casio FX-991EX Classwiz',
            'description' => 'Kalkulator wajib untuk anak teknik/mipa/ekonomi. Fitur super lengkap, layar resolusi tinggi, bisa matriks, integral, diferensial. Baterai masih awet, bodi mulus.',
            'price' => 180000,
            'condition' => 'Like New',
            'category' => 'Electronics',
            'status' => 'Available',
            'image_urls' => [
                'https://images.unsplash.com/photo-1629904853716-f0bc54fea481?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1587145820266-a5951ee6f620?auto=format&fit=crop&w=600&q=80'
            ],
            'seller' => (object)[
                'name' => 'Galih - FT Unsoed',
                'avatar_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 4.6,
                'unsoed_faculty' => 'Teknik',
                'unsoed_major' => 'Teknik Sipil'
            ]
        ],
        [
            'id' => 6,
            'title' => 'Lampu Belajar LED IKEA Jansjo Flexibel',
            'description' => 'Lampu belajar leher fleksibel dari IKEA. Cahaya warm white nyaman di mata buat belajar begadang. Watt sangat kecil, colokan USB hemat daya.',
            'price' => 60000,
            'condition' => 'Well Used',
            'category' => 'Dorm Life',
            'status' => 'Available',
            'image_urls' => [
                'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1532372320978-9b4d7a92b24d?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?auto=format&fit=crop&w=600&q=80'
            ],
            'seller' => (object)[
                'name' => 'Siti - FH Unsoed',
                'avatar_url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 4.9,
                'unsoed_faculty' => 'Hukum',
                'unsoed_major' => 'Ilmu Hukum'
            ]
        ]
    ];
}

// Halaman Utama / Home (Menampilkan produk preloved)
Route::get('/', function () {
    $dbProducts = [];
    try {
        $dbProducts = Product::with('seller')
            ->where('status', 'Available')
            ->latest()
            ->get();
    } catch (\Exception $e) {
        // Fallback to empty if DB fails
    }

    $mocks = getMockProducts();
    // Map mocks to objects to look exactly like Eloquent collections
    $mockObjects = collect($mocks)->map(function ($item) {
        return (object)$item;
    });

    return view('home', compact('dbProducts', 'mockObjects'));
})->name('home');

// Halaman Login & Register
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Halaman Chat (In-App Messaging)
Route::get('/chat', function (\Illuminate\Http\Request $request) {
    $sellerId = $request->query('seller_id');
    $productId = $request->query('product_id');
    $seller = null;
    $product = null;

    if ($sellerId) {
        $seller = \App\Models\User::find($sellerId);
    }
    if ($productId) {
        $product = \App\Models\Product::find($productId);
    }

    return view('chat.index', [
        'seller' => $seller,
        'product' => $product,
    ]);
})->name('chat.index');

// ── Checkout (Beli Sekarang) ────────────────────────────────
Route::get('/checkout/{product}', [CheckoutController::class, 'index'])
    ->name('checkout.index');
Route::post('/checkout/{product}/process', [CheckoutController::class, 'processPayment'])
    ->name('checkout.process');

// Halaman Profil Mahasiswa
Route::get('/profile', function () {
    return view('profile.index');
})->name('profile.index');

// Halaman Dashboard Penjual (Seller)
Route::get('/seller/dashboard', function () {
    return view('seller.dashboard');
})->name('seller.dashboard');

// Halaman Dashboard Admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Halaman Upload Produk Baru
Route::get('/products/create', function () {
    return view('products.create');
})->name('products.create');

// Halaman Detail Produk
Route::get('/products/{product}', function (Product $product) {
    return view('products.show', ['product' => $product, 'isDb' => true]);
})->name('products.show');

// Halaman Keranjang Belanja
Route::get('/cart', function () {
    return view('cart.index');
})->name('cart.index');

// Halaman Riwayat Transaksi & Ulasan (diubah dari transactions.history ke transactions.riwayat)
Route::get('/transactions/history', function () {
    return view('transactions.riwayat');
})->name('transactions.history');

Route::get('/transactions/waiting', function () {
    return view('transactions.waiting');
})->name('transactions.waiting');

// ────────────────────────────────────────
// Payment Routes (Midtrans)
// ────────────────────────────────────────
Route::middleware('auth')->group(function () {
    // Show checkout page
    Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
    
    // Create snap token
    Route::post('/payment/create-snap-token', [PaymentController::class, 'createSnapToken'])->name('payment.create-snap-token');
    
    // Payment callbacks
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/pending', [PaymentController::class, 'paymentPending'])->name('payment.pending');
    Route::get('/payment/error', [PaymentController::class, 'paymentError'])->name('payment.error');
});

// Midtrans webhook (no auth needed)
Route::post('/payment/notification', [PaymentController::class, 'handleNotification'])->name('payment.notification');