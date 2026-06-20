@extends('layouts.app')

@section('content')
<!-- Header Page -->
<section class="bg-[#F5E4B0]/40 py-10 px-4 border-b border-[#D4A017]/15">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <span class="text-[10px] font-bold text-[#7A4A10] uppercase tracking-widest bg-[#7A4A10]/5 px-3 py-1 rounded-full border border-[#7A4A10]/15">Katalog Terbuka</span>
            <h1 class="text-3xl font-black text-[#2E1A06] font-heading mt-2">Daftar Produk Preloved</h1>
            <p class="text-xs text-[#7A4A10] mt-1 font-light">Temukan berbagai barang preloved berkualitas langsung dari sesama mahasiswa UNSOED</p>
        </div>
        
        <!-- Search Info / Filter Status -->
        <div id="search-info-container" class="hidden text-xs bg-[#7A4A10]/10 border border-[#7A4A10]/20 px-4 py-2.5 rounded-2xl text-[#7A4A10] font-medium items-center gap-2">
            <span>Pencarian aktif untuk:</span>
            <span id="search-query-badge" class="font-bold bg-[#7A4A10] text-[#FBF6EC] px-2 py-0.5 rounded-md"></span>
            <button onclick="clearSearchFilter()" class="hover:text-[#2E1A06] font-black ml-1">✕</button>
        </div>
    </div>
</section>

<!-- Filter Kategori & Grid Produk -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 pb-4 border-b border-[#D4A017]/20">
        <div>
            <h2 class="text-xl font-extrabold text-[#2E1A06] font-heading">Semua Barang</h2>
            <p class="text-xs text-[#7A4A10] mt-0.5">Filter berdasarkan kategori barang yang Anda cari</p>
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

<script>
    const dbProducts = @json($dbProducts ?? []);
    const mockProducts = @json($mockObjects ?? []);
    
    let currentCategory = 'All';
    let searchQuery = "{{ request('search', '') }}";

    function clearSearchFilter() {
        searchQuery = '';
        const navSearch = document.getElementById('navbar-search');
        const mobileNavSearch = document.getElementById('mobile-navbar-search');
        if (navSearch) navSearch.value = '';
        if (mobileNavSearch) mobileNavSearch.value = '';
        
        // Remove search query parameter from URL without reloading
        const url = new URL(window.location);
        url.searchParams.delete('search');
        window.history.pushState({}, '', url);

        updateSearchInfoBadge();
        renderProducts();
    }

    function updateSearchInfoBadge() {
        const infoContainer = document.getElementById('search-info-container');
        const queryBadge = document.getElementById('search-query-badge');
        
        if (searchQuery.trim() !== '') {
            if (queryBadge) queryBadge.textContent = searchQuery;
            if (infoContainer) infoContainer.classList.remove('hidden');
            if (infoContainer) infoContainer.classList.add('flex');
        } else {
            if (infoContainer) infoContainer.classList.remove('flex');
            if (infoContainer) infoContainer.classList.add('hidden');
        }
    }

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
        // Read URL search parameter for category and filter accordingly
        const urlParams = new URLSearchParams(window.location.search);
        const categoryParam = urlParams.get('category');
        if (categoryParam) {
            filterCategory(categoryParam);
        } else {
            filterCategory('All');
        }

        updateSearchInfoBadge();
        
        const navSearch = document.getElementById('navbar-search');
        const mobileNavSearch = document.getElementById('mobile-navbar-search');

        const syncSearch = (value) => {
            searchQuery = value;
            if (navSearch) navSearch.value = value;
            if (mobileNavSearch) mobileNavSearch.value = value;
            updateSearchInfoBadge();
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
