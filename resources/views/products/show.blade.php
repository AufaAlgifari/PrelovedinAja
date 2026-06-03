@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back to Catalog Link -->
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-brand-600 transition">
            ← Kembali ke Katalog Kampus
        </a>
    </div>

    <!-- Product Card Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 bg-white p-6 sm:p-10 rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/30">
        
        <!-- Left Side: Product Images Gallery -->
        <div class="lg:col-span-5 space-y-4">
            <div class="aspect-square bg-slate-50 rounded-2xl overflow-hidden flex items-center justify-center border border-slate-100 relative group">
                <img id="main-image" src="{{ $product->image_urls[0] ?? 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
            </div>
            
            @if(isset($product->image_urls) && count($product->image_urls) > 1)
            <div class="grid grid-cols-4 gap-2">
                @foreach($product->image_urls as $img)
                <button onclick="document.getElementById('main-image').src = '{{ $img }}'" class="aspect-square rounded-xl bg-slate-50 border border-slate-100 overflow-hidden hover:border-brand-500 focus:outline-none transition">
                    <img src="{{ $img }}" alt="Thumbnail" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Right Side: Details and Pricing -->
        <div class="lg:col-span-7 flex flex-col justify-between">
            <div>
                <!-- Condition and Category Badge -->
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="inline-block px-3 py-1.5 bg-brand-50 border border-brand-100 text-brand-700 text-[10px] font-extrabold uppercase tracking-wider rounded-full">
                        📂 {{ $product->category }}
                    </span>
                    
                    @php
                        $badgeClass = 'bg-slate-50 text-slate-700 border-slate-200';
                        if($product->condition === 'New') $badgeClass = 'bg-purple-50 text-purple-700 border-purple-100';
                        else if($product->condition === 'Like New') $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                        else if($product->condition === 'Good') $badgeClass = 'bg-brand-50 text-brand-800 border-brand-200';
                        else if($product->condition === 'Well Used') $badgeClass = 'bg-amber-50 text-amber-700 border-amber-100';
                    @endphp
                    
                    <span class="inline-block px-3 py-1.5 border {{ $badgeClass }} text-[10px] font-extrabold uppercase tracking-wider rounded-full">
                        ✨ Kondisi: {{ $product->condition }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 leading-snug mb-3">{{ $product->title }}</h1>
                
                <div class="flex items-baseline gap-2 mb-6">
                    <span class="text-3xl font-black text-brand-500">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="text-xs font-bold text-slate-400 uppercase">Harga Pas</span>
                </div>

                <!-- Seller Profile Area -->
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-8 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <img src="{{ $product->seller->avatar_url ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80' }}" alt="Avatar Seller" class="w-12 h-12 rounded-full object-cover border border-slate-200">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Penjual Mahasiswa</p>
                            <p class="text-sm font-extrabold text-slate-800">{{ $product->seller->name ?? 'Mahasiswa Unsoed' }}</p>
                            <p class="text-xs text-slate-500">{{ $product->seller->unsoed_faculty ?? 'Fakultas' }} • {{ $product->seller->unsoed_major ?? 'UNSOED' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-brand-600 font-bold text-sm">⭐ {{ $product->seller->rating_cache ?? '4.8' }}</span>
                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Rating Penjual</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi Produk</h3>
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line bg-slate-50/50 p-4 rounded-2xl border border-slate-100/50">
                        {{ $product->description }}
                    </p>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <button onclick="addProductToCart()" class="w-full bg-white border-2 border-brand-500 text-brand-600 hover:bg-brand-50 py-4 rounded-2xl font-bold text-xs uppercase tracking-wider shadow-sm transition transform hover:-translate-y-0.5">
                    🛒 Tambah Ke Keranjang
                </button>
                <button onclick="openChatModal()" class="w-full text-slate-900 btn-gradient py-4 rounded-2xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-brand-500/20 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    💬 Chat Penjual (COD Kampus)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Chat Contact Modal -->
<div id="chat-modal" class="hidden fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div class="bg-white rounded-3xl border border-slate-100 max-w-md w-full p-6 shadow-2xl relative overflow-hidden transform scale-95 transition-all">
        <div class="text-center space-y-4">
            <div class="inline-flex items-center justify-center p-3 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Hubungi Penjual (COD Kampus)</h3>
            <p class="text-xs text-slate-500">Anda dapat menghubungi penjual langsung melalui nomor WhatsApp resmi mahasiswa berikut untuk membuat janji temu COD.</p>
            
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100/80 text-left space-y-2">
                <div class="text-xs"><strong class="text-slate-700">Nama Penjual:</strong> {{ $product->seller->name ?? 'Mahasiswa Unsoed' }}</div>
                <div class="text-xs"><strong class="text-slate-700">Fakultas:</strong> {{ $product->seller->unsoed_faculty ?? 'Fakultas' }}</div>
                <div class="text-xs"><strong class="text-slate-700">Nomor WA/Kontak:</strong> <span class="font-bold text-emerald-600">{{ $product->seller->phone_number ?? '0812-3456-7890' }}</span></div>
            </div>

            <div class="pt-4 flex gap-3">
                <button onclick="closeChatModal()" class="w-1/2 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                    Tutup
                </button>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->seller->phone_number ?? '6281234567890') }}?text=Halo%20{{ urlencode($product->seller->name ?? 'Penjual') }},%20saya%20tertarik%20dengan%20barang%20preloved%20Anda:%20{{ urlencode($product->title) }}." target="_blank" class="w-1/2 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-md shadow-emerald-600/10 flex items-center justify-center gap-1.5">
                    📱 Buka WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Sourced product details
    const currentProduct = {
        id: "{{ $product->id }}",
        title: "{{ $product->title }}",
        price: parseInt("{{ $product->price }}"),
        image_urls: ["{{ $product->image_urls[0] ?? 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80' }}"],
        seller_name: "{{ $product->seller->name ?? 'Mahasiswa Unsoed' }}"
    };

    function addProductToCart() {
        window.addToCart(currentProduct);
    }

    function openChatModal() {
        const modal = document.getElementById('chat-modal');
        modal.classList.remove('hidden');
    }

    function closeChatModal() {
        const modal = document.getElementById('chat-modal');
        modal.classList.add('hidden');
    }
</script>
@endsection