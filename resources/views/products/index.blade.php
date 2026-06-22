@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FBF6EC] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-10">
        
        <!-- Header Page -->
        <div class="space-y-4">
            <div>
                <h1 class="text-3xl font-black text-[#2E1A06] font-heading">Cari Barang Preloved</h1>
                <p class="text-xs text-[#7A4A10] mt-1 font-medium">Temukan kebutuhan kampusmu dengan harga terbaik</p>
            </div>
            
            <!-- Search Bar + Reset Button -->
            <div class="flex items-center gap-3 w-full">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#7A4A10]/70">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" id="page-search" placeholder="Cari buku kuliah, laptop, perlengkapan kost..." oninput="handleSearch(event)"
                           class="w-full pl-11 pr-4 py-3.5 bg-[#F5E4B0]/40 hover:bg-white text-sm text-[#2E1A06] placeholder-[#7A4A10]/50 rounded-full border border-[#D4A017]/30 focus:border-[#7A4A10] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#7A4A10]/10 transition-all duration-200">
                </div>
                <button onclick="clearSearchFilter()" class="px-6 py-3.5 bg-[#FBF6EC] hover:bg-[#F5E4B0] text-[#7A4A10] border border-[#D4A017]/30 font-bold text-xs rounded-full transition shadow-sm shrink-0">
                    Reset
                </button>
            </div>
        </div>

        <!-- 2 Column Layout -->
        <div class="flex flex-col md:flex-row gap-8 items-start">
            
            <!-- Sidebar Kiri -->
            <div class="w-full md:w-64 lg:w-72 shrink-0 space-y-8 bg-transparent">
                <!-- Kategori -->
                <div class="space-y-3">
                    <h3 class="text-xs font-black text-[#2E1A06] uppercase tracking-wider font-heading">Kategori</h3>
                    <div class="flex flex-col gap-1.5" id="category-filter-list">
                        <!-- Semua Barang -->
                        <button onclick="filterCategory('All')" id="cat-all" class="category-item w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold text-[#2E1A06] bg-[#F5E4B0]/80 border border-[#D4A017]/30 hover:bg-[#F5E4B0] transition-all">
                            <svg class="w-4 h-4 text-[#7A4A10]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            <span>Semua Barang</span>
                        </button>
                        <!-- Buku -->
                        <button onclick="filterCategory('Textbooks')" id="cat-textbooks" class="category-item w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-semibold text-[#2E1A06]/70 border border-transparent hover:bg-[#F5E4B0]/30 transition-all">
                            <svg class="w-4 h-4 text-[#7A4A10]/70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.254.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span>Buku</span>
                        </button>
                        <!-- Elektronik -->
                        <button onclick="filterCategory('Electronics')" id="cat-electronics" class="category-item w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-semibold text-[#2E1A06]/70 border border-transparent hover:bg-[#F5E4B0]/30 transition-all">
                            <svg class="w-4 h-4 text-[#7A4A10]/70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>Elektronik</span>
                        </button>
                        <!-- Pakaian -->
                        <button onclick="filterCategory('Apparel')" id="cat-apparel" class="category-item w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-semibold text-[#2E1A06]/70 border border-transparent hover:bg-[#F5E4B0]/30 transition-all">
                            <svg class="w-4 h-4 text-[#7A4A10]/70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14v14M4 7v10l8 4"></path>
                            </svg>
                            <span>Pakaian</span>
                        </button>
                        <!-- Furnitur -->
                        <button onclick="filterCategory('Dorm Life')" id="cat-dorm" class="category-item w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-semibold text-[#2E1A06]/70 border border-transparent hover:bg-[#F5E4B0]/30 transition-all">
                            <svg class="w-4 h-4 text-[#7A4A10]/70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span>Furnitur</span>
                        </button>
                    </div>
                </div>

                <!-- Lokasi Fakultas -->
                <div class="space-y-3">
                    <h3 class="text-xs font-black text-[#2E1A06] uppercase tracking-wider font-heading">Lokasi Fakultas</h3>
                    <select id="faculty-filter" onchange="handleFacultyChange(event)"
                            class="w-full px-3 py-2.5 bg-[#FBF6EC] border border-[#D4A017]/35 rounded-xl text-xs font-semibold text-[#2E1A06] focus:border-[#7A4A10] focus:outline-none">
                        <option value="All">Semua Fakultas</option>
                        <option value="Fakultas Pertanian">Fakultas Pertanian</option>
                        <option value="Fakultas Biologi">Fakultas Biologi</option>
                        <option value="Fakultas Ekonomi dan Bisnis">Fakultas Ekonomi dan Bisnis</option>
                        <option value="Fakultas Peternakan">Fakultas Peternakan</option>
                        <option value="Fakultas Hukum">Fakultas Hukum</option>
                        <option value="Fakultas Ilmu Sosial dan Ilmu Politik">Fakultas Ilmu Sosial dan Ilmu Politik</option>
                        <option value="Fakultas Kedokteran">Fakultas Kedokteran</option>
                        <option value="Fakultas Teknik">Fakultas Teknik</option>
                        <option value="Fakultas Ilmu-ilmu Kesehatan">Fakultas Ilmu-ilmu Kesehatan</option>
                        <option value="Fakultas Ilmu Budaya">Fakultas Ilmu Budaya</option>
                        <option value="Fakultas MIPA">Fakultas MIPA</option>
                        <option value="Fakultas Perikanan dan Ilmu Kelautan">Fakultas Perikanan dan Ilmu Kelautan</option>
                    </select>
                </div>

                <!-- Rentang Harga -->
                <div class="space-y-3">
                    <h3 class="text-xs font-black text-[#2E1A06] uppercase tracking-wider font-heading">Rentang Harga</h3>
                    <div class="flex items-center gap-2">
                        <div>
                            <label class="block text-[9px] font-bold text-[#7A4A10] uppercase mb-1">Min</label>
                            <input type="number" id="price-min" placeholder="Min"
                                   class="w-full px-3 py-2.5 bg-[#FBF6EC] border border-[#D4A017]/35 rounded-xl text-xs text-[#2E1A06] placeholder-[#7A4A10]/40 focus:border-[#7A4A10] focus:outline-none">
                        </div>
                        <span class="text-[#7A4A10] mt-4">—</span>
                        <div>
                            <label class="block text-[9px] font-bold text-[#7A4A10] uppercase mb-1">Max</label>
                            <input type="number" id="price-max" placeholder="Max"
                                   class="w-full px-3 py-2.5 bg-[#FBF6EC] border border-[#D4A017]/35 rounded-xl text-xs text-[#2E1A06] placeholder-[#7A4A10]/40 focus:border-[#7A4A10] focus:outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        <button onclick="applyPriceFilter()" class="py-2 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-bold text-xs rounded-xl shadow-sm transition">
                            Cari
                        </button>
                        <button onclick="resetPriceFilter()" class="py-2 bg-[#FBF6EC] hover:bg-[#F5E4B0] text-[#7A4A10] border border-[#D4A017]/30 font-bold text-xs rounded-xl transition">
                            Reset
                        </button>
                    </div>
                </div>

                <!-- Kondisi -->
                <div class="space-y-3">
                    <h3 class="text-xs font-black text-[#2E1A06] uppercase tracking-wider font-heading">Kondisi</h3>
                    <div class="flex flex-wrap gap-2" id="condition-filter-container">
                        <button onclick="toggleCondition('Baru')" id="cond-Baru" class="condition-chip px-4 py-2 rounded-xl text-xs font-bold border border-[#D4A017]/30 bg-transparent text-[#2E1A06]/75 hover:bg-[#F5E4B0]/40 transition duration-150">
                            Baru
                        </button>
                        <button onclick="toggleCondition('Bekas')" id="cond-Bekas" class="condition-chip px-4 py-2 rounded-xl text-xs font-bold border border-[#D4A017]/30 bg-transparent text-[#2E1A06]/75 hover:bg-[#F5E4B0]/40 transition duration-150">
                            Bekas
                        </button>
                        <button onclick="toggleCondition('Usang')" id="cond-Usang" class="condition-chip px-4 py-2 rounded-xl text-xs font-bold border border-[#D4A017]/30 bg-transparent text-[#2E1A06]/75 hover:bg-[#F5E4B0]/40 transition duration-150">
                            Usang
                        </button>
                    </div>
                </div>

                <!-- Jual Barang Button -->
                <div class="pt-4">
                    <button onclick="handleSellButtonClick(event)" class="w-full py-3.5 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-bold text-xs rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a1.414 1.414 0 002 .001l4.9-4.9a1.414 1.414 0 000-2l-9.58-9.58a2.25 2.25 0 00-1.591-.659zM6 6h.008v.008H6V6z" />
                        </svg>
                        <span>Jual Barang</span>
                    </button>
                </div>
            </div>

            <!-- Area Grid & Pagination -->
            <div class="flex-1 space-y-8 w-full">
                <!-- Grid Produk -->
                <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Dynamic rendering -->
                </div>

                <!-- Empty State -->
                <div id="empty-state" class="hidden py-16 text-center bg-white/40 border border-[#D4A017]/15 rounded-3xl">
                    <div class="w-16 h-16 bg-[#F5E4B0]/80 rounded-full flex items-center justify-center mx-auto mb-4 text-[#7A4A10] text-2xl">🔍</div>
                    <h3 class="text-base font-bold text-[#2E1A06] font-heading">Barang tidak ditemukan</h3>
                    <p class="text-xs text-[#7A4A10] mt-1 font-light">Coba cari kata kunci lain atau sesuaikan filter Anda.</p>
                </div>

                <!-- Pagination -->
                <div id="pagination-container" class="flex justify-center items-center gap-2 pt-6">
                    <!-- Dynamic rendering -->
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const dbProducts = @json($dbProducts ?? []);
    const mockProducts = @json($mockObjects ?? []);

    let currentCategory = 'All';
    let searchQuery = '';
    let minPrice = null;
    let maxPrice = null;
    let selectedCondition = null;
    let selectedFaculty = 'All';
    let currentPage = 1;
    const itemsPerPage = 6;
    let renderedProductsCache = [];

    window.addEventListener('DOMContentLoaded', () => {
        // Read URL parameters on load
        const urlParams = new URLSearchParams(window.location.search);
        
        const catParam = urlParams.get('category');
        if (catParam) currentCategory = catParam;
        
        const searchParam = urlParams.get('search');
        if (searchParam) {
            searchQuery = searchParam;
            document.getElementById('page-search').value = searchParam;
        }

        renderCategorySidebar();
        renderConditionFilter();
        renderProducts();
    });

    function handleSearch(e) {
        searchQuery = e.target.value;
        currentPage = 1;
        renderProducts();
    }

    function clearSearchFilter() {
        searchQuery = '';
        document.getElementById('page-search').value = '';
        
        // Reset faculty filter
        selectedFaculty = 'All';
        const facultySelect = document.getElementById('faculty-filter');
        if (facultySelect) facultySelect.value = 'All';

        currentPage = 1;
        renderProducts();
    }

    function applyPriceFilter() {
        const minVal = document.getElementById('price-min').value;
        const maxVal = document.getElementById('price-max').value;
        minPrice = minVal ? parseInt(minVal) : null;
        maxPrice = maxVal ? parseInt(maxVal) : null;
        currentPage = 1;
        renderProducts();
    }

    function resetPriceFilter() {
        document.getElementById('price-min').value = '';
        document.getElementById('price-max').value = '';
        minPrice = null;
        maxPrice = null;
        
        // Reset faculty filter
        selectedFaculty = 'All';
        const facultySelect = document.getElementById('faculty-filter');
        if (facultySelect) facultySelect.value = 'All';

        currentPage = 1;
        renderProducts();
    }

    function handleFacultyChange(e) {
        selectedFaculty = e.target.value;
        currentPage = 1;
        renderProducts();
    }

    function filterCategory(cat) {
        currentCategory = cat;
        currentPage = 1;
        renderCategorySidebar();
        renderProducts();
    }

    function renderCategorySidebar() {
        document.querySelectorAll('.category-item').forEach(item => {
            const catId = item.getAttribute('id');
            const isActive = (currentCategory === 'All' && catId === 'cat-all') ||
                             (currentCategory === 'Textbooks' && catId === 'cat-textbooks') ||
                             (currentCategory === 'Electronics' && catId === 'cat-electronics') ||
                             (currentCategory === 'Apparel' && catId === 'cat-apparel') ||
                             (currentCategory === 'Dorm Life' && catId === 'cat-dorm');
            
            if (isActive) {
                item.className = "category-item w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold text-[#2E1A06] bg-[#F5E4B0] border border-[#D4A017]/35 shadow-sm transition-all";
                item.querySelectorAll('svg').forEach(svg => {
                    svg.setAttribute('class', 'w-4 h-4 text-[#7A4A10]');
                });
            } else {
                item.className = "category-item w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-semibold text-[#2E1A06]/75 border border-transparent hover:bg-[#F5E4B0]/30 transition-all";
                item.querySelectorAll('svg').forEach(svg => {
                    svg.setAttribute('class', 'w-4 h-4 text-[#7A4A10]/70');
                });
            }
        });
    }

    function toggleCondition(cond) {
        if (selectedCondition === cond) {
            selectedCondition = null;
        } else {
            selectedCondition = cond;
        }
        currentPage = 1;
        renderConditionFilter();
        renderProducts();
    }

    function renderConditionFilter() {
        document.querySelectorAll('.condition-chip').forEach(chip => {
            const cond = chip.getAttribute('id').replace('cond-', '');
            const isActive = (selectedCondition === cond);
            if (isActive) {
                chip.className = "condition-chip px-4 py-2 rounded-xl text-xs font-black bg-[#7A4A10] text-[#FBF6EC] border border-[#7A4A10] shadow-sm transition duration-150";
            } else {
                chip.className = "condition-chip px-4 py-2 rounded-xl text-xs font-bold border border-[#D4A017]/30 bg-transparent text-[#2E1A06]/75 hover:bg-[#F5E4B0]/40 transition duration-150";
            }
        });
    }

    function handleSellButtonClick(event) {
        event.preventDefault();
        const user = localStorage.getItem('preloved_user');
        if (!user) {
            window.showToast('Silakan masuk terlebih dahulu untuk menjual barang.', 'error');
            setTimeout(() => {
                window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent("{{ route('products.create') }}");
            }, 1000);
        } else {
            window.location.href = "{{ route('products.create') }}";
        }
    }

    function facultyMatches(sellerFaculty, selectedFaculty) {
        if (!sellerFaculty) return false;
        sellerFaculty = sellerFaculty.trim().toLowerCase();
        selectedFaculty = selectedFaculty.trim().toLowerCase();

        // Direct match
        if (sellerFaculty === selectedFaculty) return true;

        // Handle abbreviations & prefixes (e.g. FISIP <-> Fakultas Ilmu Sosial dan Ilmu Politik)
        if (selectedFaculty.includes('sosial') && selectedFaculty.includes('politik') && sellerFaculty === 'fisip') {
            return true;
        }
        if (sellerFaculty.includes('sosial') && sellerFaculty.includes('politik') && selectedFaculty === 'fisip') {
            return true;
        }

        // Strip "fakultas " prefix to compare
        let cleanSelected = selectedFaculty.replace(/^fakultas\s+/, '');
        let cleanSeller = sellerFaculty.replace(/^fakultas\s+/, '');

        if (cleanSelected === cleanSeller) return true;

        // Check if one contains another
        if (cleanSelected.includes(cleanSeller) || cleanSeller.includes(cleanSelected)) return true;

        // Handle "Fakultas Ilmu-ilmu Kesehatan" <-> "Ilmu Kesehatan"
        if (cleanSelected.includes('kesehatan') && cleanSeller.includes('kesehatan')) return true;

        return false;
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

        renderedProductsCache = [...formattedCustom, ...formattedDb, ...mockProducts];
        let allProducts = renderedProductsCache;

        // 1. Search Query
        if (searchQuery.trim() !== '') {
            const query = searchQuery.toLowerCase();
            allProducts = allProducts.filter(p => 
                p.title.toLowerCase().includes(query) || 
                p.description.toLowerCase().includes(query)
            );
        }

        // 2. Category
        if (currentCategory !== 'All') {
            allProducts = allProducts.filter(p => p.category === currentCategory);
        }

        // 3. Price range
        if (minPrice !== null && !isNaN(minPrice)) {
            allProducts = allProducts.filter(p => p.price >= minPrice);
        }
        if (maxPrice !== null && !isNaN(maxPrice)) {
            allProducts = allProducts.filter(p => p.price <= maxPrice);
        }

        // 4. Condition filter (Single-select)
        if (selectedCondition !== null) {
            allProducts = allProducts.filter(p => {
                let displayCondition = p.condition;
                if (displayCondition === 'New' || displayCondition === 'Like New') displayCondition = 'Baru';
                else if (displayCondition === 'Good') displayCondition = 'Bekas';
                else if (displayCondition === 'Well Used') displayCondition = 'Usang';
                
                return displayCondition === selectedCondition;
            });
        }

        // 5. Faculty filter
        if (selectedFaculty !== 'All') {
            allProducts = allProducts.filter(p => {
                const sellerFaculty = p.seller && p.seller.unsoed_faculty ? p.seller.unsoed_faculty : '';
                return facultyMatches(sellerFaculty, selectedFaculty);
            });
        }

        grid.innerHTML = '';
        
        if (allProducts.length === 0) {
            grid.classList.add('hidden');
            emptyState.classList.remove('hidden');
            document.getElementById('pagination-container').innerHTML = '';
            return;
        }

        grid.classList.remove('hidden');
        emptyState.classList.add('hidden');

        // Pagination
        const totalItems = allProducts.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        
        if (currentPage > totalPages) currentPage = Math.max(1, totalPages);

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const paginatedProducts = allProducts.slice(startIndex, endIndex);

        paginatedProducts.forEach(p => {
            const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(p.price);
            
            // Translate condition
            let displayCondition = p.condition;
            if (displayCondition === 'New' || displayCondition === 'Like New') displayCondition = 'Baru';
            else if (displayCondition === 'Good') displayCondition = 'Bekas';
            else if (displayCondition === 'Well Used') displayCondition = 'Usang';

            let badgeClass = 'bg-gray-100 text-gray-500 border-gray-300';
            if (displayCondition === 'Baru') badgeClass = 'bg-green-100 text-green-700 border-green-300';
            else if (displayCondition === 'Bekas') badgeClass = 'bg-amber-100 text-amber-700 border-amber-300';
            else if (displayCondition === 'Usang') badgeClass = 'bg-gray-100 text-gray-500 border-gray-300';

            const imageUrl = p.image_urls && p.image_urls.length > 0 ? p.image_urls[0] : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';
            const rating = p.seller && p.seller.rating_cache ? p.seller.rating_cache : '4.8';
            const sellerName = p.seller ? p.seller.name : 'Mahasiswa Unsoed';
            const isVerified = p.seller && p.seller.is_verified ? '<span class="text-[8px] bg-[#7A4A10] text-[#FBF6EC] px-1 rounded-full ml-1">✓</span>' : '';

            const card = document.createElement('div');
            card.className = "bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow duration-200 relative group";
            
            const detailUrl = `/products/${p.id}`;

            card.innerHTML = `
                <span class="absolute top-2.5 left-2.5 z-10 px-2 py-0.5 border rounded-full text-[8px] font-bold uppercase tracking-wide shadow-sm ${badgeClass}">
                    ${displayCondition}
                </span>

                <a href="${detailUrl}" class="block aspect-square w-full bg-gray-50 overflow-hidden relative">
                    <img src="${imageUrl}" alt="${p.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                </a>

                <div class="p-4 sm:p-5 flex flex-col gap-3">
                    <!-- Baris 1: Nama penjual + Rating -->
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span class="font-medium truncate max-w-[70%]">${sellerName} ${isVerified}</span>
                        <span class="text-[#D4A017] font-bold shrink-0 flex items-center gap-0.5">★ ${rating}</span>
                    </div>

                    <!-- Baris 2: Nama produk -->
                    <h4 class="font-bold text-[#2E1A06] text-sm leading-snug line-clamp-2 hover:text-[#7A4A10] transition min-h-[2.5rem]">
                        <a href="${detailUrl}">${p.title}</a>
                    </h4>

                    <!-- Baris 3: Harga + Keranjang -->
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-base font-extrabold text-[#E8400C]">${formattedPrice}</span>
                        <button onclick="quickAddCart(event, ${p.id})"
                                class="p-2 bg-[#FBF6EC] border border-[#2E1A06]/20 text-[#2E1A06] hover:bg-[#2E1A06] hover:text-white rounded-xl transition-all duration-200 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.116 60.116 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const container = document.getElementById('pagination-container');
        container.innerHTML = '';

        if (totalPages <= 1) return;

        // Previous button
        const prevBtn = document.createElement('button');
        prevBtn.className = `px-3 py-2 rounded-xl text-xs font-bold border border-[#D4A017]/30 transition-all ${currentPage === 1 ? 'opacity-40 cursor-not-allowed bg-[#FBF6EC]/30 text-[#7A4A10]/50' : 'bg-[#FBF6EC] text-[#2E1A06] hover:bg-[#F5E4B0]'}`;
        prevBtn.innerHTML = '&lt;';
        prevBtn.onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                renderProducts();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        };
        container.appendChild(prevBtn);

        // Numbered buttons
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            if (i === currentPage) {
                pageBtn.className = "px-4 py-2 rounded-xl text-xs font-black bg-[#7A4A10] text-[#FBF6EC] border border-[#7A4A10] shadow-sm";
            } else {
                pageBtn.className = "px-4 py-2 rounded-xl text-xs font-bold border border-[#D4A017]/30 bg-[#FBF6EC] text-[#2E1A06] hover:bg-[#F5E4B0] transition-all";
            }
            pageBtn.textContent = i;
            pageBtn.onclick = () => {
                currentPage = i;
                renderProducts();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            };
            container.appendChild(pageBtn);
        }

        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.className = `px-3 py-2 rounded-xl text-xs font-bold border border-[#D4A017]/30 transition-all ${currentPage === totalPages ? 'opacity-40 cursor-not-allowed bg-[#FBF6EC]/30 text-[#7A4A10]/50' : 'bg-[#FBF6EC] text-[#2E1A06] hover:bg-[#F5E4B0]'}`;
        nextBtn.innerHTML = '&gt;';
        nextBtn.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderProducts();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        };
        container.appendChild(nextBtn);
    }

    async function quickAddCart(event, productId) {
        event.preventDefault();
        event.stopPropagation();
        const product = renderedProductsCache.find(x => x.id == productId);
        if (!product) return;
        await window.addToCart(product, true);
    }
</script>
@endsection
