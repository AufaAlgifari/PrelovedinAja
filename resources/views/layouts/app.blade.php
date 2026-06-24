<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Preloved.in Aja - Pasar Kampus UNSOED</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/favicon.svg">
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

    <nav class="bg-brand-100/90 backdrop-blur-md border-b border-brand-500/20 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center gap-4">
                
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

                <div id="nav-guest-links" class="hidden md:flex items-center gap-10 text-sm font-semibold">
                    <a href="{{ route('home') }}" class="text-brand-900 hover:text-brand-600 transition">Beranda</a>
                    <a href="{{ route('products.index') }}" class="text-brand-900 hover:text-brand-600 transition">Produk</a>
                    <a href="{{ route('about') }}" class="text-brand-900 hover:text-brand-600 transition">Tentang Kami</a>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">
                    
                    <div id="nav-btn-cart" class="hidden">
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-brand-600 hover:text-brand-900 rounded-xl hover:bg-brand-50 transition-all group block">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.116 60.116 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            <span id="cart-badge" class="absolute -top-0.5 -right-0.5 bg-brand-600 text-brand-50 text-[10px] font-bold h-5 w-5 rounded-full border-2 border-brand-100 flex items-center justify-center scale-0 transition-all duration-300">0</span>
                        </a>
                    </div>

                    <div id="nav-btn-chat" class="hidden">
                        <a href="{{ route('chat.index') }}" class="relative p-2 text-brand-600 hover:text-brand-900 rounded-xl hover:bg-brand-50 transition-all group block">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </a>
                    </div>

                    <div class="relative hidden sm:block" id="nav-notification-container"></div>

                    <div id="nav-guest-actions" class="hidden sm:flex items-center gap-3">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-brand-50 hover:bg-brand-600 hover:text-brand-50 text-brand-900 text-sm font-semibold rounded-full border border-brand-500/30 transition-all duration-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 btn-gradient text-xs font-bold rounded-full shadow-sm shadow-brand-600/20">
                            Daftar
                        </a>
                    </div>

                    <div class="relative hidden sm:block" id="nav-auth-container">
                        </div>

                    <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-brand-600 hover:text-brand-900 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-brand-100 border-t border-brand-500/20 px-4 pt-2 pb-6 space-y-4 shadow-inner">
            <div id="mobile-guest-links" class="hidden flex flex-col gap-3 pt-2">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-brand-900 hover:text-brand-600 transition px-2">Beranda</a>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-brand-900 hover:text-brand-600 transition px-2">Produk</a>
                <a href="{{ route('about') }}" class="text-sm font-semibold text-brand-900 hover:text-brand-600 transition px-2">Tentang Kami</a>
            </div>

            <div id="mobile-notifications-section" class="pt-1"></div>

            <div class="flex flex-col gap-2.5 pt-1" id="mobile-auth-container">
                </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

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
                    <li><a href="{{ route('products.index') }}?category=Textbooks" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Buku Kuliah (Textbooks)</a></li>
                    <li><a href="{{ route('products.index') }}?category=Electronics" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Elektronik & Gadget</a></li>
                    <li><a href="{{ route('products.index') }}?category=Dorm Life" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Perabotan Kost</a></li>
                    <li><a href="{{ route('products.index') }}?category=Apparel" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Pakaian & Sepatu</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-[#FBF6EC] text-sm mb-4">Layanan & Aturan</h4>
                <ul class="space-y-3 text-xs">
                    <li><a href="{{ route('about') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Aturan COD Kampus</a></li>
                    <li><a href="{{ route('about') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Panduan Keamanan</a></li>
                    <li><a href="{{ route('transactions.history') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-medium">Riwayat Transaksi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-[#FBF6EC] text-sm mb-4">Akses Cepat</h4>
                <ul id="footer-access-links" class="space-y-3 text-xs">
                    <li><a href="{{ route('products.index') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-semibold">Katalog Produk</a></li>
                    <li><a href="{{ route('profile.index') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-semibold">Profil Saya</a></li>
                    <li><a href="{{ route('chat.index') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-semibold">Pesan Masuk</a></li>
                    <li id="footer-seller-link" class="hidden"><a href="{{ route('seller.dashboard') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-semibold">Seller Dashboard</a></li>
                    <li id="footer-admin-link" class="hidden"><a href="{{ route('admin.dashboard') }}" class="text-[#FBF6EC]/70 hover:text-[#D4A017] transition font-semibold">Admin Dashboard</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 text-center text-xs text-[#FBF6EC]/35 font-light">
            &copy; 2026 Preloved.in. Developed for Software Engineering coursework.
        </div>
    </footer>

    <div id="toast-container" class="fixed top-24 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <script>
        // Mobile drawer menu toggle
        window.toggleMobileMenu = function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        };

        // Faculty name shortening utility
        window.shortenFaculty = function(name) {
            if (!name) return '';
            const map = {
                'pertanian': 'Faperta',
                'biologi': 'F.Bio',
                'ekonomi dan bisnis': 'FEB',
                'ekonomi': 'FEB',
                'peternakan': 'Fapet',
                'hukum': 'FH',
                'ilmu sosial dan ilmu politik': 'FISIP',
                'fisip': 'FISIP',
                'kedokteran': 'FK',
                'teknik': 'FT',
                'ilmu-ilmu kesehatan': 'FIKes',
                'ilmu kesehatan': 'FIKes',
                'ilmu budaya': 'FIB',
                'mipa': 'FMIPA',
                'perikanan dan ilmu kelautan': 'FPIK',
            };
            const cleaned = name.trim().toLowerCase().replace(/^fakultas\s+/, '');
            for (const [key, val] of Object.entries(map)) {
                if (cleaned === key || cleaned.includes(key)) return val;
            }
            // Fallback: return first 6 chars
            return name.length > 8 ? name.substring(0, 6) + '.' : name;
        };

        // Toast notifications
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-lg border text-sm font-semibold transition-all duration-300 transform -translate-y-10 opacity-0 pointer-events-auto max-w-sm`;
            
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
            setTimeout(() => toast.classList.remove('-translate-y-10', 'opacity-0'), 10);
            setTimeout(() => {
                toast.classList.add('-translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        };

        // Cart utilities
        window.updateCartBadge = async function() {
            const token = localStorage.getItem('preloved_token');
            const badge = document.getElementById('cart-badge');
            const mobileBadge = document.getElementById('mobile-cart-badge');
            
            if (!token) {
                if (badge) {
                    badge.textContent = '0';
                    badge.classList.remove('scale-100');
                    badge.classList.add('scale-0');
                }
                if (mobileBadge) mobileBadge.textContent = '0';
                return;
            }

            try {
                const response = await fetch('/api/v1/cart', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                if (response.ok) {
                    const carts = await response.json();
                    const totalItems = carts.length;
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
                }
            } catch (error) {
                console.error('Error updating cart badge:', error);
            }
        };

        window.addToCart = async function(product, showFeedback = true) {
            const token = localStorage.getItem('preloved_token');
            if (!token) {
                window.showToast('Silakan login terlebih dahulu untuk menambahkan barang ke keranjang.', 'error');
                setTimeout(() => {
                    window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.pathname);
                }, 1000);
                return false;
            }

            try {
                const response = await fetch('/api/v1/cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({ product_id: product.id })
                });

                const data = await response.json();

                if (response.ok) {
                    await window.updateCartBadge();
                    if (showFeedback) {
                        if (response.status === 201) {
                            window.showToast(data.message || 'Produk berhasil ditambahkan ke keranjang!');
                        } else {
                            window.showToast(data.message || 'Produk ini sudah ada di keranjang kamu.', 'info');
                        }
                    }
                    return true;
                } else {
                    window.showToast(data.message || 'Gagal menambahkan produk ke keranjang.', 'error');
                    return false;
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                window.showToast('Terjadi kesalahan saat menambahkan ke keranjang.', 'error');
                return false;
            }
        };

        window.removeFromCart = async function(cartId) {
            const token = localStorage.getItem('preloved_token');
            if (!token) return false;

            try {
                const response = await fetch(`/api/v1/cart/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                const data = await response.json();
                if (response.ok) {
                    await window.updateCartBadge();
                    window.showToast(data.message || 'Item berhasil dihapus dari keranjang.');
                    return true;
                } else {
                    window.showToast(data.message || 'Gagal menghapus item.', 'error');
                    return false;
                }
            } catch (error) {
                console.error('Error removing from cart:', error);
                return false;
            }
        };

        // UI Helpers
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

        // Sync auth state & dynamic element generation
        window.syncAuthHeader = function() {
            const userJson = localStorage.getItem('preloved_user');
            
            const navGuestLinks = document.getElementById('nav-guest-links');
            const navGuestActions = document.getElementById('nav-guest-actions');
            const navBtnCart = document.getElementById('nav-btn-cart');
            const navBtnChat = document.getElementById('nav-btn-chat');
            const navAuthContainer = document.getElementById('nav-auth-container');
            
            const mobileGuestLinks = document.getElementById('mobile-guest-links');
            const mobileAuthContainer = document.getElementById('mobile-auth-container');
            const notifContainer = document.getElementById('nav-notification-container');

            if (userJson) {
                const user = JSON.parse(userJson);
                
                window.showNavElement(navGuestLinks, 'flex');
                window.showNavElement(mobileGuestLinks, 'flex');
                window.showNavElement(navBtnCart, 'block');
                window.showNavElement(navBtnChat, 'block');
                window.showNavElement(navAuthContainer);
                window.hideNavElement(navGuestActions);

                const verifyBadge = user.is_verified ? '<span class="ml-1.5 bg-brand-600 text-brand-50 text-[8px] font-extrabold px-1.5 py-0.5 rounded-full">Verified</span>' : '';
                let dashboardLink = '';
                if (user.role === 'admin') {
                    dashboardLink = `<a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-xs font-bold text-brand-900 hover:bg-brand-100/50">Admin Dashboard</a>`;
                } else {
                    dashboardLink = `<a href="{{ route('seller.dashboard') }}" class="block px-4 py-2.5 text-xs font-bold text-brand-900 hover:bg-brand-100/50">Seller Dashboard</a>`;
                }

                let mobileDashboardLink = '';
                if (user.role === 'admin') {
                    mobileDashboardLink = `<a href="{{ route('admin.dashboard') }}" class="w-full text-center py-2.5 bg-brand-100 text-brand-900 border border-brand-500/35 font-bold text-xs rounded-xl block">Admin Dashboard</a>`;
                } else {
                    mobileDashboardLink = `<a href="{{ route('seller.dashboard') }}" class="w-full text-center py-2.5 bg-brand-100 text-brand-900 border border-brand-500/35 font-bold text-xs rounded-xl block">Seller Dashboard</a>`;
                }

                const hasCustomAvatar = user.avatar_url && user.avatar_url !== 'null' && user.avatar_url !== '';
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

                // Render Desktop Profile
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

                // Render Desktop Notifications
                if (notifContainer) {
                    notifContainer.classList.remove('hidden');
                    notifContainer.innerHTML = `
                        <div class="relative inline-block text-left">
                            <button id="notification-bell-btn" onclick="toggleNotifDropdown()" class="relative p-2 text-brand-600 hover:text-brand-900 rounded-xl hover:bg-brand-50 transition-all group focus:outline-none flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <span id="notification-badge" class="absolute -top-0.5 -right-0.5 bg-rose-600 text-white text-[10px] font-bold h-5 w-5 rounded-full border-2 border-brand-100 flex items-center justify-center scale-0 transition-all duration-300">0</span>
                            </button>
                            <div id="notification-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-80 rounded-2xl shadow-xl bg-brand-50 border border-brand-500/25 focus:outline-none z-50 overflow-hidden">
                                <div class="px-4 py-3 bg-brand-100/30 flex justify-between items-center">
                                    <span class="text-xs font-extrabold text-brand-900 font-heading">Notifikasi</span>
                                    <button onclick="window.markAllNotificationsRead()" class="text-[10px] font-bold text-brand-600 hover:text-brand-900 focus:outline-none transition">Tandai Semua Dibaca</button>
                                </div>
                                <div id="notification-items-list" class="max-h-72 overflow-y-auto divide-y divide-brand-500/10">
                                    <div class="p-5 text-center text-xs text-brand-600 font-medium">Memuat notifikasi...</div>
                                </div>
                            </div>
                        </div>
                    `;
                    window._onNotifContainerReady(); // starts polling + immediate fetch
                }

                // Render Mobile Profile Menu Links
                if (mobileAuthContainer) {
                    mobileAuthContainer.innerHTML = `
                        <div class="flex items-center gap-3 p-3 bg-brand-50 border border-brand-500/20 rounded-2xl">
                            ${mobileAvatarHtml}
                            <div class="text-left flex-1 min-w-0">
                                <p class="text-sm font-bold text-brand-900 leading-tight truncate">${user.name}</p>
                                <p class="text-xs font-medium text-brand-650 truncate">${user.unsoed_major || 'UNSOED'}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 py-1">
                            <a href="{{ route('profile.index') }}" class="text-sm font-semibold text-brand-900 hover:text-brand-600 transition px-2 py-1.5 rounded-xl hover:bg-brand-50">Profil Saya</a>
                            <a href="{{ route('transactions.history') }}" class="text-sm font-semibold text-brand-900 hover:text-brand-600 transition px-2 py-1.5 rounded-xl hover:bg-brand-50">Riwayat Transaksi</a>
                        </div>
                        ${mobileDashboardLink}
                        <button onclick="window.logoutUser()" class="w-full text-center py-2.5 bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 font-bold text-xs rounded-xl block">
                            Keluar Akun
                        </button>
                    `;
                }

            } else {
                // State GUEST (Belum Login)
                window.showNavElement(navGuestActions, 'flex');
                window.hideNavElement(navBtnCart);
                window.hideNavElement(navBtnChat);
                window.hideNavElement(navAuthContainer);
                if (notifContainer) window.hideNavElement(notifContainer);

                if (mobileAuthContainer) {
                    mobileAuthContainer.innerHTML = `
                        <a href="{{ route('login') }}" class="w-full text-center py-2.5 bg-brand-50 hover:bg-brand-600 hover:text-brand-50 text-brand-900 text-sm font-semibold rounded-xl border border-brand-500/30 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="w-full text-center py-2.5 btn-gradient text-xs font-bold rounded-xl shadow-sm">
                            Daftar
                        </a>
                    `;
                }
            }
        };

        // Fungsi Penanganan Keluar / Logout Akun
        window.logoutUser = async function() {
            const token = localStorage.getItem('preloved_token');
            window.showToast('Sedang keluar...', 'info');

            if (token) {
                try {
                    // Kirim request logout ke Backend API Laravel
                    await fetch('/logout', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                } catch (error) {
                    console.error('Error saat menghubungi endpoint logout:', error);
                }
            }

            // Hapus data autentikasi lokal client-side
            if (window.stopNotificationPolling) window.stopNotificationPolling();
            localStorage.removeItem('preloved_token');
            localStorage.removeItem('preloved_user');
            localStorage.removeItem('has_filled_sell_form');

            window.showToast('Berhasil keluar akun.');

            // Alihkan halaman ke Home dan reset state UI
            setTimeout(() => {
                window.location.href = "{{ route('home') }}";
            }, 800);
        };

        // ─── Notification System ──────────────────────────────────────────
        let _notifPollTimer = null;
        let _notifRendered  = false; // guard so we only start poll after DOM is ready

        // Called by syncAuthHeader after it injects the bell HTML into the DOM
        window._onNotifContainerReady = function() {
            _notifRendered = true;
            window.startNotificationPolling();
        };

        window.startNotificationPolling = function() {
            if (_notifPollTimer) clearInterval(_notifPollTimer);
            window.fetchNotifications(); // immediate first fetch
            _notifPollTimer = setInterval(window.fetchNotifications, 12000); // every 12s
        };

        window.stopNotificationPolling = function() {
            if (_notifPollTimer) { clearInterval(_notifPollTimer); _notifPollTimer = null; }
        };

        // Toggle open/close
        window.toggleNotifDropdown = function() {
            const dropdown = document.getElementById('notification-dropdown');
            if (!dropdown) return;
            const isOpen = !dropdown.classList.contains('hidden');
            dropdown.classList.toggle('hidden');
            if (!isOpen) {
                // Just opened → refresh
                window.fetchNotifications();
            }
        };

        // Close when clicking outside the notification container
        document.addEventListener('click', function(e) {
            const container = document.getElementById('nav-notification-container');
            const dropdown  = document.getElementById('notification-dropdown');
            if (container && dropdown && !container.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Fetch notifications from API
        window.fetchNotifications = async function() {
            const token = localStorage.getItem('preloved_token');
            if (!token) return;

            try {
                const res = await fetch('/api/v1/notifications', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (!res.ok) return;

                const json = await res.json();
                const notifications = json.data   || [];
                const unreadCount   = json.unread_count ?? notifications.filter(n => !n.read_at).length;

                window._renderNotificationBadge(unreadCount);
                window._renderNotificationList(notifications);

            } catch (_) { /* offline / server down — silently ignore */ }
        };

        // Update the red badge on the bell
        window._renderNotificationBadge = function(count) {
            const badge = document.getElementById('notification-badge');
            if (!badge) return;
            const n = parseInt(count) || 0;
            badge.textContent = n > 9 ? '9+' : n;
            if (n > 0) {
                badge.classList.remove('scale-0');
                badge.classList.add('scale-100');
            } else {
                badge.classList.remove('scale-100');
                badge.classList.add('scale-0');
            }
        };

        // Render the list of notification items
        window._renderNotificationList = function(notifications) {
            const list = document.getElementById('notification-items-list');
            if (!list) return;

            if (!notifications || notifications.length === 0) {
                list.innerHTML = `
                    <div class="py-10 text-center">
                        <div class="flex justify-center mb-2 text-brand-500/30">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <p class="text-xs text-brand-600 font-medium">Belum ada notifikasi</p>
                    </div>`;
                return;
            }

            list.innerHTML = notifications.slice(0, 25).map(notif => {
                const data    = notif.data    || {};
                const isUnread = !notif.read_at;
                const timeAgo = window._timeAgo(notif.created_at);
                const type    = data.type || '';

                let iconHtml = '';
                let actionUrl = '#';
                let rowBg = isUnread ? 'bg-amber-50' : '';

                // ── Message notification (buyer → seller  OR  seller → buyer) ──
                if (type === 'new_message') {
                    iconHtml = `<div class="w-9 h-9 rounded-full bg-sky-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>`;
                    // Go to chat with the sender
                    const senderId = data.sender_id;
                    actionUrl = senderId ? `/chat?contact_id=${senderId}` : '/chat';

                // ── Order notification (buyer checkout → seller) ──
                } else if (type === 'new_order') {
                    iconHtml = `<div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>`;
                    actionUrl = '/seller/dashboard';

                // ── Generic / fallback ──
                } else {
                    iconHtml = `<div class="w-9 h-9 rounded-full bg-brand-500/15 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>`;
                    actionUrl = data.url || '#';
                }

                const title   = _escHtml(data.title   || 'Notifikasi');
                const message = _escHtml(data.message || '');
                const notifId = notif.id || '';

                return `
                    <a href="${actionUrl}"
                       onclick="window.markNotificationRead('${notifId}'); return true;"
                       class="flex items-start gap-3 px-4 py-3.5 hover:bg-brand-100/50 transition-colors cursor-pointer ${rowBg} border-b border-brand-500/8 last:border-0">
                        ${iconHtml}
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] font-bold text-brand-900 leading-snug">${title}</p>
                            <p class="text-[10px] text-brand-600/80 mt-0.5 leading-relaxed line-clamp-2">${message}</p>
                            <span class="text-[9px] text-brand-600/50 font-medium mt-1 block">${timeAgo}</span>
                        </div>
                        ${isUnread ? '<span class="w-2 h-2 rounded-full bg-rose-500 shrink-0 mt-1.5 flex-none"></span>' : ''}
                    </a>
                `;
            }).join('');
        };

        // Mark a single notification as read (fire & forget)
        window.markNotificationRead = async function(id) {
            const token = localStorage.getItem('preloved_token');
            if (!token || !id || id === 'undefined' || id === 'null') return;
            try {
                await fetch(`/api/v1/notifications/${id}/read`, {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });
                // Refresh badge after a short delay
                setTimeout(window.fetchNotifications, 400);
            } catch (_) { /* ignore */ }
        };

        // Mark all as read
        window.markAllNotificationsRead = async function() {
            const token = localStorage.getItem('preloved_token');
            if (!token) return;
            try {
                await fetch('/api/v1/notifications/read-all', {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });
                await window.fetchNotifications();
            } catch (_) { /* ignore */ }
        };

        // Relative time helper
        window._timeAgo = function(dateStr) {
            if (!dateStr) return '';
            const diff = Math.floor((Date.now() - new Date(dateStr)) / 1000);
            if (diff < 60)     return 'Baru saja';
            if (diff < 3600)   return Math.floor(diff / 60)   + ' menit lalu';
            if (diff < 86400)  return Math.floor(diff / 3600)  + ' jam lalu';
            if (diff < 604800) return Math.floor(diff / 86400) + ' hari lalu';
            return new Date(dateStr).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
        };

        // HTML escape helper (prevents XSS in notification content)
        function _escHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        // Jalankan sinkronisasi awal saat dokumen selesai dimuat
        // Render footer links based on user role
        window.syncFooterLinks = function() {
            const userJson = localStorage.getItem('preloved_user');
            const sellerLink = document.getElementById('footer-seller-link');
            const adminLink = document.getElementById('footer-admin-link');
            if (userJson) {
                try {
                    const user = JSON.parse(userJson);
                    if (user.role === 'admin') {
                        if (adminLink) adminLink.classList.remove('hidden');
                    } else {
                        if (sellerLink) sellerLink.classList.remove('hidden');
                    }
                } catch (e) { /* ignore */ }
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            window.syncAuthHeader(); // this will call _onNotifContainerReady if logged in
            window.updateCartBadge();
            window.syncFooterLinks();
        });
    </script>
    @stack('scripts')
</body>
</html>