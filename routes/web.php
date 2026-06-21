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
            'condition' => 'Baru',
            'category' => 'Textbooks',
            'status' => 'Available',
            'image_urls' => ['https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80'],
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
            'condition' => 'Bekas',
            'category' => 'Electronics',
            'status' => 'Available',
            'image_urls' => ['https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80'],
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
            'condition' => 'Baru',
            'category' => 'Apparel',
            'status' => 'Available',
            'image_urls' => ['https://images.unsplash.com/photo-1598033129183-c4f50c736f10?auto=format&fit=crop&w=600&q=80'],
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
            'title' => 'Tumbler Stainless Steel Corkcicle 475ml',
            'description' => 'Tumbler Corkcicle original warna Matte Black. Menahan dingin hingga 25 jam, panas hingga 12 jam. Kondisi mulus 95%, hanya ada goresan halus di bagian bawah karena pemakaian wajar. Dus original masih ada.',
            'price' => 350000,
            'condition' => 'Bekas',
            'category' => 'Dorm Life',
            'status' => 'Available',
            'image_urls' => ['https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=600&q=80'],
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
            'title' => 'Keyboard Mechanical Rexus Legionare MX5.2',
            'description' => 'Keyboard mechanical dengan switch Outemu Blue (clicky). RGB backlighting normal, semua tombol berfungsi dengan baik dan tidak ada double click. Keycaps sudah dibersihkan secara menyeluruh. Lengkap dengan keycap puller dan box.',
            'price' => 220000,
            'condition' => 'Baru',
            'category' => 'Electronics',
            'status' => 'Available',
            'image_urls' => ['https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=600&q=80'],
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
            'condition' => 'Usang',
            'category' => 'Dorm Life',
            'status' => 'Available',
            'image_urls' => ['https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=600&q=80'],
            'seller' => (object)[
                'name' => 'Siti - FH Unsoed',
                'avatar_url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 4.9,
                'unsoed_faculty' => 'Hukum',
                'unsoed_major' => 'Ilmu Hukum'
            ]
        ],
        [
            'id' => 7,
            'title' => 'Tas Ransel Eiger Cordura 25L Navy',
            'description' => 'Tas ransel Eiger seri Cordura 25 liter warna Navy. Anti air, banyak kompartemen, ada slot laptop 14 inch. Kondisi 90%, tali masih kencang, resleting mulus. Cocok untuk kuliah atau hiking ringan.',
            'price' => 280000,
            'condition' => 'Bekas',
            'category' => 'Apparel',
            'status' => 'Available',
            'image_urls' => ['https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=600&q=80'],
            'seller' => (object)[
                'name' => 'Bagas - FISIP Unsoed',
                'avatar_url' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 4.7,
                'unsoed_faculty' => 'FISIP',
                'unsoed_major' => 'Ilmu Komunikasi'
            ]
        ],
        [
            'id' => 8,
            'title' => 'Sepatu Sneakers New Balance 574 Core Grey',
            'description' => 'New Balance 574 Core warna grey classic, size 42. Beli di toko resmi 3 bulan lalu, dipakai hanya 5x ke kampus. Masih sangat mulus, sol belum tipis, isi kotak original.',
            'price' => 550000,
            'condition' => 'Baru',
            'category' => 'Apparel',
            'status' => 'Available',
            'image_urls' => ['https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=80'],
            'seller' => (object)[
                'name' => 'Rizky - FEB Unsoed',
                'avatar_url' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 4.8,
                'unsoed_faculty' => 'Ekonomi dan Bisnis',
                'unsoed_major' => 'Akuntansi'
            ]
        ],
        [
            'id' => 9,
            'title' => 'Rice Cooker Mini Cosmos 0.6L Pink',
            'description' => 'Rice cooker mini kapasitas 0.6 liter, pas untuk 1-2 porsi. Hemat listrik hanya 150 watt, ada fungsi warm otomatis. Warna pink, mulus, cocok untuk penghuni kost putri.',
            'price' => 95000,
            'condition' => 'Bekas',
            'category' => 'Dorm Life',
            'status' => 'Available',
            'image_urls' => ['https://images.unsplash.com/photo-1585515320310-259814833e62?auto=format&fit=crop&w=600&q=80'],
            'seller' => (object)[
                'name' => 'Nadia - FIK Unsoed',
                'avatar_url' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 4.9,
                'unsoed_faculty' => 'Ilmu Kesehatan',
                'unsoed_major' => 'Keperawatan'
            ]
        ],
        [
            'id' => 10,
            'title' => 'Buku TOEFL Preparation Barron\'s 2023 Edition',
            'description' => 'Buku persiapan TOEFL Barron edisi 2023, lengkap dengan CD latihan soal. Kondisi sangat baik, hanya dibaca sekali. Dilengkapi tips & trik serta 6 full-length practice test.',
            'price' => 85000,
            'condition' => 'Baru',
            'category' => 'Textbooks',
            'status' => 'Available',
            'image_urls' => ['https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=600&q=80'],
            'seller' => (object)[
                'name' => 'Dewi - FIB Unsoed',
                'avatar_url' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 5.0,
                'unsoed_faculty' => 'Ilmu Budaya',
                'unsoed_major' => 'Sastra Inggris'
            ]
        ]
    ];
}

// Halaman Utama / Home (Menampilkan produk preloved)
Route::get('/', function () {
    $search = request('search');
    $dbProducts = [];
    try {
        $query = Product::with('seller')
            ->where('status', 'Available');
        
        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%');
        }
        
        $dbProducts = $query->latest()->get();
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

// Halaman Daftar Produk / Katalog
Route::get('/products', function () {
    $search = request('search');
    $dbProducts = [];
    try {
        $query = Product::with('seller')
            ->where('status', 'Available');
        
        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%');
        }
        
        $dbProducts = $query->latest()->get();
    } catch (\Exception $e) {
        // Fallback to empty if DB fails
    }

    $mocks = getMockProducts();
    // Map mocks to objects to look exactly like Eloquent collections
    $mockObjects = collect($mocks)->map(function ($item) {
        return (object)$item;
    });

    return view('products.index', compact('dbProducts', 'mockObjects'));
})->name('products.index');

// Halaman Tentang Kami
Route::get('/about', function () {
    return view('about');
})->name('about');

// Halaman Login & Register
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Halaman Chat (In-App Messaging)
Route::get('/chat', function () {
    return view('chat.index');
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
Route::get('/products/{id}', function ($id) {
    $product = null;
    $isDb = false;
    try {
        $product = Product::with('seller')->find($id);
        if ($product) {
            $isDb = true;
        }
    } catch (\Exception $e) {
        // DB error fallback
    }

    if (!$product) {
        $mocks = getMockProducts();
        $mock = collect($mocks)->firstWhere('id', (int)$id);
        if ($mock) {
            $product = (object)$mock;
            $isDb = false;
        }
    }

    if (!$product) {
        abort(404, 'Produk tidak ditemukan');
    }

    return view('products.show', compact('product', 'isDb'));
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