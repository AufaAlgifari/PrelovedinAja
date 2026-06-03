@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-tr from-slate-950 via-slate-900 to-slate-950 text-white py-20 px-4 overflow-hidden">
    <!-- Decorative abstract grids/glows -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b_1px,transparent_1px),linear-gradient(to_bottom,#1e293b_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-20"></div>
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 right-0 w-80 h-80 bg-brand-200/5 rounded-full blur-3xl"></div>

    <div class="max-w-5xl mx-auto text-center relative z-10 space-y-6">
        <span class="bg-brand-500/10 text-brand-400 text-xs px-4 py-2 rounded-full font-bold uppercase tracking-wider border border-brand-500/20">
            🎓 Pasar barang preloved unsoed purwokerto
        </span>
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight">
            Hemat Kantong, Peduli Lingkungan <br>
            <span class="gradient-text bg-gradient-to-r from-brand-300 to-brand-500">Preloved Berkualitas</span> Mahasiswa UNSOED
        </h1>
        <p class="max-w-2xl mx-auto text-slate-300 text-sm md:text-base leading-relaxed font-light">
            Temukan buku kuliah, elektronik, kebutuhan kos, hingga fashion dari sesama mahasiswa Unsoed. Transaksi mudah, aman, dan tanpa ongkir dengan sistem COD di kampus!
        </p>

        <!-- Search Form -->
        <div class="max-w-xl mx-auto pt-4">
            <form action="{{ route('home') }}" method="GET" class="relative flex items-center border border-slate-800 bg-slate-900/60 backdrop-blur-md rounded-2xl shadow-xl p-1.5 focus-within:border-brand-500 focus-within:ring-4 focus-within:ring-brand-500/20 transition-all duration-300">
                <span class="pl-4 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" id="home-search" value="{{ request('search') }}" placeholder="Cari kalkulator, buku praktikum, baju..." class="w-full pl-3 pr-4 text-sm text-slate-200 bg-transparent focus:outline-none">
                <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-slate-900 text-xs font-bold px-6 py-3 rounded-xl transition duration-200">Cari Barang</button>
            </form>
        </div>
    </div>
</section>

<!-- Filter Kategori & Grid Produk -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 pb-4 border-b border-slate-100">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Katalog Preloved Kampus</h2>
            <p class="text-xs text-slate-400 mt-1">Menampilkan barang preloved aktif milik mahasiswa UNSOED</p>
        </div>
        
        <!-- Filter Kategori Tabs -->
        <div class="flex flex-wrap items-center gap-2" id="category-filter-container">
            <button onclick="filterCategory('All')" class="category-tab active px-4 py-2 rounded-full text-xs font-bold border transition-all duration-200 bg-brand-500 border-brand-500 text-slate-900 shadow-sm" data-category="All">Semua</button>
            <button onclick="filterCategory('Textbooks')" class="category-tab px-4 py-2 rounded-full text-xs font-bold border border-slate-200 text-slate-600 bg-white hover:bg-brand-50 transition-all duration-200" data-category="Textbooks">📚 Buku Kuliah</button>
            <button onclick="filterCategory('Electronics')" class="category-tab px-4 py-2 rounded-full text-xs font-bold border border-slate-200 text-slate-600 bg-white hover:bg-brand-50 transition-all duration-200" data-category="Electronics">🔌 Elektronik</button>
            <button onclick="filterCategory('Dorm Life')" class="category-tab px-4 py-2 rounded-full text-xs font-bold border border-slate-200 text-slate-600 bg-white hover:bg-brand-50 transition-all duration-200" data-category="Dorm Life">🏠 Peralatan Kost</button>
            <button onclick="filterCategory('Apparel')" class="category-tab px-4 py-2 rounded-full text-xs font-bold border border-slate-200 text-slate-600 bg-white hover:bg-brand-50 transition-all duration-200" data-category="Apparel">👕 Fashion</button>
        </div>
    </div>

    <!-- Product Grid -->
    <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <!-- Products will be dynamically populated here via Javascript (combining DB, Mocks, and LocalStorage) -->
    </div>

    <!-- Empty State -->
    <div id="empty-state" class="hidden py-16 text-center">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 text-2xl">🔍</div>
        <h3 class="text-base font-bold text-slate-800">Barang tidak ditemukan</h3>
        <p class="text-xs text-slate-400 mt-1">Coba cari kata kunci lain atau ubah kategori filter Anda.</p>
    </div>
</section>

<!-- Berjualan di Kampus Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 mb-16">
    <div class="bg-gradient-to-r from-slate-900 via-brand-900/30 to-slate-950 border border-brand-500/20 rounded-3xl p-8 md:p-12 text-white grid grid-cols-1 md:grid-cols-2 gap-8 items-center relative overflow-hidden shadow-xl shadow-brand-500/5">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-brand-500/5 rounded-full blur-2xl"></div>
        <div class="z-10 space-y-6">
            <span class="bg-brand-500/10 text-brand-400 text-[10px] px-3.5 py-1 rounded-full font-bold uppercase tracking-wider border border-brand-500/20">
                Punya barang tak terpakai di kost?
            </span>
            <h3 class="text-3xl font-extrabold leading-tight">Mulai Jual Barang Preloved Anda & Dapatkan Uang Tambahan!</h3>
            <p class="text-sm text-slate-300 font-light leading-relaxed">
                Ubah buku semester lalu, baju lama, atau elektronik lama menjadi uang saku. Sangat mudah, cukup upload gambar, tentukan harga, dan ketemuan di kampus!
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('products.create') }}" class="px-6 py-3 bg-brand-500 hover:bg-brand-600 text-slate-900 font-bold text-xs rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                    ➕ Mulai Jual Sekarang
                </a>
                <a href="#" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-xl border border-slate-700 transition">
                    Pelajari Cara Kerja
                </a>
            </div>
        </div>
        
        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10 flex flex-col space-y-4 relative z-10">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-brand-100 rounded-full flex items-center justify-center text-brand-700 font-bold text-sm">
                    AF
                </div>
                <div class="flex-1">
                    <div class="text-xs font-bold text-slate-200">Aufa Algifari - Teknik</div>
                    <div class="text-[10px] text-brand-300">Teknik Informatika '24</div>
                </div>
                <span class="text-amber-300 text-xs">⭐ 5.0</span>
            </div>
            <div class="border-t border-white/10 pt-3">
                <div class="text-xs italic text-brand-50 font-light">"Kemarin jual meja lipat belajar dan kalkulator lama yang sudah tidak kepakai. Langsung laku dalam sehari COD di depan Perpustakaan Unsoed. Sangat praktis!"</div>
            </div>
        </div>
    </div>
</section>

<!-- Script penanganan data dinamis di Beranda -->
<script>
    // Database and Mock data sourced from backend php variables
    const dbProducts = @json($dbProducts ?? []);
    const mockProducts = @json($mockObjects ?? []);
    
    // Global filter state
    let currentCategory = 'All';
    let searchQuery = "{{ request('search', '') }}";

    function filterCategory(cat) {
        currentCategory = cat;
        
        // Update tab active state
        document.querySelectorAll('.category-tab').forEach(tab => {
            if(tab.getAttribute('data-category') === cat) {
                tab.className = "category-tab active px-4 py-2 rounded-full text-xs font-bold border transition-all duration-200 bg-brand-500 border-brand-500 text-slate-900 shadow-sm";
            } else {
                tab.className = "category-tab px-4 py-2 rounded-full text-xs font-bold border border-slate-200 text-slate-600 bg-white hover:bg-brand-50 transition-all duration-200";
            }
        });

        renderProducts();
    }

    function renderProducts() {
        const grid = document.getElementById('product-grid');
        const emptyState = document.getElementById('empty-state');
        
        // Get custom uploaded products from localStorage
        const customProducts = JSON.parse(localStorage.getItem('preloved_custom_products') || '[]');

        // Combine all data sources
        // Map database products to matching format
        const formattedDb = dbProducts.map(p => ({
            id: p.id,
            title: p.title,
            description: p.description,
            price: p.price,
            condition: p.condition,
            category: p.category,
            status: p.status,
            image_urls: p.image_urls,
            seller: p.seller || { name: 'Mahasiswa Unsoed', rating_cache: 4.8 }
        }));

        // Format custom products from localStorage
        const formattedCustom = customProducts.map(p => ({
            id: p.id,
            title: p.title,
            description: p.description,
            price: parseInt(p.price),
            condition: p.condition,
            category: p.category,
            status: 'Available',
            image_urls: p.image_urls || [p.image || 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80'],
            seller: p.seller || { name: 'Anda (Penjual)', rating_cache: 5.0, unsoed_faculty: 'Mhs', unsoed_major: 'Unsoed' }
        }));

        // Merge: Custom products first (newest), then database products, then mock products
        let allProducts = [...formattedCustom, ...formattedDb, ...mockProducts];

        // Apply Search Filter
        if (searchQuery.trim() !== '') {
            const query = searchQuery.toLowerCase();
            allProducts = allProducts.filter(p => 
                p.title.toLowerCase().includes(query) || 
                p.description.toLowerCase().includes(query)
            );
        }

        // Apply Category Filter
        if (currentCategory !== 'All') {
            allProducts = allProducts.filter(p => p.category === currentCategory);
        }

        // Render to DOM
        grid.innerHTML = '';
        
        if (allProducts.length === 0) {
            grid.classList.add('hidden');
            emptyState.classList.remove('hidden');
            return;
        }

        grid.classList.remove('hidden');
        emptyState.classList.add('hidden');

        allProducts.forEach(p => {
            // Price formatter
            const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(p.price);
            
            // Condition badges colors
            let badgeClass = 'bg-slate-100 text-slate-700';
            if(p.condition === 'New') badgeClass = 'bg-purple-50 text-purple-700 border-purple-100';
            else if(p.condition === 'Like New') badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
            else if(p.condition === 'Good') badgeClass = 'bg-brand-50 text-brand-800 border-brand-200';
            else if(p.condition === 'Well Used') badgeClass = 'bg-amber-50 text-amber-700 border-amber-100';

            const imageUrl = p.image_urls && p.image_urls.length > 0 ? p.image_urls[0] : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';
            const rating = p.seller && p.seller.rating_cache ? p.seller.rating_cache : '4.8';
            const sellerName = p.seller ? p.seller.name : 'Mahasiswa Unsoed';

            const card = document.createElement('div');
            card.className = "bg-white rounded-3xl border border-slate-100/80 shadow-sm overflow-hidden flex flex-col justify-between card-premium hover:shadow-lg relative group";
            
            // Generate link for product detail
            const detailUrl = `/products/${p.id}`;

            card.innerHTML = `
                <!-- Condition Badge -->
                <span class="absolute top-4 left-4 z-10 px-3 py-1.5 border rounded-full text-[10px] font-extrabold uppercase tracking-wider shadow-sm ${badgeClass}">
                    ${p.condition}
                </span>

                <!-- Image Area -->
                <a href="${detailUrl}" class="block aspect-square w-full bg-slate-50 overflow-hidden relative">
                    <img src="${imageUrl}" alt="${p.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                    <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-all"></div>
                </a>

                <!-- Details Content -->
                <div class="p-5 flex-grow flex flex-col justify-between">
                    <div>
                        <!-- Seller Info -->
                        <div class="flex items-center justify-between text-[10px] text-slate-400 font-bold mb-2">
                            <span class="truncate max-w-[120px]">👤 ${sellerName}</span>
                            <span>⭐ ${rating}</span>
                        </div>
                        
                        <!-- Title -->
                        <h4 class="font-bold text-slate-800 text-sm hover:text-brand-600 transition line-clamp-2 leading-snug">
                            <a href="${detailUrl}">${p.title}</a>
                        </h4>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-50 flex items-center justify-between">
                        <div>
                            <span class="text-[9px] font-bold text-slate-400 block uppercase">Harga</span>
                            <span class="text-sm font-extrabold text-brand-600">${formattedPrice}</span>
                        </div>
                        
                        <!-- Add to Cart quick button -->
                        <button onclick="quickAddCart(event, ${JSON.stringify(p).replace(/"/g, '&quot;')})" 
                                class="p-2.5 bg-brand-50 text-brand-700 hover:bg-brand-500 hover:text-slate-900 rounded-xl shadow-sm transition-all duration-200 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    function quickAddCart(event, product) {
        event.preventDefault();
        event.stopPropagation();
        window.addToCart(product);
    }

    // Render initially
    window.addEventListener('DOMContentLoaded', () => {
        renderProducts();
        
        // Listen to navbar live search if elements exist
        const navSearch = document.getElementById('navbar-search');
        if (navSearch) {
            navSearch.value = searchQuery;
            navSearch.addEventListener('input', (e) => {
                searchQuery = e.target.value;
                renderProducts();
            });
        }

        const homeSearch = document.getElementById('home-search');
        if (homeSearch) {
            homeSearch.addEventListener('input', (e) => {
                searchQuery = e.target.value;
                if(navSearch) navSearch.value = searchQuery;
                renderProducts();
            });
        }
    });
</script>
@endsection