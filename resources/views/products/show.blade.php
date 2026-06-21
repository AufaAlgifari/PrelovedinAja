@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back to Catalog Link -->
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#7A4A10] hover:text-[#2E1A06] transition">
            ← Kembali ke Katalog Kampus
        </a>
        
        <!-- Report Button (ERD Compliance) -->
        <button onclick="openReportModal()" class="inline-flex items-center gap-1 text-xs font-bold text-rose-700 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-full border border-rose-200 transition">
            ⚠️ Laporkan Barang
        </button>
    </div>

    <!-- Product Card Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 bg-[#F5E4B0] p-6 sm:p-10 rounded-3xl border border-[#D4A017]/25 shadow-xl">
        
        <!-- Left Side: Product Images Gallery -->
        <div class="lg:col-span-5 space-y-4">
            <div class="aspect-square bg-[#FBF6EC] rounded-2xl overflow-hidden flex items-center justify-center border border-[#D4A017]/20 relative group">
                <img id="main-image" src="{{ $product->image_urls[0] ?? 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
            </div>
            
            @if(isset($product->image_urls) && count($product->image_urls) > 1)
            <div class="grid grid-cols-4 gap-2">
                @foreach($product->image_urls as $index => $img)
                <button onclick="changeMainImage(this, '{{ $img }}')" class="thumbnail-btn aspect-square rounded-xl bg-[#FBF6EC] border {{ $index === 0 ? 'border-[#7A4A10] border-2 shadow-sm' : 'border-[#D4A017]/20' }} overflow-hidden hover:border-[#7A4A10] focus:outline-none transition">
                    <img src="{{ $img }}" alt="Thumbnail" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Right Side: Details and Pricing -->
        <div class="lg:col-span-7 flex flex-col justify-between text-[#2E1A06]">
            <div>
                <!-- Condition and Category Badge -->
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="inline-block px-3 py-1.5 bg-[#FBF6EC] border border-[#D4A017]/35 text-[#7A4A10] text-[10px] font-extrabold uppercase tracking-wider rounded-full">
                        📂 {{ $product->category }}
                    </span>
                    
                    @php
                        $badgeClass = 'bg-[#FBF6EC] text-[#2E1A06] border-[#D4A017]/35';
                        if($product->condition === 'New') $badgeClass = 'bg-[#7A4A10] text-[#FBF6EC] border-[#7A4A10]';
                        else if($product->condition === 'Like New') $badgeClass = 'bg-[#D4A017] text-[#2E1A06] border-[#D4A017]';
                        else if($product->condition === 'Good') $badgeClass = 'bg-[#FBF6EC] text-[#7A4A10] border-[#D4A017]/30';
                        else if($product->condition === 'Well Used') $badgeClass = 'bg-transparent text-[#2E1A06] border-[#2E1A06]/30';
                    @endphp
                    
                    <span class="inline-block px-3 py-1.5 border {{ $badgeClass }} text-[10px] font-extrabold uppercase tracking-wider rounded-full">
                        ✨ Kondisi: {{ $product->condition }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-black tracking-tight leading-snug mb-3 font-heading">{{ $product->title }}</h1>
                
                <div class="flex items-baseline gap-2 mb-6">
                    <span class="text-3xl font-black text-[#7A4A10]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="text-xs font-bold text-[#7A4A10]/70 uppercase tracking-widest">Harga Pas</span>
                </div>

                <!-- Seller Profile Area -->
                <div class="bg-[#FBF6EC] rounded-2xl p-5 border border-[#D4A017]/20 mb-8 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <img src="{{ $product->seller->avatar_url ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80' }}" alt="Avatar Seller" class="w-12 h-12 rounded-full object-cover border-2 border-[#D4A017]">
                        <div>
                            <p class="text-xs font-bold text-[#7A4A10] uppercase tracking-wider">Penjual Mahasiswa</p>
                            <p class="text-sm font-extrabold text-[#2E1A06] flex items-center">
                                {{ $product->seller->name ?? 'Mahasiswa Unsoed' }}
                                @if(isset($product->seller->is_verified) && $product->seller->is_verified)
                                    <span class="ml-1.5 bg-[#7A4A10] text-[#FBF6EC] text-[8px] font-bold px-1.5 py-0.5 rounded-full">✓ Verified</span>
                                @endif
                            </p>
                            <p class="text-xs text-[#7A4A10]/80 mt-0.5">{{ $product->seller->unsoed_faculty ?? 'Fakultas' }} • {{ $product->seller->unsoed_major ?? 'UNSOED' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[#7A4A10] font-black text-sm">⭐ {{ $product->seller->rating_cache ?? '4.8' }}</span>
                        <p class="text-[10px] text-[#7A4A10] font-bold uppercase mt-1">Rating Penjual</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold text-[#7A4A10] uppercase tracking-wider">Deskripsi Produk</h3>
                    <p class="text-[#2E1A06]/85 text-sm leading-relaxed whitespace-pre-line bg-[#FBF6EC]/50 p-4 rounded-2xl border border-[#D4A017]/10">
                        {{ $product->description }}
                    </p>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="mt-10 space-y-4">
                <!-- Baris Atas: Chat Penjual (Aksi Komunikasi Terpisah) -->
                <div>
                    <a href="{{ route('chat.index', ['seller_id' => $product->seller_id, 'product_id' => $product->id]) }}" class="w-full text-[#FBF6EC] bg-[#7A4A10] hover:bg-[#5f390c] py-4 rounded-2xl font-bold text-xs uppercase tracking-wider shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-center">
                        💬 Chat Penjual
                    </a>
                </div>
                <!-- Baris Bawah: Aksi Transaksi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <button onclick="addProductToCart()" class="w-full bg-[#FBF6EC] border-2 border-[#7A4A10] text-[#7A4A10] hover:bg-[#F5E4B0] py-4 rounded-2xl font-bold text-xs uppercase tracking-wider shadow-sm transition transform hover:-translate-y-0.5">
                        🛒 Tambah Ke Keranjang
                    </button>
                    <a href="{{ route('checkout.index', $product->id) }}" class="w-full text-[#FBF6EC] bg-[#7A4A10] hover:bg-[#5f390c] py-4 rounded-2xl font-bold text-xs uppercase tracking-wider shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-center">
                        ⚡ Beli Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chat Contact & In-App Messaging Modal -->
<div id="chat-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#2E1A06]/60 backdrop-blur-sm">
    <div class="bg-[#F5E4B0] rounded-3xl border border-[#D4A017]/25 max-w-md w-full p-6 shadow-2xl relative transform scale-95 transition-all text-[#2E1A06]" style="max-height: 85vh; overflow-y: auto;">
        <div class="text-center space-y-4">
            <div class="inline-flex items-center justify-center p-3 bg-[#FBF6EC] text-[#7A4A10] rounded-full border border-[#D4A017]/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </div>
            <h3 class="text-lg font-black font-heading text-[#2E1A06]">Hubungi Penjual</h3>
            <p class="text-xs text-[#2E1A06]/85">Pilih kirim pesan instan langsung di aplikasi (In-App) atau hubungi nomor WhatsApp mahasiswa untuk membuat janji temu COD.</p>
            
            <!-- In-App Message Input -->
            <div class="bg-[#FBF6EC] p-4 rounded-2xl border border-[#D4A017]/20 text-left space-y-3">
                <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider">Kirim Pesan In-App</label>
                <textarea id="inapp-message" rows="2" placeholder="Halo, barang ini masih ada? Bisa ketemuan di depan perpustakaan?" 
                          class="w-full p-3 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-xl text-xs text-[#2E1A06] focus:border-[#7A4A10] focus:ring-2 focus:ring-[#7A4A10]/10 focus:outline-none"></textarea>
                <button onclick="sendInAppMessage()" id="btn-send-msg" class="w-full py-2 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow">
                    <span>✉ Kirim Pesan Internal</span>
                </button>
            </div>

            <!-- WhatsApp Secondary Option -->
            <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-200 text-left flex items-center justify-between text-xs">
                <div>
                    <span class="block text-[9px] font-bold text-emerald-800 uppercase">Kontak Alternatif WA</span>
                    <strong class="text-emerald-900">{{ $product->seller->phone_number ?? '0812-3456-7890' }}</strong>
                </div>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->seller->phone_number ?? '6281234567890') }}?text=Halo%20{{ urlencode($product->seller->name ?? 'Penjual') }},%20saya%20tertarik%20dengan%20barang%20preloved%20Anda:%20{{ urlencode($product->title) }}." target="_blank" 
                   class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] uppercase rounded-xl transition shadow">
                    Buka WhatsApp
                </a>
            </div>

            <div class="pt-2">
                <button onclick="closeChatModal()" class="w-full py-3 bg-[#FBF6EC] hover:bg-[#F5E4B0] text-[#7A4A10] text-xs font-bold rounded-xl border border-[#D4A017]/30 transition">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Report Product Modal (ERD Compliance) -->
<div id="report-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#2E1A06]/60 backdrop-blur-sm">
    <div class="bg-[#F5E4B0] rounded-3xl border border-[#D4A017]/25 max-w-md w-full p-6 shadow-2xl relative text-[#2E1A06]" style="max-height: 85vh; overflow-y: auto;">
        <div class="text-center space-y-4">
            <div class="inline-flex items-center justify-center p-3 bg-rose-50 text-rose-700 rounded-full border border-rose-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-lg font-black font-heading text-rose-800">Laporkan Barang Bermasalah</h3>
            <p class="text-xs text-[#2E1A06]/85">Bantu kami menjaga keamanan kampus. Laporkan barang jika terindikasi penipuan, barang palsu, atau konten melanggar.</p>
            
            <form id="report-form" class="space-y-4 text-left" onsubmit="submitReport(event)">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">Kategori Pelanggaran</label>
                    <select id="report-category" required class="w-full p-3 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-xl text-xs text-[#2E1A06] focus:border-[#7A4A10] focus:outline-none">
                        <option value="Scam">Penipuan / Scam</option>
                        <option value="Fake">Barang Tiruan / Palsu</option>
                        <option value="Inappropriate">Konten Tidak Pantas / Melanggar</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">Alasan Pelaporan</label>
                    <textarea id="report-reason" required rows="3" placeholder="Sebutkan bukti atau alasan rasional mengapa produk ini perlu diturunkan admin..." 
                              class="w-full p-3 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-xl text-xs text-[#2E1A06] focus:border-[#7A4A10] focus:outline-none"></textarea>
                </div>
                
                <div class="pt-2 flex gap-3">
                    <button type="button" onclick="closeReportModal()" class="w-1/2 py-3 bg-[#FBF6EC] hover:bg-[#F5E4B0] text-[#7A4A10] text-xs font-bold rounded-xl border border-[#D4A017]/30 transition">
                        Batal
                    </button>
                    <button type="submit" class="w-1/2 py-3 bg-rose-700 hover:bg-rose-800 text-white text-xs font-bold rounded-xl transition shadow">
                        Kirim Laporan
                    </button>
                </div>
            </form>
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

    const sellerId = "{{ $product->seller->id ?? '' }}";

    function addProductToCart() {
        window.addToCart(currentProduct);
    }

    function changeMainImage(btn, imgUrl) {
        document.getElementById('main-image').src = imgUrl;
        document.querySelectorAll('.thumbnail-btn').forEach(t => {
            t.classList.remove('border-[#7A4A10]', 'border-2', 'shadow-sm');
            t.classList.add('border-[#D4A017]/20');
        });
        btn.classList.remove('border-[#D4A017]/20');
        btn.classList.add('border-[#7A4A10]', 'border-2', 'shadow-sm');
    }

    function openChatModal() {
        const user = localStorage.getItem('preloved_user');
        if(!user) {
            window.showToast('Silakan masuk terlebih dahulu untuk memulai obrolan.', 'error');
            return;
        }
        document.getElementById('chat-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeChatModal() {
        document.getElementById('chat-modal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    async function sendInAppMessage() {
        const msgText = document.getElementById('inapp-message').value.trim();
        const token = localStorage.getItem('preloved_token');
        
        if(!msgText) {
            window.showToast('Pesan tidak boleh kosong.', 'error');
            return;
        }

        const btn = document.getElementById('btn-send-msg');
        btn.disabled = true;
        btn.innerHTML = 'Mengirim...';

        try {
            const response = await fetch('/api/v1/chats', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    receiver_id: parseInt(sellerId),
                    product_id: parseInt(currentProduct.id),
                    message: msgText
                })
            });

            if (response.ok) {
                window.showToast('Pesan terkirim secara in-app!');
                document.getElementById('inapp-message').value = '';
                closeChatModal();
            } else {
                window.showToast('Gagal mengirim pesan internal.', 'error');
            }
        } catch (error) {
            console.log('Chat API offline, simulating chat store.');
            window.showToast('Pesan terkirim (Simulasi Offline)!');
            closeChatModal();
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span>✉ Kirim Pesan Internal</span>';
        }
    }

    function openReportModal() {
        const user = localStorage.getItem('preloved_user');
        if(!user) {
            window.showToast('Silakan masuk terlebih dahulu untuk melaporkan produk.', 'error');
            return;
        }
        document.getElementById('report-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeReportModal() {
        document.getElementById('report-modal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    async function submitReport(e) {
        e.preventDefault();
        const reason = document.getElementById('report-reason').value.trim();
        const category = document.getElementById('report-category').value;
        const token = localStorage.getItem('preloved_token');

        try {
            const response = await fetch('/api/v1/reports', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    reported_product_id: parseInt(currentProduct.id),
                    reported_user_id: parseInt(sellerId),
                    reason: reason,
                    category: category
                })
            });

            if (response.ok) {
                window.showToast('Laporan berhasil dikirim. Admin akan segera meninjau.');
                closeReportModal();
            } else {
                window.showToast('Gagal mengirim laporan.', 'error');
            }
        } catch (error) {
            window.showToast('Laporan berhasil terkirim (Simulasi Offline)!');
            closeReportModal();
        }
    }
</script>
@endsection