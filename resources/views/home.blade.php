@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[calc(100vh-80px)] flex flex-col justify-center bg-[#F5E4B0]/60 text-[#2E1A06] py-20 px-4 overflow-hidden border-b border-[#D4A017]/20">
    <!-- Decorative abstract grids/glows -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(212,160,23,0.06)_1px,transparent_1px),linear-gradient(to_bottom,rgba(212,160,23,0.06)_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-40"></div>
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#D4A017]/10 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 right-0 w-80 h-80 bg-[#7A4A10]/5 rounded-full blur-3xl"></div>

    <div class="w-full max-w-5xl mx-auto text-center relative z-10 space-y-6">
        <!-- Guest Content -->
        <div id="hero-guest-content" class="space-y-6">
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
                <a href="{{ route('login') }}?redirect={{ urlencode(route('products.index')) }}" id="hero-btn-shop" class="px-8 py-3.5 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-extrabold text-sm rounded-full shadow-md hover:shadow-lg transition-all duration-350 transform hover:-translate-y-0.5">
                    Mulai Belanja
                </a>
                <a href="{{ route('login') }}?redirect={{ urlencode(route('products.create')) }}" id="hero-btn-sell" class="px-8 py-3.5 bg-transparent hover:bg-[#7A4A10]/5 text-[#7A4A10] border-2 border-[#7A4A10] font-extrabold text-sm rounded-full transition-all duration-350">
                    Jual Barang
                </a>
            </div>
        </div>

        <!-- Logged-In User Content -->
        <div id="hero-user-content" class="hidden space-y-6">
            <h1 class="text-4xl md:text-6xl font-black tracking-tight leading-tight font-heading text-[#2E1A06]">
                Halo, <span id="hero-user-name" class="text-[#7A4A10]"></span> <br>
                Selamat datang di <span class="text-[#D4A017]">Preloved.in</span>
            </h1>
            <p class="max-w-2xl mx-auto text-[#2E1A06]/85 text-sm md:text-base leading-relaxed font-light">
                Temukan barang preloved berkualitas dari sesama mahasiswa dengan aman dan terpercaya
            </p>

            <!-- Action Buttons for Logged-In User -->
            <div class="flex flex-wrap justify-center gap-4 pt-4">
                <a href="#catalog-section" class="px-8 py-3.5 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-extrabold text-sm rounded-full shadow-md hover:shadow-lg transition-all duration-350 transform hover:-translate-y-0.5">
                    Mulai Belanja
                </a>
                <a href="{{ route('products.create') }}" class="px-8 py-3.5 bg-transparent hover:bg-[#7A4A10]/5 text-[#7A4A10] border-2 border-[#7A4A10] font-extrabold text-sm rounded-full transition-all duration-350">
                    Jual Barang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Kategori Section (Swapped dynamically based on login state) -->
<section id="category-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16 overflow-hidden">
    <!-- Guest View (Grid Layout) -->
    <div id="category-guest-view" class="space-y-8">
        <div class="mb-8">
            <h2 class="text-2xl font-black text-[#2E1A06] font-heading">Kategori Populer</h2>
            <p class="text-xs text-[#7A4A10] mt-1">Barang yang paling banyak dicari mahasiswa minggu ini.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Buku Kuliah (Large Card) -->
            <div class="relative md:col-span-2 rounded-3xl overflow-hidden shadow-sm h-64 md:h-80 flex items-center p-8 bg-cover bg-center text-[#2E1A06] border border-[#D4A017]/25" style="background-image: linear-gradient(to right, rgba(245, 228, 176, 0.95) 45%, rgba(245, 228, 176, 0.4) 100%), url('https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=800&q=80')">
                <span class="absolute top-6 right-6 bg-white text-[#7A4A10] text-[10px] font-bold px-3 py-1.5 rounded-full border border-[#D4A017]/20 shadow-sm">
                    Harga Mulai 10rb
                </span>
                <div class="space-y-4 max-w-sm">
                    <h3 class="text-3xl font-black font-heading text-[#2E1A06]">Buku Kuliah</h3>
                    <p class="text-xs text-[#2E1A06]/85 font-light">Hemat lebih banyak, beli buku bekas berkualitas</p>
                    <a href="{{ route('products.index') }}?category=Textbooks" class="inline-block px-6 py-2.5 bg-white hover:bg-brand-50 text-[#7A4A10] font-bold text-xs rounded-full border border-[#D4A017]/20 shadow-sm transition duration-200">
                        Jelajahi
                    </a>
                </div>
            </div>

            <!-- Elektronik (Small Card) -->
            <div class="bg-white rounded-3xl overflow-hidden border border-[#D4A017]/20 shadow-sm flex flex-col justify-between h-64 md:h-80 card-premium">
                <div class="h-1/2 overflow-hidden bg-gray-150">
                    <img src="https://images.unsplash.com/photo-1588702547923-7093a6c3ba33?auto=format&fit=crop&w=600&q=80" alt="Elektronik" class="w-full h-full object-cover">
                </div>
                <div class="p-6 flex-grow flex flex-col justify-center">
                    <h3 class="text-lg font-black font-heading text-[#2E1A06]">Elektronik</h3>
                    <p class="text-xs text-[#7A4A10] mt-1 font-light">Laptop, tablet, dan gadget bekas berkualitas siap pakai</p>
                </div>
            </div>

            <!-- Pakaian (Small Card) -->
            <div class="bg-white rounded-3xl overflow-hidden border border-[#D4A017]/20 shadow-sm flex flex-col justify-between h-64 md:h-80 card-premium">
                <div class="h-1/2 overflow-hidden bg-gray-150">
                    <img src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=600&q=80" alt="Pakaian" class="w-full h-full object-cover">
                </div>
                <div class="p-6 flex-grow flex flex-col justify-center">
                    <h3 class="text-lg font-black font-heading text-[#2E1A06]">Pakaian</h3>
                    <p class="text-xs text-[#7A4A10] mt-1 font-light">Thrifting outfit kampus dari brand lokal hingga impor</p>
                </div>
            </div>

            <!-- Furnitur (Large Card) -->
            <div class="relative md:col-span-2 rounded-3xl overflow-hidden shadow-sm h-64 md:h-80 flex items-center p-8 bg-cover bg-center text-[#2E1A06] border border-[#D4A017]/25" style="background-image: linear-gradient(to right, rgba(245, 228, 176, 0.95) 45%, rgba(245, 228, 176, 0.4) 100%), url('https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=800&q=80')">
                <div class="space-y-4 max-w-sm">
                    <h3 class="text-3xl font-black font-heading text-[#2E1A06]">Furnitur</h3>
                    <p class="text-xs text-[#2E1A06]/85 font-light">Meja, kursi, dan perabot kost bekas harga mahasiswa</p>
                    <a href="{{ route('products.index') }}?category=Dorm Life" class="inline-block px-6 py-2.5 bg-white hover:bg-brand-50 text-[#7A4A10] font-bold text-xs rounded-full border border-[#D4A017]/20 shadow-sm transition duration-200">
                        Jelajahi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Logged-In User View (3D Slider Layout) -->
    <div id="category-user-view" class="hidden space-y-2">
        <div class="mb-2 text-center">
            <h2 class="text-2xl font-black text-[#2E1A06] font-heading">Kategori</h2>
            <p class="text-xs text-[#7A4A10] mt-1 mx-auto max-w-md">Jelajahi barang berdasarkan kategori perkuliahan dan kebutuhan kampus.</p>
        </div>
        
        <div class="relative w-full overflow-hidden pt-2 pb-6 flex justify-center">
            <div id="category-slider-track" class="flex items-center gap-6 md:gap-10 transition-all duration-500 ease-out py-8 w-max" style="transform: translateX(0px);">
                <!-- Card 1: Buku Kuliah -->
                <a href="{{ route('products.index') }}?category=Textbooks" class="slider-card shrink-0 w-60 h-96 rounded-3xl p-6 flex flex-col justify-between text-white relative transition-all duration-350 shadow-lg cursor-pointer bg-gradient-to-br from-[#D4A017] to-[#7A4A10]" data-index="0">
                    <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm rounded-full p-2.5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="mt-8 flex justify-center items-center flex-grow">
                        <svg class="w-24 h-24 opacity-90 drop-shadow-md text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="space-y-2 text-left">
                        <h3 class="text-lg font-black font-heading text-white">Buku Kuliah</h3>
                        <p class="text-[10px] text-white/80 leading-normal font-light">Buku, diktat & modul kuliah Unsoed</p>
                        <div class="w-full bg-white/20 hover:bg-white/35 text-white font-bold py-2 rounded-xl text-center text-[10px] mt-2 transition duration-200">Jelajahi Kategori</div>
                    </div>
                </a>

                <!-- Card 2: Elektronik -->
                <a href="{{ route('products.index') }}?category=Electronics" class="slider-card shrink-0 w-60 h-96 rounded-3xl p-6 flex flex-col justify-between text-white relative transition-all duration-350 shadow-lg cursor-pointer bg-gradient-to-br from-[#7A4A10] to-[#2E1A06]" data-index="1">
                    <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm rounded-full p-2.5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25z" />
                        </svg>
                    </div>
                    <div class="mt-8 flex justify-center items-center flex-grow">
                        <svg class="w-24 h-24 opacity-90 drop-shadow-md text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25z" />
                        </svg>
                    </div>
                    <div class="space-y-2 text-left">
                        <h3 class="text-lg font-black font-heading text-white">Elektronik</h3>
                        <p class="text-[10px] text-white/80 leading-normal font-light">Laptop, HP, tablet, & gadget kampus</p>
                        <div class="w-full bg-white/20 hover:bg-white/35 text-white font-bold py-2 rounded-xl text-center text-[10px] mt-2 transition duration-200">Jelajahi Kategori</div>
                    </div>
                </a>

                <!-- Card 3: Peralatan Kost -->
                <a href="{{ route('products.index') }}?category=Dorm Life" class="slider-card shrink-0 w-60 h-96 rounded-3xl p-6 flex flex-col justify-between text-white relative transition-all duration-350 shadow-lg cursor-pointer bg-gradient-to-br from-[#2E1A06] to-[#D4A017]" data-index="2">
                    <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm rounded-full p-2.5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 7.5h1.5m-1.5 3h1.5m-7.5-3h1.5m-1.5 3h1.5m-3-6h16.5a1.5 1.5 0 011.5 1.5v18a1.5 1.5 0 01-1.5 1.5H3.75A1.5 1.5 0 012.25 21V3.364a1.5 1.5 0 011.5-1.5z" />
                        </svg>
                    </div>
                    <div class="mt-8 flex justify-center items-center flex-grow">
                        <svg class="w-24 h-24 opacity-90 drop-shadow-md text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 7.5h1.5m-1.5 3h1.5m-7.5-3h1.5m-1.5 3h1.5m-3-6h16.5a1.5 1.5 0 011.5 1.5v18a1.5 1.5 0 01-1.5 1.5H3.75A1.5 1.5 0 012.25 21V3.364a1.5 1.5 0 011.5-1.5z" />
                        </svg>
                    </div>
                    <div class="space-y-2 text-left">
                        <h3 class="text-lg font-black font-heading text-white">Peralatan Kost</h3>
                        <p class="text-[10px] text-white/80 leading-normal font-light">Perabot, kipas, kasur, & kebutuhan kost</p>
                        <div class="w-full bg-white/20 hover:bg-white/35 text-white font-bold py-2 rounded-xl text-center text-[10px] mt-2 transition duration-200">Jelajahi Kategori</div>
                    </div>
                </a>

                <!-- Card 4: Fashion -->
                <a href="{{ route('products.index') }}?category=Apparel" class="slider-card shrink-0 w-60 h-96 rounded-3xl p-6 flex flex-col justify-between text-white relative transition-all duration-350 shadow-lg cursor-pointer bg-gradient-to-br from-[#D4A017] via-[#7A4A10] to-[#2E1A06]" data-index="3">
                    <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm rounded-full p-2.5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </div>
                    <div class="mt-8 flex justify-center items-center flex-grow">
                        <svg class="w-24 h-24 opacity-90 drop-shadow-md text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </div>
                    <div class="space-y-2 text-left">
                        <h3 class="text-lg font-black font-heading text-white">Fashion</h3>
                        <p class="text-[10px] text-white/80 leading-normal font-light">Pakaian, kaos, jaket, sepatu, & tas Unsoed</p>
                        <div class="w-full bg-white/20 hover:bg-white/35 text-white font-bold py-2 rounded-xl text-center text-[10px] mt-2 transition duration-200">Jelajahi Kategori</div>
                    </div>
                </a>
            </div>

            <!-- Navigation Buttons -->
            <button type="button" onclick="prevSlide(event)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/85 text-[#7A4A10] p-3 rounded-full shadow-lg border border-[#D4A017]/20 hover:bg-white transition z-30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path>
                </svg>
            </button>
            <button type="button" onclick="nextSlide(event)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/85 text-[#7A4A10] p-3 rounded-full shadow-lg border border-[#D4A017]/20 hover:bg-white transition z-30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path>
                </svg>
            </button>
        </div>
        <!-- Divider line right below slider -->
        <div class="border-b border-[#D4A017]/20 w-full pt-4"></div>
    </div>
</section>

<!-- Cara Kerja Preloved.in Section -->
<section id="cara-kerja" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-[#D4A017]/10 scroll-mt-24">
    <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
        <h2 class="text-2xl font-black text-[#2E1A06] font-heading">Cara Kerja Preloved.in</h2>
        <p class="text-xs text-[#7A4A10]">Belanja hemat, jual cepat, dan bertransaksi aman bersama komunitas kampus terverifikasi</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Step 1 -->
        <div class="bg-[#F5E4B0]/50 border border-[#D4A017]/30 rounded-3xl p-8 flex flex-col items-center text-center space-y-4 shadow-sm card-premium">
            <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6 text-[#7A4A10]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                </svg>
            </div>
            <h3 class="text-lg font-black font-heading text-[#2E1A06]">Verifikasi Kampus</h3>
            <p class="text-xs text-[#2E1A06]/75 leading-relaxed font-light">Daftar pakai email kampus (.ac.id) untuk memastikan hanya mahasiswa aktif yang bisa bergabung</p>
        </div>

        <!-- Step 2 -->
        <div class="bg-[#F5E4B0]/50 border border-[#D4A017]/30 rounded-3xl p-8 flex flex-col items-center text-center space-y-4 shadow-sm card-premium">
            <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6 text-[#7A4A10]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v5.518z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-black font-heading text-[#2E1A06]">Hubungi Penjual</h3>
            <p class="text-xs text-[#2E1A06]/75 leading-relaxed font-light">Tanya langsung, nego harga, dan atur tempat ketemu lewat fitur chat bawaan kami</p>
        </div>

        <!-- Step 3 -->
        <div class="bg-[#F5E4B0]/50 border border-[#D4A017]/30 rounded-3xl p-8 flex flex-col items-center text-center space-y-4 shadow-sm card-premium">
            <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6 text-[#7A4A10]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 8.5h19m-19 4h19m-19 4h19M4.5 4.5h15a2 2 0 012 2v11a2 2 0 01-2 2h-15a2 2 0 01-2-2v-11a2 2 0 012-2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-black font-heading text-[#2E1A06]">Transaksi Aman</h3>
            <p class="text-xs text-[#2E1A06]/75 leading-relaxed font-light">Bayar saat ketemu langsung di area kampus, atau gunakan sistem escrow kami untuk transaksi jarak jauh</p>
        </div>
    </div>
</section>

<!-- Filter Kategori & Grid Produk -->
<section id="catalog-section" class="hidden max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 py-16 scroll-mt-24">
    <div id="catalog-header" class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 pb-4 border-b border-[#D4A017]/20">
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

    <!-- Product Grid: 2 columns on mobile, 3 on tablet, 5 on desktop (2 rows x 5 cols) -->
    <div id="product-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 sm:gap-8">
        <!-- Products will be dynamically populated here via Javascript (combining DB, Mocks, and LocalStorage) -->
    </div>

    <!-- Empty State -->
    <div id="empty-state" class="hidden py-16 text-center">
        <div class="w-16 h-16 bg-[#F5E4B0] rounded-full flex items-center justify-center mx-auto mb-4 text-[#7A4A10] text-2xl">🔍</div>
        <h3 class="text-base font-bold text-[#2E1A06]">Barang tidak ditemukan</h3>
        <p class="text-xs text-[#7A4A10] mt-1">Coba cari kata kunci lain atau ubah kategori filter Anda.</p>
    </div>

    <!-- Lihat Lebih Banyak Button -->
    <div class="flex justify-center mt-10">
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center px-8 py-3 bg-white border-2 border-[#7A4A10] text-[#7A4A10] font-bold text-sm rounded-full hover:bg-[#7A4A10] hover:text-[#FBF6EC] transition-all duration-300 shadow-sm hover:shadow-md">
            Lihat Lebih Banyak
        </a>
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
                <a href="{{ route('login') }}?redirect={{ urlencode(route('products.create')) }}" class="px-6 py-3 bg-[#D4A017] hover:bg-[#b88910] text-[#2E1A06] font-bold text-xs rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                    ➕ Mulai Jual Sekarang
                </a>
                <a href="#cara-kerja" id="banner-btn-cara-kerja" class="px-6 py-3 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-bold text-xs rounded-xl border border-[#D4A017]/30 transition">
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

    // Slider State & Logic
    let activeIndex = 0;
    let cards = [];
    let autoPlayInterval = null;
    const autoplayDelay = 3500; // 3.5 seconds

    function startAutoPlay() {
        stopAutoPlay();
        autoPlayInterval = setInterval(() => {
            nextSlide();
        }, autoplayDelay);
    }

    function stopAutoPlay() {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
            autoPlayInterval = null;
        }
    }

    function updateSlider() {
        const track = document.getElementById('category-slider-track');
        if (!track) return;
        if (cards.length === 0) {
            cards = document.querySelectorAll('.slider-card');
        }
        if (cards.length === 0) return;

        const trackWidth = track.offsetWidth;
        if (trackWidth === 0) return;

        const activeCard = cards[activeIndex];
        const cardWidth = activeCard.offsetWidth || 240;
        const currentGap = window.innerWidth >= 768 ? 40 : 24;

        const cardCenterRelativeToTrackStart = activeIndex * (cardWidth + currentGap) + (cardWidth / 2);
        const trackCenter = trackWidth / 2;
        const offset = trackCenter - cardCenterRelativeToTrackStart;

        track.style.transform = `translateX(${offset}px)`;

        cards.forEach((card, idx) => {
            if (idx === activeIndex) {
                card.style.transform = 'scale(1.12) translateZ(0)';
                card.style.opacity = '1';
                card.style.zIndex = '20';
                card.classList.add('shadow-2xl');
                card.classList.remove('opacity-50', 'scale-90');
            } else {
                card.style.transform = 'scale(0.88) translateZ(0)';
                card.style.opacity = '0.5';
                card.style.zIndex = '10';
                card.classList.add('opacity-50', 'scale-90');
                card.classList.remove('shadow-2xl');
            }
        });
    }

    function nextSlide(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
            startAutoPlay(); // Reset timer on manual click
        }
        if (cards.length === 0) cards = document.querySelectorAll('.slider-card');
        if (cards.length === 0) return;
        activeIndex = (activeIndex + 1) % cards.length;
        updateSlider();
    }

    function prevSlide(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
            startAutoPlay(); // Reset timer on manual click
        }
        if (cards.length === 0) cards = document.querySelectorAll('.slider-card');
        if (cards.length === 0) return;
        activeIndex = (activeIndex - 1 + cards.length) % cards.length;
        updateSlider();
    }

    // Expose functions globally for HTML inline onclick
    window.nextSlide = nextSlide;
    window.prevSlide = prevSlide;
    window.updateSlider = updateSlider;
    window.startAutoPlay = startAutoPlay;
    window.stopAutoPlay = stopAutoPlay;

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

        allProducts = allProducts.slice(0, 10);

        allProducts.forEach(p => {
            const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(p.price);
            
            let badgeClass = 'bg-gray-100 text-gray-600 border-gray-300';
            if(p.condition === 'New')       badgeClass = 'bg-blue-100 text-blue-700 border-blue-300';
            else if(p.condition === 'Like New')  badgeClass = 'bg-green-100 text-green-700 border-green-300';
            else if(p.condition === 'Good')      badgeClass = 'bg-amber-100 text-amber-700 border-amber-300';
            else if(p.condition === 'Well Used') badgeClass = 'bg-gray-100 text-gray-500 border-gray-300';

            const imageUrl = p.image_urls && p.image_urls.length > 0 ? p.image_urls[0] : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';
            const rating = p.seller && p.seller.rating_cache ? p.seller.rating_cache : '4.8';
            const sellerName = p.seller ? p.seller.name : 'Mahasiswa Unsoed';
            const isVerified = p.seller && p.seller.is_verified ? '<span class="text-[8px] bg-[#7A4A10] text-[#FBF6EC] px-1 rounded-full ml-1">✓</span>' : '';

            const card = document.createElement('div');
            card.className = "bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow duration-200 relative group";
            
            const detailUrl = `/products/${p.id}`;

            card.innerHTML = `
                <span class="absolute top-2.5 left-2.5 z-10 px-2 py-0.5 border rounded-full text-[8px] font-bold uppercase tracking-wide shadow-sm ${badgeClass}">
                    ${p.condition}
                </span>

                <a href="${detailUrl}" class="block aspect-[4/3] w-full bg-gray-50 overflow-hidden relative">
                    <img src="${imageUrl}" alt="${p.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                </a>

                <div class="p-3 flex flex-col gap-1.5">
                    <!-- Baris 1: Nama penjual + Rating -->
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] text-gray-400 font-medium truncate">${sellerName}</span>
                        <span class="text-[10px] text-[#D4A017] font-bold shrink-0 ml-1">☆ ${rating}</span>
                    </div>

                    <!-- Baris 2: Nama produk -->
                    <h4 class="font-bold text-[#2E1A06] text-xs leading-snug line-clamp-2 hover:text-[#7A4A10] transition">
                        <a href="${detailUrl}">${p.title}</a>
                    </h4>

                    <!-- Baris 3: Harga + Keranjang -->
                    <div class="flex items-center justify-between mt-0.5">
                        <span class="text-sm font-bold text-[#E8400C]">${formattedPrice}</span>
                        <button onclick="quickAddCart(event, ${JSON.stringify(p).replace(/"/g, '&quot;')})"
                                class="p-1.5 bg-[#FBF6EC] border border-[#D4A017]/40 text-[#D4A017] hover:bg-[#D4A017] hover:text-white rounded-lg transition-all duration-200 flex items-center justify-center shrink-0">
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
        // Toggle Hero content based on auth state
        const userJson = localStorage.getItem('preloved_user');
        if (userJson) {
            try {
                const user = JSON.parse(userJson);
                if (user && user.name) {
                    const firstName = user.name.trim().split(' ')[0];
                    const heroGuest = document.getElementById('hero-guest-content');
                    const heroUser = document.getElementById('hero-user-content');
                    const heroUserName = document.getElementById('hero-user-name');
                    
                    if (heroGuest && heroUser && heroUserName) {
                        heroGuest.classList.add('hidden');
                        heroUser.classList.remove('hidden');
                        heroUserName.textContent = firstName;
                    }

                    // Tampilkan katalog hanya jika user sudah login
                    const catalogSec = document.getElementById('catalog-section');
                    if (catalogSec) {
                        catalogSec.classList.remove('hidden');
                        // Kurangi top spacing katalog agar nempel ke border-b slider
                        catalogSec.classList.remove('py-16');
                        catalogSec.classList.add('pt-4', 'pb-16');
                    }

                    // Tampilkan kategori view user jika login
                    const categoryGuestView = document.getElementById('category-guest-view');
                    const categoryUserView = document.getElementById('category-user-view');
                    if (categoryGuestView && categoryUserView) {
                        categoryGuestView.classList.add('hidden');
                        categoryUserView.classList.remove('hidden');
                    }

                    // Sembunyikan Cara Kerja section dan button jika login
                    const caraKerjaSec = document.getElementById('cara-kerja');
                    if (caraKerjaSec) {
                        caraKerjaSec.classList.add('hidden');
                    }
                    const bannerBtnCaraKerja = document.getElementById('banner-btn-cara-kerja');
                    if (bannerBtnCaraKerja) {
                        bannerBtnCaraKerja.classList.add('hidden');
                    }

                    // Sembunyikan catalog header jika login
                    const catalogHeader = document.getElementById('catalog-header');
                    if (catalogHeader) {
                        catalogHeader.classList.add('hidden');
                    }
                }
            } catch (e) {
                console.error('Error parsing user data:', e);
            }
        }

        renderProducts();

        // Setup slider click handlers
        cards = document.querySelectorAll('.slider-card');
        cards.forEach((card, idx) => {
            card.addEventListener('click', (e) => {
                if (idx !== activeIndex) {
                    e.preventDefault();
                    activeIndex = idx;
                    updateSlider();
                    startAutoPlay(); // Reset timer on manual selection
                }
            });
        });

        // Initialize/update slider if logged in
        if (userJson) {
            setTimeout(() => {
                updateSlider();
                startAutoPlay();
            }, 50);
        }

        // Pause autoplay on track hover
        const sliderTrack = document.getElementById('category-slider-track');
        if (sliderTrack) {
            sliderTrack.addEventListener('mouseenter', stopAutoPlay);
            sliderTrack.addEventListener('mouseleave', startAutoPlay);
        }

        // Window resize handler
        window.addEventListener('resize', () => {
            if (localStorage.getItem('preloved_user')) {
                updateSlider();
            }
        });
        
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