<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved.in Aja - Pasar Kampus UNSOED</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#FAF4C8',  // Soft Cream
                            100: '#FAF4C8',
                            200: '#F7E68C', // Lighter Yellow
                            300: '#F5D44A', // Soft Yellow
                            400: '#F5D44A',
                            500: '#F2C300', // Bright Gold/Yellow (Primary)
                            600: '#D4A500', // Darker Gold
                            700: '#B58D00',
                            800: '#8A6B00',
                            900: '#544100',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
        .gradient-text {
            background: linear-gradient(135deg, #F2C300 0%, #D4A500 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #F2C300 0%, #F5D44A 100%);
            color: #3b2e00 !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(242, 195, 0, 0.6);
        }
        .card-premium {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05), 0 8px 10px -6px rgb(0 0 0 / 0.05);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center gap-4">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        <svg class="w-9 h-9" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Graduation Cap Top (Lighter Yellow) -->
                            <path d="M100 20L165 42L100 64L35 42L100 20Z" fill="#F7E68C" />
                            <!-- Tassel (Soft Yellow + Circle) -->
                            <path d="M52 48.5V68C52 70.5 49.5 72 47 72C44.5 72 42 70.5 42 68V45" stroke="#F5D44A" stroke-width="4.5" stroke-linecap="round"/>
                            <circle cx="47" cy="72" r="6.5" fill="#F2C300"/>
                            <!-- Arch Handle -->
                            <path d="M68 62C68 38 132 38 132 62" stroke="#F7E68C" stroke-width="15" stroke-linecap="round"/>
                            <!-- Shopping Bag Body (Primary Gold) -->
                            <path d="M42 62H158L168 165C168 171 163 175 157 175H43C37 175 32 171 32 165L42 62Z" fill="#F2C300"/>
                            <!-- Hollow Cutout inside bag forming P -->
                            <path d="M72 88H108C122 88 132 98 132 110C132 122 122 132 108 132H72V88ZM72 132V150" stroke="white" stroke-width="13" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-xl font-black tracking-tight leading-none text-slate-800">Preloved.in</span>
                            <span class="text-[9px] font-bold uppercase tracking-widest text-brand-600 mt-0.5">UNSOED Marketplace</span>
                        </div>
                    </a>
                </div>

                <!-- Live Search Bar -->
                <div class="flex-1 max-w-xl hidden md:block">
                    <form action="{{ route('home') }}" method="GET" class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" id="navbar-search" placeholder="Cari buku kuliah, tablet, hoodie, kulkas mini..." 
                               class="w-full pl-11 pr-4 py-2.5 bg-slate-50 hover:bg-slate-100 focus:bg-white text-sm text-slate-800 rounded-full border border-slate-200/80 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 focus:outline-none transition-all duration-200">
                    </form>
                </div>

                <!-- Right Nav Elements -->
                <div class="flex items-center gap-3 sm:gap-5">
                    
                    <!-- Tombol Upload (Jual) - Hanya jika login -->
                    <a href="{{ route('products.create') }}" id="nav-btn-sell" class="hidden sm:inline-flex items-center gap-1.5 text-slate-900 text-xs font-bold px-4 py-2.5 rounded-full btn-gradient shadow-sm shadow-brand-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Jual Barang
                    </a>

                    <!-- Keranjang Belanja -->
                    <a href="{{ route('cart.index') }}" class="relative p-2.5 text-slate-500 hover:text-brand-600 rounded-xl hover:bg-slate-50 transition-all group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span id="cart-badge" class="absolute -top-0.5 -right-0.5 bg-brand-500 text-slate-900 text-[10px] font-bold h-5 w-5 rounded-full border-2 border-white flex items-center justify-center scale-0 transition-all duration-300">0</span>
                    </a>

                    <!-- User Profile Dropdown / Login -->
                    <div class="relative" id="nav-auth-container">
                        <!-- Default Login Link -->
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-100 hover:bg-brand-500 hover:text-slate-900 text-slate-700 text-sm font-semibold rounded-full transition-all duration-200">
                            Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 text-slate-400 py-16 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                    <svg class="w-7 h-7" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 20L165 42L100 64L35 42L100 20Z" fill="#F7E68C" />
                        <path d="M52 48.5V68C52 70.5 49.5 72 47 72C44.5 72 42 70.5 42 68V45" stroke="#F5D44A" stroke-width="4.5" stroke-linecap="round"/>
                        <circle cx="47" cy="72" r="6.5" fill="#F2C300"/>
                        <path d="M68 62C68 38 132 38 132 62" stroke="#F7E68C" stroke-width="15" stroke-linecap="round"/>
                        <path d="M42 62H158L168 165C168 171 163 175 157 175H43C37 175 32 171 32 165L42 62Z" fill="#F2C300"/>
                        <path d="M72 88H108C122 88 132 98 132 110C132 122 122 132 108 132H72V88ZM72 132V150" stroke="white" stroke-width="13" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-xl font-extrabold tracking-tight text-white ml-2">Preloved.in</span>
                </a>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Platform jual-beli barang preloved berkualitas terpercaya khusus mahasiswa Universitas Jenderal Soedirman (UNSOED).</p>
                <div class="flex gap-3">
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-brand-500 hover:text-slate-900 flex items-center justify-center transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-brand-500 hover:text-slate-900 flex items-center justify-center transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-white text-sm mb-4">Kategori Populer</h4>
                <ul class="space-y-3 text-xs">
                    <li><a href="/?category=Textbooks" class="hover:text-brand-400 transition">Buku Kuliah (Textbooks)</a></li>
                    <li><a href="/?category=Electronics" class="hover:text-brand-400 transition">Elektronik & Gadget</a></li>
                    <li><a href="/?category=Furniture" class="hover:text-brand-400 transition">Perabotan Kost</a></li>
                    <li><a href="/?category=Apparel" class="hover:text-brand-400 transition">Pakaian & Sepatu</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white text-sm mb-4">Layanan & Aturan</h4>
                <ul class="space-y-3 text-xs">
                    <li><a href="#" class="hover:text-brand-400 transition">Aturan COD Kampus</a></li>
                    <li><a href="#" class="hover:text-brand-400 transition">Panduan Keamanan</a></li>
                    <li><a href="{{ route('transactions.history') }}" class="hover:text-brand-400 transition">Riwayat Transaksi</a></li>
                    <li><a href="#" class="hover:text-brand-400 transition">Bantuan Kontak</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white text-sm mb-4">Lokasi COD Populer</h4>
                <p class="text-xs leading-relaxed text-slate-500 mb-2">Pasar Kampus Unsoed Purwokerto:</p>
                <ul class="space-y-1.5 text-[11px] text-slate-500">
                    <li>📍 Perpustakaan Pusat UNSOED</li>
                    <li>📍 Gedung Soedirman (Graha Widyatama)</li>
                    <li>📍 GOR Susilo Soedarman</li>
                    <li>📍 Area Fakultas masing-masing</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-slate-800 text-center text-xs text-slate-600">
            &copy; 2026 Preloved.in Aja. Dikembangkan untuk tugas rekayasa perangkat lunak.
        </div>
    </footer>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- Global Javascript Helper for State & Toast & Cart -->
    <script>
        // --- TOAST HELPER ---
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-lg border text-sm font-semibold transition-all duration-300 transform translate-y-10 opacity-0 pointer-events-auto max-w-sm`;
            
            if (type === 'success') {
                toast.className += ' bg-emerald-50 text-emerald-800 border-emerald-100';
                toast.innerHTML = `
                    <span class="text-emerald-500">✓</span>
                    <span>${message}</span>
                `;
            } else if (type === 'error') {
                toast.className += ' bg-rose-50 text-rose-800 border-rose-100';
                toast.innerHTML = `
                    <span class="text-rose-500">✕</span>
                    <span>${message}</span>
                `;
            } else {
                toast.className += ' bg-brand-50 text-brand-900 border-brand-200';
                toast.innerHTML = `
                    <span class="text-brand-600">ℹ</span>
                    <span>${message}</span>
                `;
            }

            container.appendChild(toast);
            
            // Trigger animation
            setTimeout(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
            }, 10);

            // Auto dismiss after 3 seconds
            setTimeout(() => {
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        };

        // --- CART HELPER ---
        window.getCart = function() {
            return JSON.parse(localStorage.getItem('preloved_cart') || '[]');
        };

        window.updateCartBadge = function() {
            const cart = window.getCart();
            const badge = document.getElementById('cart-badge');
            if (badge) {
                const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
                badge.textContent = totalItems;
                if (totalItems > 0) {
                    badge.classList.remove('scale-0');
                    badge.classList.add('scale-100');
                } else {
                    badge.classList.remove('scale-100');
                    badge.classList.add('scale-0');
                }
            }
        };

        window.addToCart = function(product, showFeedback = true) {
            const cart = window.getCart();
            const existing = cart.find(item => item.id == product.id);
            if (existing) {
                existing.quantity += 1;
            } else {
                cart.push({
                    id: product.id,
                    title: product.title,
                    price: product.price,
                    image: product.image_urls ? product.image_urls[0] : (product.image || 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80'),
                    seller: product.seller ? product.seller.name : (product.seller_name || '@mhs_unsoed'),
                    quantity: 1
                });
            }
            localStorage.setItem('preloved_cart', JSON.stringify(cart));
            window.updateCartBadge();
            if (showFeedback) {
                window.showToast(`Berhasil menambahkan "${product.title}" ke keranjang!`);
            }
        };

        window.removeFromCart = function(productId) {
            let cart = window.getCart();
            cart = cart.filter(item => item.id != productId);
            localStorage.setItem('preloved_cart', JSON.stringify(cart));
            window.updateCartBadge();
        };

        // --- AUTH SYNC & DOMAIN PROTECTION ---
        window.syncAuthHeader = function() {
            const userJson = localStorage.getItem('preloved_user');
            const authContainer = document.getElementById('nav-auth-container');
            const sellBtn = document.getElementById('nav-btn-sell');

            if (userJson) {
                const user = JSON.parse(userJson);
                if (sellBtn) sellBtn.classList.remove('hidden');

                // Render Beautiful Profile Dropdown
                authContainer.innerHTML = `
                    <div class="relative inline-block text-left">
                        <button onclick="document.getElementById('profile-dropdown').classList.toggle('hidden')" class="flex items-center gap-2 focus:outline-none hover:bg-slate-50 p-1.5 rounded-full transition duration-150">
                            <img class="h-9 w-9 rounded-full object-cover border-2 border-brand-500 shadow-sm" src="${user.avatar_url || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80'}" alt="${user.name}">
                            <div class="text-left hidden lg:block pr-2">
                                <p class="text-xs font-bold text-slate-800 leading-3">${user.name}</p>
                                <p class="text-[9px] font-medium text-slate-400">${user.unsoed_faculty || 'Fakultas'} - ${user.unsoed_major || 'UNSOED'}</p>
                            </div>
                        </button>
                        <div id="profile-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-52 rounded-2xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 divide-y divide-slate-100 focus:outline-none z-50 overflow-hidden">
                            <div class="px-4 py-3">
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Mahasiswa Aktif</p>
                                <p class="text-sm font-semibold text-slate-800 truncate">${user.email}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('products.create') }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center gap-2">
                                    ➕ Jual Barang Baru
                                </a>
                                <a href="{{ route('transactions.history') }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center gap-2">
                                    📦 Riwayat Transaksi
                                </a>
                            </div>
                            <div class="py-1">
                                <button onclick="window.logoutUser()" class="w-full text-left block px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 flex items-center gap-2">
                                    🚪 Keluar Akun
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                if (sellBtn) sellBtn.classList.add('hidden');
                authContainer.innerHTML = `
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-slate-100 hover:bg-brand-500 hover:text-slate-900 text-slate-700 hover:shadow-md text-xs font-bold rounded-full transition-all duration-200">
                        Masuk
                    </a>
                `;
            }
        };

        window.logoutUser = function() {
            localStorage.removeItem('preloved_user');
            localStorage.removeItem('preloved_token');
            window.showToast('Berhasil keluar akun.');
            window.syncAuthHeader();
            setTimeout(() => {
                window.location.href = "{{ route('home') }}";
            }, 500);
        };

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profile-dropdown');
            if (dropdown && !e.target.closest('#nav-auth-container')) {
                dropdown.classList.add('hidden');
            }
        });

        // Initial setup
        window.addEventListener('DOMContentLoaded', () => {
            window.updateCartBadge();
            window.syncAuthHeader();
        });
    </script>
</body>
</html>
