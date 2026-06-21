<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Preloved.in Aja - Pasar Kampus UNSOED</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @yield('head')
    <script>
        window.isHomepage = {{ Request::routeIs('home') ? 'true' : 'false' }};
        window.isAboutPage = {{ Request::routeIs('about') ? 'true' : 'false' }};
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
            to { opacity: 1; transform: none; }
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

                <!-- Guest Navigation Links (Desktop) -->
                <div id="nav-guest-links" class="hidden md:flex items-center gap-10 text-sm font-semibold">
                    <a href="{{ route('home') }}" class="text-brand-900 hover:text-brand-600 transition">Beranda</a>
                    <a href="{{ route('products.index') }}" class="text-brand-900 hover:text-brand-600 transition">Produk</a>
                    <a href="{{ route('about') }}" class="text-brand-900 hover:text-brand-600 transition">Tentang Kami</a>
                </div>



                <!-- Right Nav Elements -->
                <div class="flex items-center gap-2 sm:gap-4">
                    

                    <!-- Keranjang Belanja -->
                    <div id="nav-btn-cart" class="hidden">
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-brand-600 hover:text-brand-900 rounded-xl hover:bg-brand-50 transition-all group block">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.116 60.116 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            <span id="cart-badge" class="absolute -top-0.5 -right-0.5 bg-brand-600 text-brand-50 text-[10px] font-bold h-5 w-5 rounded-full border-2 border-brand-100 flex items-center justify-center scale-0 transition-all duration-300">0</span>
                        </a>
                    </div>

                    <!-- Pesan / Chat Link -->
                    <div id="nav-btn-chat" class="hidden">
                        <a href="{{ route('chat.index') }}" class="relative p-2 text-brand-600 hover:text-brand-900 rounded-xl hover:bg-brand-50 transition-all group block">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Guest Authentication Actions (Desktop) -->
                    <div id="nav-guest-actions" class="hidden sm:flex items-center gap-3">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-brand-50 hover:bg-brand-600 hover:text-brand-50 text-brand-900 text-sm font-semibold rounded-full border border-brand-500/30 transition-all duration-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 btn-gradient text-xs font-bold rounded-full shadow-sm shadow-brand-600/20">
                            Daftar
                        </a>
                    </div>

                    <!-- User Profile Dropdown (Logged-In Only) -->
                    <div class="relative hidden sm:block" id="nav-auth-container">
                        <!-- Profile avatar and menu dropdown injected via JS -->
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

            
            <!-- Mobile Guest Links (Only Guest) -->
            <div id="mobile-guest-links" class="hidden flex flex-col gap-3 pt-2">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-brand-900 hover:text-brand-600 transition px-2">Beranda</a>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-brand-900 hover:text-brand-600 transition px-2">Produk</a>
                <a href="{{ route('about') }}" class="text-sm font-semibold text-brand-900 hover:text-brand-600 transition px-2">Tentang Kami</a>
            </div>

            <!-- Mobile Authentication & Profile Actions -->
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
                toast.className += ' bg-emerald-50 text-emerald-800 border-emerald-100';
                toast.innerHTML = `<span class="text-emerald-500">✓</span><span>${message}</span>`;
            } else if (type === 'error') {
                toast.className += ' bg-rose-50 text-rose-800 border-rose-100';
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

        // Helpers to show/hide elements overriding Tailwind utility classes
        window.hideNavElement = function(el) {
            if (el) el.style.setProperty('display', 'none', 'important');
        };
        
        window.showNavElement = function(el, displayStyle = '') {
            if (el) {
                el.style.removeProperty('display');
                if (displayStyle) {
                    el.style.setProperty('display', displayStyle, 'important');
                }
            }
        };
        // Sync auth state
        window.syncAuthHeader = function() {
            const userJson = localStorage.getItem('preloved_user');
            
            // Desktop elements
            const navGuestLinks = document.getElementById('nav-guest-links');
            const navGuestActions = document.getElementById('nav-guest-actions');
            const navBtnCart = document.getElementById('nav-btn-cart');
            const navBtnChat = document.getElementById('nav-btn-chat');
            const navAuthContainer = document.getElementById('nav-auth-container');
            
            // Mobile elements
            const mobileGuestLinks = document.getElementById('mobile-guest-links');
            const mobileAuthContainer = document.getElementById('mobile-auth-container');

            if (userJson) {
                const user = JSON.parse(userJson);
                
                // Show logged-in elements - Always show navigation links
                window.showNavElement(navGuestLinks, 'flex');
                window.showNavElement(mobileGuestLinks, 'flex');

                window.showNavElement(navBtnCart, 'block');
                window.showNavElement(navBtnChat, 'block');
                window.showNavElement(navAuthContainer);
                
                // Hide guest actions (Masuk/Daftar)
                window.hideNavElement(navGuestActions);

                const verifyBadge = user.is_verified ? '<span class="ml-1.5 bg-brand-600 text-brand-50 text-[8px] font-extrabold px-1.5 py-0.5 rounded-full">Verified</span>' : '';
                
                // Check if user has filled sell form (listed any products)
                const hasFilledSellForm = localStorage.getItem('has_filled_sell_form') === 'true' || JSON.parse(localStorage.getItem('preloved_custom_products') || '[]').length > 0;
                
                let dashboardLink = '';
                if (user.role === 'admin') {
                    dashboardLink = `<a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-xs font-bold text-brand-900 hover:bg-brand-100/50">Admin Dashboard</a>`;
                } else if (hasFilledSellForm) {
                    dashboardLink = `<a href="{{ route('seller.dashboard') }}" class="block px-4 py-2.5 text-xs font-bold text-brand-900 hover:bg-brand-100/50">Seller Dashboard</a>`;
                }

                let mobileDashboardLink = '';
                if (user.role === 'admin') {
                    mobileDashboardLink = `<a href="/admin/dashboard" class="w-full text-center py-2.5 bg-brand-100 text-brand-900 border border-brand-500/35 font-bold text-xs rounded-xl block">Admin Dashboard</a>`;
                } else if (hasFilledSellForm) {
                    mobileDashboardLink = `<a href="{{ route('seller.dashboard') }}" class="w-full text-center py-2.5 bg-brand-100 text-brand-900 border border-brand-500/35 font-bold text-xs rounded-xl block">Seller Dashboard</a>`;
                }

                const hasCustomAvatar = user.avatar_url && !user.avatar_url.includes('unsplash.com');
                const avatarHtml = hasCustomAvatar
                    ? `<img class="h-9 w-9 rounded-full object-cover border-2 border-brand-500 shadow-sm" src="${user.avatar_url}" alt="${user.name}">`
                    : `<div class="h-9 w-9 rounded-full bg-[#7A4A10]/15 text-[#7A4A10] flex items-center justify-center border-2 border-brand-500 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                       </div>`;

                const mobileAvatarHtml = hasCustomAvatar
                    ? `<img class="h-10 w-10 rounded-full object-cover border border-brand-500" src="${user.avatar_url}">`
                    : `<div class="h-10 w-10 rounded-full bg-[#7A4A10]/15 text-[#7A4A10] flex items-center justify-center border border-brand-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                       </div>`;

                // Render Desktop Profile Dropdown
                if (navAuthContainer) {
                    navAuthContainer.innerHTML = `
                        <div class="relative inline-block text-left">
                            <button onclick="document.getElementById('profile-dropdown').classList.toggle('hidden')" class="flex items-center gap-2 focus:outline-none hover:bg-brand-100 p-1.5 rounded-full transition duration-150">
                                ${avatarHtml}
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

                // Render Mobile Profile Menu Links
                if (mobileAuthContainer) {
                    mobileAuthContainer.innerHTML = `
                        <div class="flex items-center gap-3 p-3 bg-brand-50 border border-brand-500/20 rounded-2xl">
                            ${mobileAvatarHtml}
                            <div class="flex-1">
                                <p class="text-xs font-extrabold text-brand-900 flex items-center">${user.name} ${verifyBadge}</p>
                                <p class="text-[9px] text-brand-650">${user.unsoed_faculty || 'Fakultas'} / ${user.unsoed_major || 'UNSOED'}</p>
                            </div>
                        </div>
                        <a href="{{ route('profile.index') }}" class="w-full text-center py-2.5 bg-brand-100 text-brand-900 border border-brand-500/35 font-bold text-xs rounded-xl block mt-3">
                            Profil Saya
                        </a>
                        ${mobileDashboardLink}
                        <a href="{{ route('transactions.history') }}" class="w-full text-center py-2.5 bg-brand-100 text-brand-900 border border-brand-500/35 font-bold text-xs rounded-xl block">
                            Riwayat Transaksi
                        </a>
                        <button onclick="window.logoutUser()" class="w-full text-center py-2.5 bg-rose-50 text-rose-700 font-extrabold text-xs rounded-xl flex items-center justify-center gap-2 border border-rose-100">
                            Keluar Akun
                        </button>
                    `;
                }
            } else {
                // Hide logged-in elements
                window.showNavElement(navGuestLinks);
                window.showNavElement(navGuestActions);
                window.showNavElement(mobileGuestLinks, 'flex');
                
                window.hideNavElement(navBtnCart);
                window.hideNavElement(navBtnChat);
                window.hideNavElement(navAuthContainer);

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

        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profile-dropdown');
            if (dropdown && !e.target.closest('#nav-auth-container')) {
                dropdown.classList.add('hidden');
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            window.updateCartBadge();
            window.syncAuthHeader();
        });
    </script>
</body>
</html>
