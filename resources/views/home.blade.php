@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-[#F5E4B0]/60 text-[#2E1A06] py-20 px-4 overflow-hidden border-b border-[#D4A017]/20">
    <!-- Decorative abstract grids/glows -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(212,160,23,0.06)_1px,transparent_1px),linear-gradient(to_bottom,rgba(212,160,23,0.06)_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-40"></div>
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#D4A017]/10 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 right-0 w-80 h-80 bg-[#7A4A10]/5 rounded-full blur-3xl"></div>

    <div class="max-w-5xl mx-auto text-center relative z-10 space-y-6">
        <span class="bg-[#7A4A10]/10 text-[#7A4A10] text-[11px] px-5 py-2 rounded-full font-bold uppercase tracking-wider border border-[#7A4A10]/20">
            Pasar Preloved Kampus Unsoed
        </span>
        <h1 class="text-4xl md:text-6xl font-black tracking-tight leading-tight font-heading">
            Hemat Kantong, Peduli Lingkungan <br>
            <span class="gradient-text bg-gradient-to-r from-[#D4A017] to-[#7A4A10]">Preloved Berkualitas</span> Mahasiswa UNSOED
        </h1>
        <p class="max-w-2xl mx-auto text-[#2E1A06]/85 text-sm md:text-base leading-relaxed font-light">
            Temukan buku kuliah, elektronik, kebutuhan kos, hingga fashion dari sesama mahasiswa Unsoed. Transaksi mudah, aman, dan tanpa ongkir dengan sistem COD di kampus!
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-wrap justify-center gap-4 pt-4">
            <a href="#catalog-section" class="px-8 py-3.5 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-extrabold text-sm rounded-full shadow-md hover:shadow-lg transition-all duration-350 transform hover:-translate-y-0.5">
                Mulai Belanja
            </a>
            <a href="{{ route('products.create') }}" class="px-8 py-3.5 bg-transparent hover:bg-[#7A4A10]/5 text-[#7A4A10] border-2 border-[#7A4A10] font-extrabold text-sm rounded-full transition-all duration-350">
                Jual Barang
            </a>
        </div>
    </div>
</section>

<!-- Filter Kategori & Grid Produk -->
<section id="catalog-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 scroll-mt-24">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 pb-4 border-b border-[#D4A017]/20">
        <div>
            <h2 class="text-2xl font-black text-[#2E1A06] font-heading">Katalog Preloved Kampus</h2>
            <p class="text-xs text-[#7A4A10] mt-1">Menampilkan barang preloved aktif milik mahasiswa UNSOED</p>
        </div>
        
        <!-- Filter Kategori Tabs -->
        <div class="flex flex-wrap items-center gap-2" id="category-filter-container">
            <button onclick="filterCategory('All')" class="category-tab active px-4 py-2 rounded-full text-xs font-bold border transition-all duration-200 bg-[#7A4A10] border-[#7A4A10] text-[#FBF6EC] shadow-sm" data-category="All">Semua</button>
            <button onclick="filterCategory('Textbooks')" class="category-tab px-4 py-2 rounded-full text-xs font-bold border border-[#D4A017]/35 text-[#2E1A06] bg-[#FBF6EC] hover:bg-[#F5E4B0] transition-all duration-200" data-category="Textbooks">Buku Kuliah</button>
            <button onclick="filterCategory('Electronics')" class="category-tab px-4 py-2 rounded-full text-xs font-bold border border-[#D4A017]/35 text-[#2E1A06] bg-[#FBF6EC] hover:bg-[#F5E4B0] transition-all duration-200" data-category="Electronics">Elektronik</button>
            <button onclick="filterCategory('Dorm Life')" class="category-tab px-4 py-2 rounded-full text-xs font-bold border border-[#D4A017]/35 text-[#2E1A06] bg-[#FBF6EC] hover:bg-[#F5E4B0] transition-all duration-200" data-category="Dorm Life">Peralatan Kost</button>
            <button onclick="filterCategory('Apparel')" class="category-tab px-4 py-2 rounded-full text-xs font-bold border border-[#D4A017]/35 text-[#2E1A06] bg-[#FBF6EC] hover:bg-[#F5E4B0] transition-all duration-200" data-category="Apparel">Fashion</button>
        </div>
    </div>

    <!-- Product Grid: 2 columns on mobile, 3 on tablet, 4 on desktop -->
    <div id="product-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-8">
        <!-- Products will be dynamically populated here via Javascript (combining DB, Mocks, and LocalStorage) -->
    </div>

    <!-- Empty State -->
    <div id="empty-state" class="hidden py-16 text-center">
        <div class="w-16 h-16 bg-[#F5E4B0] rounded-full flex items-center justify-center mx-auto mb-4 text-[#7A4A10] text-2xl">🔍</div>
        <h3 class="text-base font-bold text-[#2E1A06]">Barang tidak ditemukan</h3>
        <p class="text-xs text-[#7A4A10] mt-1">Coba cari kata kunci lain atau ubah kategori filter Anda.</p>
    </div>
</section>

<!-- Berjualan di Kampus Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 mb-16">
    <div class="bg-[#2E1A06] border border-[#7A4A10]/20 rounded-3xl p-8 md:p-12 text-[#FBF6EC] grid grid-cols-1 md:grid-cols-2 gap-8 items-center relative overflow-hidden shadow-xl">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-[#D4A017]/5 rounded-full blur-2xl"></div>
        <div class="z-10 space-y-6">
            <span class="bg-[#F5E4B0]/10 text-[#F5E4B0] text-[10px] px-3.5 py-1 rounded-full font-bold uppercase tracking-wider border border-[#F5E4B0]/20">
                Punya barang tak terpakai di kost?
            </span>
            <h3 class="text-3xl font-black leading-tight font-heading">Mulai Jual Barang Preloved Anda & Dapatkan Uang Tambahan!</h3>
            <p class="text-sm text-[#FBF6EC]/70 font-light leading-relaxed">
                Ubah buku semester lalu, baju lama, atau elektronik lama menjadi uang saku. Sangat mudah, cukup upload gambar, tentukan harga, dan ketemuan di kampus!
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('products.create') }}" class="px-6 py-3 bg-[#D4A017] hover:bg-[#b88910] text-[#2E1A06] font-bold text-xs rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                    ➕ Mulai Jual Sekarang
                </a>
                <a href="#" class="px-6 py-3 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-bold text-xs rounded-xl border border-[#D4A017]/30 transition">
                    Pelajari Cara Kerja
                </a>
            </div>
        </div>
        
        <div class="bg-[#FBF6EC]/5 backdrop-blur-md rounded-2xl p-6 border border-[#FBF6EC]/10 flex flex-col space-y-4 relative z-10 text-[#FBF6EC]">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-[#D4A017] text-[#2E1A06] rounded-full flex items-center justify-center font-bold text-sm">
                    AF
                </div>
                <div class="flex-1">
                    <div class="text-xs font-bold text-[#FBF6EC]">Aufa Algifari - Teknik</div>
                    <div class="text-[10px] text-[#F5E4B0]">Teknik Informatika '24</div>
                </div>
                <span class="text-[#D4A017] text-xs">⭐ 5.0</span>
            </div>
            <div class="border-t border-[#FBF6EC]/10 pt-3">
                <div class="text-xs italic text-[#FBF6EC]/85 font-light">"Kemarin jual meja lipat belajar dan kalkulator lama yang sudah tidak kepakai. Langsung laku dalam sehari COD di depan Perpustakaan Unsoed. Sangat praktis!"</div>
            </div>
        </div>
    </div>
</section>

<script>
    const dbProducts = @json($dbProducts ?? []);
    const mockProducts = @json($mockObjects ?? []);
    
    let currentCategory = 'All';
    let searchQuery = "{{ request('search', '') }}";

    function filterCategory(cat) {
        currentCategory = cat;
        
        document.querySelectorAll('.category-tab').forEach(tab => {
            if(tab.getAttribute('data-category') === cat) {
                tab.className = "category-tab active px-4 py-2 rounded-full text-xs font-bold border transition-all duration-200 bg-[#7A4A10] border-[#7A4A10] text-[#FBF6EC] shadow-sm";
            } else {
                tab.className = "category-tab px-4 py-2 rounded-full text-xs font-bold border border-[#D4A017]/35 text-[#2E1A06] bg-[#FBF6EC] hover:bg-[#F5E4B0] transition-all duration-200";
            }
        });

        renderProducts();
    }

    function renderProducts() {
        const grid = document.getElementById('product-grid');
        const emptyState = document.getElementById('empty-state');
        
        const customProducts = JSON.parse(localStorage.getItem('preloved_custom_products') || '[]');

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

        const formattedCustom = customProducts.map(p => ({
            id: p.id,
            title: p.title,
            description: p.description,
            price: parseInt(p.price),
            condition: p.condition,
            category: p.category,
            status: 'Available',
            image_urls: p.image_urls || [p.image || 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80'],
            seller: p.seller || { name: 'Anda', rating_cache: 5.0, unsoed_faculty: 'Mhs', unsoed_major: 'Unsoed' }
        }));

        let allProducts = [...formattedCustom, ...formattedDb, ...mockProducts];

        if (searchQuery.trim() !== '') {
            const query = searchQuery.toLowerCase();
            allProducts = allProducts.filter(p => 
                p.title.toLowerCase().includes(query) || 
                p.description.toLowerCase().includes(query)
            );
        }

        if (currentCategory !== 'All') {
            allProducts = allProducts.filter(p => p.category === currentCategory);
        }

        grid.innerHTML = '';
        
        if (allProducts.length === 0) {
            grid.classList.add('hidden');
            emptyState.classList.remove('hidden');
            return;
        }

        grid.classList.remove('hidden');
        emptyState.classList.add('hidden');

        allProducts.forEach(p => {
            const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(p.price);
            
            let badgeClass = 'bg-[#FBF6EC] text-[#2E1A06] border-[#D4A017]/35';
            if(p.condition === 'New') badgeClass = 'bg-[#7A4A10] text-[#FBF6EC] border-[#7A4A10]';
            else if(p.condition === 'Like New') badgeClass = 'bg-[#D4A017] text-[#2E1A06] border-[#D4A017]';
            else if(p.condition === 'Good') badgeClass = 'bg-[#FBF6EC] text-[#7A4A10] border-[#D4A017]/30';
            else if(p.condition === 'Well Used') badgeClass = 'bg-transparent text-[#2E1A06] border-[#2E1A06]/30';

            const imageUrl = p.image_urls && p.image_urls.length > 0 ? p.image_urls[0] : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';
            const rating = p.seller && p.seller.rating_cache ? p.seller.rating_cache : '4.8';
            const sellerName = p.seller ? p.seller.name : 'Mahasiswa Unsoed';
            const isVerified = p.seller && p.seller.is_verified ? '<span class="text-[8px] bg-[#7A4A10] text-[#FBF6EC] px-1 rounded-full ml-1">✓</span>' : '';

            const card = document.createElement('div');
            card.className = "bg-[#F5E4B0] rounded-3xl border border-[#D4A017]/20 shadow-sm overflow-hidden flex flex-col justify-between card-premium hover:shadow-lg relative group";
            
            const detailUrl = `/products/${p.id}`;

            card.innerHTML = `
                <span class="absolute top-3 left-3 z-10 px-2.5 py-1 border rounded-full text-[9px] font-extrabold uppercase tracking-wider shadow-sm ${badgeClass}">
                    ${p.condition}
                </span>

                <a href="${detailUrl}" class="block aspect-square w-full bg-[#FBF6EC] overflow-hidden relative">
                    <img src="${imageUrl}" alt="${p.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                    <div class="absolute inset-0 bg-[#2E1A06]/5 group-hover:bg-transparent transition-all"></div>
                </a>

                <div class="p-3 sm:p-5 flex-grow flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-[9px] text-[#7A4A10] font-bold mb-1.5">
                            <span class="truncate max-w-[100px] flex items-center">${sellerName} ${isVerified}</span>
                            <span>★ ${rating}</span>
                        </div>
                        
                        <h4 class="font-extrabold text-[#2E1A06] text-xs sm:text-sm hover:text-[#7A4A10] transition line-clamp-2 leading-snug font-heading">
                            <a href="${detailUrl}">${p.title}</a>
                        </h4>
                    </div>

                    <div class="mt-4 pt-3 border-t border-[#D4A017]/10 flex items-center justify-between">
                        <div>
                            <span class="text-[8px] font-bold text-[#7A4A10] block uppercase">Harga</span>
                            <span class="text-xs sm:text-sm font-black text-[#7A4A10]">${formattedPrice}</span>
                        </div>
                        
                        <button onclick="quickAddCart(event, ${JSON.stringify(p).replace(/"/g, '&quot;')})" 
                                class="p-2 bg-[#FBF6EC] text-[#7A4A10] border border-[#D4A017]/30 hover:bg-[#7A4A10] hover:text-[#FBF6EC] rounded-xl shadow-sm transition-all duration-200 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    window.addEventListener('DOMContentLoaded', () => {
        renderProducts();
        
        const navSearch = document.getElementById('navbar-search');
        const mobileNavSearch = document.getElementById('mobile-navbar-search');

        const syncSearch = (value) => {
            searchQuery = value;
            if (navSearch) navSearch.value = value;
            if (mobileNavSearch) mobileNavSearch.value = value;
            renderProducts();
        };

        if (navSearch) {
            navSearch.value = searchQuery;
            navSearch.addEventListener('input', (e) => syncSearch(e.target.value));
        }

        if (mobileNavSearch) {
            mobileNavSearch.value = searchQuery;
            mobileNavSearch.addEventListener('input', (e) => syncSearch(e.target.value));
        }
    });
</script>
@endsection