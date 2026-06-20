<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Preloved.in Aja - Pasar Kampus UNSOED</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.3.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
    <script>
        const reverbKey = "{{ env('VITE_REVERB_APP_KEY') ?: env('REVERB_APP_KEY') }}";
        const reverbHost = "{{ env('VITE_REVERB_HOST') ?: env('REVERB_HOST', '127.0.0.1') }}";
        const reverbPort = "{{ env('VITE_REVERB_PORT') ?: env('REVERB_PORT', '8080') }}";
        const reverbScheme = "{{ env('VITE_REVERB_SCHEME') ?: env('REVERB_SCHEME', 'http') }}";
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @yield('head')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: 'rgba(var(--bg-color-rgb), <alpha-value>)',
                            100: 'rgba(var(--surface-color-rgb), <alpha-value>)',
                            500: 'rgba(var(--primary-color-rgb), <alpha-value>)',
                            600: 'rgba(var(--cta-color-rgb), <alpha-value>)',
                            900: 'rgba(var(--text-color-rgb), <alpha-value>)',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --bg-color-rgb: 251, 246, 236;
            --surface-color-rgb: 245, 228, 176;
            --primary-color-rgb: 212, 160, 23;
            --cta-color-rgb: 122, 74, 16;
            --text-color-rgb: 46, 26, 6;

            --bg-color: rgba(var(--bg-color-rgb), 1);
            --surface-color: rgba(var(--surface-color-rgb), 1);
            --primary-color: rgba(var(--primary-color-rgb), 1);
            --cta-color: rgba(var(--cta-color-rgb), 1);
            --text-color: rgba(var(--text-color-rgb), 1);
        }
        body.dark {
            --bg-color-rgb: 46, 26, 6;
            --surface-color-rgb: 62, 36, 9;
            --primary-color-rgb: 212, 160, 23;
            --cta-color-rgb: 245, 228, 176;
            --text-color-rgb: 251, 246, 236;

            --bg-color: rgba(var(--bg-color-rgb), 1);
            --surface-color: rgba(var(--surface-color-rgb), 1);
            --primary-color: rgba(var(--primary-color-rgb), 1);
            --cta-color: rgba(var(--cta-color-rgb), 1);
            --text-color: rgba(var(--text-color-rgb), 1);
        }
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }
        .gradient-text {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--cta-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-gradient {
            background: var(--cta-color);
            color: var(--bg-color) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-gradient:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .card-premium {
            background-color: var(--surface-color);
            border-color: rgba(212, 160, 23, 0.2);
            color: var(--text-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px -5px rgba(122, 74, 16, 0.15);
        }
        /* Fluid Page Transition & Skeleton animations */
        .page-enter {
            animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .skeleton {
            background: linear-gradient(90deg, var(--surface-color) 25%, var(--bg-color) 50%, var(--surface-color) 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite linear;
        }
        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body class="flex flex-col min-h-screen page-enter">

    <!-- Navbar -->
    <nav class="bg-brand-100/90 backdrop-blur-md border-b border-brand-500/20 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center gap-4">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        <svg class="w-9 h-9 animate-pulse" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 20L165 42L100 64L35 42L100 20Z" fill="var(--primary-color)" />
                            <path d="M52 48.5V68C52 70.5 49.5 72 47 72C44.5 72 42 70.5 42 68V45" stroke="var(--cta-color)" stroke-width="4.5" stroke-linecap="round"/>
                            <circle cx="47" cy="72" r="6.5" fill="var(--text-color)"/>
                            <path d="M68 62C68 38 132 38 132 62" stroke="var(--surface-color)" stroke-width="15" stroke-linecap="round"/>
                            <path d="M42 62H158L168 165C168 171 163 175 157 175H43C37 175 32 171 32 165L42 62Z" fill="var(--primary-color)"/>
                            <path d="M72 88H108C122 88 132 98 132 110C132 122 122 132 108 132H72V88ZM72 132V150" stroke="var(--bg-color)" stroke-width="13" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-2xl font-black tracking-tight leading-none text-brand-900 font-heading">Preloved.in</span>
                        </div>
                    </a>
                </div>

                <!-- Live Search Bar -->
                <div class="flex-1 max-w-xl hidden md:block">
                    <form action="{{ route('home') }}" method="GET" class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-brand-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" id="navbar-search" placeholder="Cari buku kuliah, laptop, kalkulator..." 
                               class="w-full pl-11 pr-4 py-2.5 bg-brand-50 hover:bg-white text-sm text-brand-900 rounded-full border border-brand-500/30 focus:border-brand-600 focus:outline-none transition-all duration-200">
                    </form>
                </div>

                <!-- Right Nav Elements -->
                <div class="flex items-center gap-2 sm:gap-4">
                    
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="p-2 text-brand-600 hover:text-brand-900 rounded-xl hover:bg-brand-50 transition-all flex items-center justify-center">
                        <svg id="dark-mode-icon-sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                        </svg>
                        <svg id="dark-mode-icon-moon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
                    
                    <!-- Tombol Upload (Jual) -->
                    <a href="{{ route('products.create') }}" id="nav-btn-sell" class="hidden sm:inline-flex items-center gap-1.5 text-brand-50 text-xs font-bold px-4 py-2.5 rounded-full btn-gradient shadow-sm shadow-brand-600/20">
                        Jual Barang
                    </a>

                    <!-- Keranjang Belanja -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-brand-600 hover:text-brand-900 rounded-xl hover:bg-brand-50 transition-all group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span id="cart-badge" class="absolute -top-0.5 -right-0.5 bg-brand-600 text-brand-50 text-[10px] font-bold h-5 w-5 rounded-full border-2 border-brand-100 flex items-center justify-center scale-0 transition-all duration-300">0</span>
                    </a>

                    <!-- Notification Bell Container -->
                    <div class="relative hidden sm:block" id="nav-notification-container"></div>

                    <!-- User Profile Dropdown / Login -->
                    <div class="relative hidden sm:block" id="nav-auth-container">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-brand-50 hover:bg-brand-600 hover:text-brand-50 text-brand-900 text-sm font-semibold rounded-full border border-brand-500/30 transition-all duration-200">
                            Masuk
                        </a>
                    </div>

                    <!-- Mobile Hamburger Menu Button -->
                    <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-brand-600 hover:text-brand-900 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-brand-100 border-t border-brand-500/20 px-4 pt-2 pb-6 space-y-4 shadow-inner">
            <div class="pt-2">
                <form action="{{ route('home') }}" method="GET" class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-brand-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" id="mobile-navbar-search" placeholder="Cari barang..." 
                           class="w-full pl-9 pr-4 py-2 bg-brand-50 text-xs text-brand-900 rounded-full border border-brand-500/30 focus:border-brand-600 focus:outline-none">
                </form>
            </div>
            <!-- Mobile Notifications Section -->
            <div id="mobile-notifications-section" class="pt-1"></div>

            <div class="flex flex-col gap-2.5 pt-1" id="mobile-auth-container">
                <!-- Injected via JS -->
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#2E1A06] text-[#FBF6EC]/70 py-16 text-sm transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-[#FBF6EC]/10 pb-12">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                    <span class="text-2xl font-black text-[#FBF6EC] font-heading">Preloved.in</span>
                </a>
                <p class="text-xs text-[#FBF6EC]/50 leading-relaxed mb-4 font-light">Platform jual-beli barang preloved berkualitas terpercaya khusus mahasiswa Universitas Jenderal Soedirman (UNSOED).</p>
            </div>
            <div>
                <h4 class="font-bold text-[#FBF6EC] text-sm mb-4">Kategori Populer</h4>
                <ul class="space-y-3 text-xs">
                    <li><a href="/?category=Textbooks" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Buku Kuliah (Textbooks)</a></li>
                    <li><a href="/?category=Electronics" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Elektronik & Gadget</a></li>
                    <li><a href="/?category=Furniture" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Perabotan Kost</a></li>
                    <li><a href="/?category=Apparel" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Pakaian & Sepatu</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-[#FBF6EC] text-sm mb-4">Layanan & Aturan</h4>
                <ul class="space-y-3 text-xs">
                    <li><a href="#" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Aturan COD Kampus</a></li>
                    <li><a href="#" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Panduan Keamanan</a></li>
                    <li><a href="{{ route('transactions.history') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Riwayat Transaksi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-[#FBF6EC] text-sm mb-4">Akses Dashboard</h4>
                <ul class="space-y-3 text-xs">
                    <li><a href="{{ route('seller.dashboard') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-semibold">Seller Dashboard</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-semibold">Admin Dashboard</a></li>
                    <li><a href="{{ route('profile.index') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-semibold">Profil Saya</a></li>
                    <li><a href="{{ route('chat.index') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-semibold">Pesan Masuk</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 text-center text-xs text-[#FBF6EC]/35 font-light">
            &copy; 2026 Preloved.in. Developed for Software Engineering coursework.
        </div>
    </footer>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <script>
        // Toggle dark mode
        window.toggleDarkMode = function() {
            document.body.classList.toggle('dark');
            const isDark = document.body.classList.contains('dark');
            localStorage.setItem('preloved_dark_mode', isDark ? 'enabled' : 'disabled');
            updateDarkModeIcons();
        };

        function updateDarkModeIcons() {
            const isDark = document.body.classList.contains('dark');
            const sunIcon = document.getElementById('dark-mode-icon-sun');
            const moonIcon = document.getElementById('dark-mode-icon-moon');
            if(sunIcon && moonIcon) {
                if(isDark) {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                } else {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                }
            }
        }

        // Apply dark mode initially
        if (localStorage.getItem('preloved_dark_mode') === 'enabled') {
            document.body.classList.add('dark');
        }

        // Mobile drawer menu
        window.toggleMobileMenu = function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        };

        // Toast notifications
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-lg border text-sm font-semibold transition-all duration-300 transform translate-y-10 opacity-0 pointer-events-auto max-w-sm`;
            
            if (type === 'success') {
                toast.className += ' bg-emerald-50 text-emerald-800 border-emerald-100 dark:bg-emerald-950/90 dark:text-emerald-300 dark:border-emerald-800';
                toast.innerHTML = `<span class="text-emerald-500">✓</span><span>${message}</span>`;
            } else if (type === 'error') {
                toast.className += ' bg-rose-50 text-rose-800 border-rose-100 dark:bg-rose-950/90 dark:text-rose-300 dark:border-rose-850';
                toast.innerHTML = `<span class="text-rose-500">✕</span><span>${message}</span>`;
            } else {
                toast.className += ' bg-brand-100 text-brand-900 border-brand-500/30';
                toast.innerHTML = `<span class="text-brand-600">ℹ</span><span>${message}</span>`;
            }

            container.appendChild(toast);
            setTimeout(() => toast.classList.remove('translate-y-10', 'opacity-0'), 10);
            setTimeout(() => {
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        };

        // Cart utilities
        window.getCart = function() {
            return JSON.parse(localStorage.getItem('preloved_cart') || '[]');
        };

        window.updateCartBadge = function() {
            const cart = window.getCart();
            const badge = document.getElementById('cart-badge');
            const mobileBadge = document.getElementById('mobile-cart-badge');
            const totalItems = cart.reduce((total, item) => total + item.quantity, 0);

            if (badge) {
                badge.textContent = totalItems;
                if (totalItems > 0) {
                    badge.classList.remove('scale-0');
                    badge.classList.add('scale-100');
                } else {
                    badge.classList.remove('scale-100');
                    badge.classList.add('scale-0');
                }
            }
            if (mobileBadge) mobileBadge.textContent = totalItems;
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
                    seller: product.seller ? product.seller.name : (product.seller_name || 'Mahasiswa Unsoed'),
                    quantity: 1
                });
            }
            localStorage.setItem('preloved_cart', JSON.stringify(cart));
            window.updateCartBadge();
            if (showFeedback) window.showToast(`Berhasil menambahkan "${product.title}" ke keranjang!`);
        };

        window.removeFromCart = function(productId) {
            let cart = window.getCart();
            cart = cart.filter(item => item.id != productId);
            localStorage.setItem('preloved_cart', JSON.stringify(cart));
            window.updateCartBadge();
        };

        // Sync auth state
        window.syncAuthHeader = function() {
            const userJson = localStorage.getItem('preloved_user');
            const authContainer = document.getElementById('nav-auth-container');
            const mobileAuthContainer = document.getElementById('mobile-auth-container');
            const sellBtn = document.getElementById('nav-btn-sell');
            const notifContainer = document.getElementById('nav-notification-container');
            const mobileNotifSection = document.getElementById('mobile-notifications-section');

            if (userJson) {
                const user = JSON.parse(userJson);
                if (sellBtn) sellBtn.classList.remove('hidden');

                const verifyBadge = user.is_verified ? '<span class="ml-1.5 bg-brand-600 text-brand-50 text-[8px] font-extrabold px-1.5 py-0.5 rounded-full">Verified</span>' : '';
                const dashboardLink = user.role === 'admin' 
                    ? `<a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-xs font-bold text-brand-900 hover:bg-brand-100/50">Admin Dashboard</a>`
                    : `<a href="{{ route('seller.dashboard') }}" class="block px-4 py-2.5 text-xs font-bold text-brand-900 hover:bg-brand-100/50">Seller Dashboard</a>`;

                // Render Desktop Profile Dropdown
                if (authContainer) {
                    authContainer.innerHTML = `
                        <div class="relative inline-block text-left">
                            <button onclick="document.getElementById('profile-dropdown').classList.toggle('hidden')" class="flex items-center gap-2 focus:outline-none hover:bg-brand-100 p-1.5 rounded-full transition duration-150">
                                <img class="h-9 w-9 rounded-full object-cover border-2 border-brand-500 shadow-sm" src="${user.avatar_url || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80'}" alt="${user.name}">
                                <div class="text-left hidden lg:block pr-2">
                                    <p class="text-xs font-bold text-brand-900 leading-3 flex items-center">${user.name} ${verifyBadge}</p>
                                    <p class="text-[9px] font-medium text-brand-650 mt-1">${user.unsoed_faculty || 'Fakultas'} - ${user.unsoed_major || 'UNSOED'}</p>
                                </div>
                            </button>
                            <div id="profile-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-52 rounded-2xl shadow-xl bg-brand-50 border border-brand-500/25 divide-y divide-brand-500/10 focus:outline-none z-50 overflow-hidden">
                                <div class="px-4 py-3 bg-brand-100/30">
                                    <p class="text-[9px] text-brand-600 font-extrabold uppercase tracking-wider">Mahasiswa Aktif (${user.no_kampus || 'NIM'})</p>
                                    <p class="text-xs font-bold text-brand-900 truncate">${user.email}</p>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('profile.index') }}" class="block px-4 py-2.5 text-xs font-bold text-brand-900 hover:bg-brand-100/50">Profil Saya</a>
                                    ${dashboardLink}
                                    <a href="{{ route('chat.index') }}" class="block px-4 py-2.5 text-xs font-bold text-brand-900 hover:bg-brand-100/50">Chat Masuk</a>
                                    <a href="{{ route('transactions.history') }}" class="block px-4 py-2.5 text-xs font-bold text-brand-900 hover:bg-brand-100/50">Riwayat Transaksi</a>
                                </div>
                                <div class="py-1">
                                    <button onclick="window.logoutUser()" class="w-full text-left block px-4 py-2.5 text-xs font-black text-rose-700 hover:bg-rose-50 flex items-center gap-2">
                                        Keluar Akun
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }

                // Render Desktop Notification Bell Dropdown
                if (notifContainer) {
                    notifContainer.classList.remove('hidden');
                    notifContainer.innerHTML = `
                        <div class="relative inline-block text-left">
                            <button id="notification-bell-btn" onclick="document.getElementById('notification-dropdown').classList.toggle('hidden'); window.fetchNotifications();" class="relative p-2 text-brand-600 hover:text-brand-900 rounded-xl hover:bg-brand-50 transition-all group focus:outline-none flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <span id="notification-badge" class="absolute -top-0.5 -right-0.5 bg-brand-600 text-brand-50 text-[10px] font-bold h-5 w-5 rounded-full border-2 border-brand-100 flex items-center justify-center scale-0 transition-all duration-300">0</span>
                            </button>
                            <div id="notification-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-80 rounded-2xl shadow-xl bg-brand-50 border border-brand-500/25 divide-y divide-brand-500/10 focus:outline-none z-50 overflow-hidden">
                                <div class="px-4 py-3 bg-brand-100/30 flex justify-between items-center">
                                    <span class="text-xs font-extrabold text-brand-900 font-heading">Notifikasi</span>
                                    <button onclick="event.stopPropagation(); window.markAllNotificationsRead();" class="text-[10px] font-bold text-brand-600 hover:text-brand-900 focus:outline-none">Tandai Semua Dibaca</button>
                                </div>
                                <div id="notification-items-list" class="max-h-64 overflow-y-auto divide-y divide-brand-500/10">
                                    <div class="p-4 text-center text-xs text-brand-600 font-medium">Memuat notifikasi...</div>
                                </div>
                            </div>
                        </div>
                    `;
                }

                // Render Mobile Profile Menu Links
                if (mobileAuthContainer) {
                    mobileAuthContainer.innerHTML = `
                        <div class="flex items-center gap-3 p-3 bg-brand-50 border border-brand-500/20 rounded-2xl">
                            <img class="h-10 w-10 rounded-full object-cover border border-brand-500" src="${user.avatar_url || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80'}">
                            <div class="flex-1">
                                <p class="text-xs font-extrabold text-brand-900 flex items-center">${user.name} ${verifyBadge}</p>
                                <p class="text-[9px] text-brand-600">${user.unsoed_faculty} / ${user.unsoed_major}</p>
                            </div>
                        </div>
                        <a href="{{ route('products.create') }}" class="w-full text-center py-2.5 bg-brand-600 text-brand-50 font-bold text-xs rounded-xl shadow-md flex items-center justify-center gap-1.5">
                            Jual Barang Baru
                        </a>
                        <a href="{{ route('profile.index') }}" class="w-full text-center py-2.5 bg-brand-100 text-brand-900 border border-brand-500/35 font-bold text-xs rounded-xl block">
                            Profil Saya
                        </a>
                        <a href="${user.role === 'admin' ? '/admin/dashboard' : '/seller/dashboard'}" class="w-full text-center py-2.5 bg-brand-100 text-brand-900 border border-brand-500/35 font-bold text-xs rounded-xl block">
                            Dashboard Akun
                        </a>
                        <a href="{{ route('chat.index') }}" class="w-full text-center py-2.5 bg-brand-100 text-brand-900 border border-brand-500/35 font-bold text-xs rounded-xl block">
                            Chat Masuk
                        </a>
                        <a href="{{ route('transactions.history') }}" class="w-full text-center py-2.5 bg-brand-100 text-brand-900 border border-brand-500/35 font-bold text-xs rounded-xl block">
                            Riwayat Transaksi
                        </a>
                        <button onclick="window.logoutUser()" class="w-full text-center py-2.5 bg-rose-50 text-rose-700 font-extrabold text-xs rounded-xl flex items-center justify-center gap-2 border border-rose-100">
                            Keluar Akun
                        </button>
                    `;
                }

                // Initialize Echo and load notifications
                window.initEcho();
                window.fetchNotifications();

            } else {
                if (sellBtn) sellBtn.classList.add('hidden');
                if (notifContainer) {
                    notifContainer.classList.add('hidden');
                    notifContainer.innerHTML = '';
                }
                if (mobileNotifSection) {
                    mobileNotifSection.innerHTML = '';
                }
                
                if (authContainer) {
                    authContainer.innerHTML = `
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-brand-50 hover:bg-brand-600 hover:text-brand-50 text-brand-900 hover:shadow-md text-xs font-bold rounded-full border border-brand-500/30 transition-all duration-200">
                            Masuk
                        </a>
                    `;
                }

                if (mobileAuthContainer) {
                    mobileAuthContainer.innerHTML = `
                        <a href="{{ route('login') }}" class="w-full text-center py-3 bg-brand-600 text-brand-50 font-extrabold text-xs rounded-xl shadow-md block">
                            🔑 Masuk Akun Mahasiswa
                        </a>
                        <a href="{{ route('register') }}" class="w-full text-center py-3 bg-brand-100 text-brand-900 border border-brand-500/30 font-extrabold text-xs rounded-xl block">
                            🎓 Registrasi Akun Baru
                        </a>
                    `;
                }

                window.disconnectEcho();
            }
        };

        window.logoutUser = function() {
            window.disconnectEcho();
            localStorage.removeItem('preloved_user');
            localStorage.removeItem('preloved_token');
            window.showToast('Berhasil keluar akun.');
            window.syncAuthHeader();
            setTimeout(() => {
                window.location.href = "{{ route('home') }}";
            }, 500);
        };

        // Real-time notifications and Laravel Echo implementation
        window.notificationsList = [];

        window.initEcho = function() {
            const token = localStorage.getItem('preloved_token');
            if (!token) return;

            if (window.Echo) return;

            if (typeof Echo === 'undefined' || typeof Pusher === 'undefined') {
                console.warn('Echo or Pusher CDN not loaded yet.');
                return;
            }

            window.Pusher = Pusher;
            window.Echo = new Echo({
                broadcaster: 'reverb',
                key: reverbKey || 'preloved_key',
                wsHost: reverbHost || window.location.hostname,
                wsPort: parseInt(reverbPort) || 8080,
                wssPort: parseInt(reverbPort) || 8080,
                forceTLS: reverbScheme === 'https',
                enabledTransports: ['ws', 'wss'],
                authEndpoint: '/api/v1/broadcasting/auth',
                auth: {
                    headers: {
                        Authorization: 'Bearer ' + token
                    }
                }
            });

            const userJson = localStorage.getItem('preloved_user');
            if (userJson) {
                const user = JSON.parse(userJson);
                window.subscribeToUserChannel(user.id);
            }
        };

        window.disconnectEcho = function() {
            if (window.Echo) {
                window.Echo.disconnect();
                window.Echo = null;
            }
        };

        window.subscribeToUserChannel = function(userId) {
            if (!window.Echo) return;

            window.Echo.private(`App.Models.User.${userId}`)
                .notification((notification) => {
                    console.log('Real-time Notification received:', notification);
                    
                    // Show custom toast feedback
                    window.showToast(notification.message || 'Anda memiliki notifikasi baru.');
                    
                    // Subtle sound feedback
                    try {
                        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                        const oscillator = audioCtx.createOscillator();
                        const gainNode = audioCtx.createGain();
                        oscillator.connect(gainNode);
                        gainNode.connect(audioCtx.destination);
                        oscillator.type = 'sine';
                        oscillator.frequency.setValueAtTime(587.33, audioCtx.currentTime); // D5
                        oscillator.frequency.setValueAtTime(880, audioCtx.currentTime + 0.1); // A5
                        gainNode.gain.setValueAtTime(0.05, audioCtx.currentTime);
                        gainNode.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.3);
                        oscillator.start();
                        oscillator.stop(audioCtx.currentTime + 0.3);
                    } catch (e) {}

                    // Reload notifications list
                    window.fetchNotifications();
                });
        };

        window.fetchNotifications = async function() {
            const token = localStorage.getItem('preloved_token');
            if (!token) return;

            try {
                const response = await fetch('/api/v1/notifications', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.status === 'success') {
                    window.notificationsList = result.data;
                    window.renderNotifications();
                }
            } catch (e) {
                console.error('Failed to fetch notifications:', e);
            }
        };

        window.renderNotifications = function() {
            const itemsList = document.getElementById('notification-items-list');
            const badge = document.getElementById('notification-badge');
            const mobileContainer = document.getElementById('mobile-notifications-section');

            const unreadNotifications = window.notificationsList.filter(n => !n.read_at);
            const unreadCount = unreadNotifications.length;

            if (badge) {
                badge.textContent = unreadCount;
                if (unreadCount > 0) {
                    badge.classList.remove('scale-0');
                    badge.classList.add('scale-100');
                } else {
                    badge.classList.remove('scale-100');
                    badge.classList.add('scale-0');
                }
            }

            if (!itemsList) return;

            if (window.notificationsList.length === 0) {
                itemsList.innerHTML = `
                    <div class="p-6 text-center text-xs text-brand-650 font-medium flex flex-col items-center gap-1.5">
                        <svg class="w-8 h-8 text-brand-500/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span>Belum ada notifikasi baru</span>
                    </div>
                `;
                if (mobileContainer) {
                    mobileContainer.innerHTML = '';
                }
                return;
            }

            let itemsHtml = '';
            window.notificationsList.forEach(n => {
                const data = n.data;
                const isUnread = !n.read_at;
                const timeAgo = window.formatTimeAgo(new Date(n.created_at));
                const bgClass = isUnread ? 'bg-brand-500/10 hover:bg-brand-500/15' : 'hover:bg-brand-100/50';
                const unreadDot = isUnread ? '<span class="h-2.5 w-2.5 rounded-full bg-brand-600 flex-shrink-0 animate-pulse"></span>' : '';
                
                itemsHtml += `
                    <div onclick="event.stopPropagation(); window.handleNotificationClick('${n.id}', '${data.chat_id || ''}', '${data.product_id || ''}', '${data.report_id || ''}')" 
                         class="px-4 py-3.5 text-xs cursor-pointer transition duration-150 flex items-start gap-3 border-b border-brand-500/10 ${bgClass}">
                        <div class="flex-grow">
                            <p class="font-extrabold text-brand-900 flex items-center justify-between gap-2">
                                <span>${data.title || 'Pemberitahuan'}</span>
                                <span class="text-[9px] font-normal text-brand-600 flex-shrink-0">${timeAgo}</span>
                            </p>
                            <p class="text-brand-700 mt-1 leading-relaxed font-semibold">${data.message}</p>
                        </div>
                        ${unreadDot}
                    </div>
                `;
            });

            itemsList.innerHTML = itemsHtml;

            // Render in Mobile Drawer
            if (mobileContainer) {
                let mobileHtml = `
                    <div class="px-4 py-3 bg-brand-50/50 border border-brand-500/20 rounded-2xl shadow-sm">
                        <div class="flex justify-between items-center mb-2 px-1">
                            <span class="text-xs font-black text-brand-900 font-heading">Notifikasi (${unreadCount} Baru)</span>
                            ${unreadCount > 0 ? `<button onclick="window.markAllNotificationsRead()" class="text-[10px] font-extrabold text-brand-600 hover:underline">Baca Semua</button>` : ''}
                        </div>
                        <div class="divide-y divide-brand-500/10 max-h-48 overflow-y-auto">
                `;
                window.notificationsList.slice(0, 5).forEach(n => {
                    const data = n.data;
                    const isUnread = !n.read_at;
                    const timeAgo = window.formatTimeAgo(new Date(n.created_at));
                    const fontClass = isUnread ? 'font-bold' : 'font-normal';
                    mobileHtml += `
                        <div onclick="window.handleNotificationClick('${n.id}', '${data.chat_id || ''}', '${data.product_id || ''}', '${data.report_id || ''}')" 
                             class="py-2.5 cursor-pointer flex justify-between items-start gap-2">
                            <div class="flex-grow">
                                <p class="text-xs ${fontClass} text-brand-900 leading-tight">${data.title}</p>
                                <p class="text-[10px] text-brand-700 truncate max-w-[220px] mt-0.5">${data.message}</p>
                            </div>
                            <span class="text-[8px] text-brand-600 flex-shrink-0 mt-0.5">${timeAgo}</span>
                        </div>
                    `;
                });
                mobileHtml += `
                        </div>
                    </div>
                `;
                mobileContainer.innerHTML = mobileHtml;
            }
        };

        window.handleNotificationClick = async function(id, chatId, productId, reportId) {
            // Mark notification as read
            await window.markNotificationRead(id);

            // Close notification dropdown
            const dropdown = document.getElementById('notification-dropdown');
            if (dropdown) dropdown.classList.add('hidden');

            // Redirect to appropriate screen
            if (chatId) {
                window.location.href = `/chats?chat_id=${chatId}`;
            } else if (productId) {
                window.location.href = `/products/${productId}`;
            } else if (reportId) {
                const userJson = localStorage.getItem('preloved_user');
                if (userJson) {
                    const user = JSON.parse(userJson);
                    if (user.role === 'admin') {
                        window.location.href = `/admin/dashboard?report_id=${reportId}`;
                    } else {
                        window.location.href = `/profile`;
                    }
                }
            } else {
                window.location.reload();
            }
        };

        window.markNotificationRead = async function(id) {
            const token = localStorage.getItem('preloved_token');
            if (!token) return;

            try {
                const response = await fetch(`/api/v1/notifications/${id}/read`, {
                    method: 'PATCH',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.status === 'success') {
                    const notification = window.notificationsList.find(n => n.id === id);
                    if (notification) {
                        notification.read_at = new Date().toISOString();
                    }
                    window.renderNotifications();
                }
            } catch (e) {
                console.error('Failed to mark notification read:', e);
            }
        };

        window.markAllNotificationsRead = async function() {
            const token = localStorage.getItem('preloved_token');
            if (!token) return;

            try {
                const response = await fetch('/api/v1/notifications/read-all', {
                    method: 'PATCH',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.status === 'success') {
                    window.notificationsList.forEach(n => {
                        if (!n.read_at) n.read_at = new Date().toISOString();
                    });
                    window.renderNotifications();
                    window.showToast('Semua notifikasi ditandai dibaca.');
                }
            } catch (e) {
                console.error('Failed to mark all read:', e);
            }
        };

        window.formatTimeAgo = function(date) {
            const seconds = Math.floor((new Date() - date) / 1000);
            let interval = Math.floor(seconds / 31536000);

            if (interval >= 1) return interval + " thn";
            interval = Math.floor(seconds / 2592000);
            if (interval >= 1) return interval + " bln";
            interval = Math.floor(seconds / 86400);
            if (interval >= 1) return interval + " hari";
            interval = Math.floor(seconds / 3600);
            if (interval >= 1) return interval + " jam";
            interval = Math.floor(seconds / 60);
            if (interval >= 1) return interval + " mnt";
            return "baru";
        };

        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profile-dropdown');
            if (dropdown && !e.target.closest('#nav-auth-container')) {
                dropdown.classList.add('hidden');
            }
            
            const notifDropdown = document.getElementById('notification-dropdown');
            if (notifDropdown && !e.target.closest('#nav-notification-container')) {
                notifDropdown.classList.add('hidden');
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            window.updateCartBadge();
            window.syncAuthHeader();
            updateDarkModeIcons();
            
            const mobSearch = document.getElementById('mobile-navbar-search');
            if (mobSearch) {
                mobSearch.addEventListener('input', (e) => {
                    const navSearch = document.getElementById('navbar-search');
                    if (navSearch) {
                        navSearch.value = e.target.value;
                        navSearch.dispatchEvent(new Event('input'));
                    }
                });
            }
        });
    </script>
</body>
</html>
