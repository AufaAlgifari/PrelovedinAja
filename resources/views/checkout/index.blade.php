@extends('layouts.app')

@section('head')
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back to Cart Link -->
    <div class="mb-6">
        <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#7A4A10] hover:text-[#2E1A06] transition">
            Kembali ke Keranjang
        </a>
    </div>

    <div class="mb-10">
        <h1 class="text-3xl font-extrabold tracking-tight font-heading text-[#2E1A06]">Checkout Barang Preloved</h1>
        <p class="text-xs text-[#7A4A10] mt-2 font-medium">Lengkapi detail pengiriman dan pembayaran di bawah ini.</p>
    </div>

    <!-- Tampilkan Error Jika Ada -->
    @if ($errors->any())
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl text-xs font-medium">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="checkout-form" onsubmit="handleCheckoutSubmit(event)" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        @csrf

        <!-- KOLOM KIRI: STICKY -->
        <div class="lg:col-span-5 sticky top-24 space-y-6">
            <!-- 1. Detail Produk & Penjual -->
            <section class="bg-white p-6 sm:p-8 rounded-3xl border-4 border-[#7A4A10] shadow-md space-y-6">
                <h2 class="text-md font-bold font-heading text-[#2E1A06] border-b border-gray-100 pb-3">Ringkasan Pesanan</h2>
                <div class="flex flex-col gap-6">
                    <img src="{{ $product->image_urls[0] ?? 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->title }}" class="w-full aspect-square rounded-2xl object-cover bg-gray-50 border border-gray-100">
                    <div class="space-y-2">
                        <h3 class="text-lg font-black text-[#2E1A06] leading-tight">{{ $product->title }}</h3>
                        <p class="text-3xl font-black text-[#EE4D2D]">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#7A4A10] flex items-center justify-center text-[#FBF6EC] font-bold text-sm uppercase shadow-sm">
                                    {{ substr($product->seller->name ?? 'M', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider">Penjual</p>
                                    <p class="text-xs font-bold text-[#2E1A06]">{{ $product->seller->name ?? 'Mahasiswa Unsoed' }}</p>
                                    <p class="text-[10px] text-[#7A4A10] mt-0.5">{{ $product->seller->unsoed_faculty ?? 'Fakultas' }} - {{ $product->seller->unsoed_major ?? 'Jurusan' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- KOLOM KANAN: FORM SCROLLABLE -->
        <div class="lg:col-span-7 space-y-6">
            <!-- 2. Detail Pembeli -->
            <section class="bg-[#F5E4B0] p-6 sm:p-8 rounded-3xl border border-[#D4A017]/25 shadow-sm space-y-5">
                <h2 class="text-md font-bold font-heading text-[#2E1A06] border-b border-[#D4A017]/20 pb-3">Informasi Pembeli</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-2">Nama Pembeli</label>
                        <div id="buyer-name-display" class="px-5 py-4 bg-white/60 rounded-xl border border-[#D4A017]/10 text-xs text-[#2E1A06] font-medium opacity-80 cursor-not-allowed">
                            Memuat...
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-2">Fakultas & Jurusan</label>
                        <div id="buyer-faculty-display" class="px-5 py-4 bg-white/60 rounded-xl border border-[#D4A017]/10 text-xs text-[#2E1A06] font-medium opacity-80 cursor-not-allowed">
                            Memuat...
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. Metode Pengiriman & Chat Penjual -->
            <section class="bg-[#F5E4B0] p-6 sm:p-8 rounded-3xl border border-[#D4A017]/25 shadow-sm space-y-5">
                <h2 class="text-md font-bold font-heading text-[#2E1A06] border-b border-[#D4A017]/20 pb-3">Metode Pengiriman</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- COD Option -->
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pengiriman" value="cod" class="peer sr-only" required onchange="toggleAddress(false)">
                        <div class="p-5 rounded-xl border-2 border-[#D4A017]/20 bg-white peer-checked:border-[#7A4A10] peer-checked:bg-[#FBF6EC] hover:bg-white/80 transition flex flex-col gap-1.5 h-full">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-sm text-[#2E1A06]">COD (Ketemuan)</span>
                                <span class="text-xs font-black text-[#7A4A10]">Gratis</span>
                            </div>
                            <span class="text-[10px] text-[#7A4A10] leading-relaxed">Pembeli datang ke lokasi kampus.</span>
                        </div>
                    </label>
                    <!-- DO Option -->
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pengiriman" value="do" class="peer sr-only" required onchange="toggleAddress(true)">
                        <div class="p-5 rounded-xl border-2 border-[#D4A017]/20 bg-white peer-checked:border-[#7A4A10] peer-checked:bg-[#FBF6EC] hover:bg-white/80 transition flex flex-col gap-1.5 h-full">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-sm text-[#2E1A06]">Delivery Order</span>
                                <span class="text-[10px] font-bold text-[#7A4A10] bg-[#D4A017]/20 px-2 py-0.5 rounded-full">+ Biaya Antar</span>
                            </div>
                            <span class="text-[10px] text-[#7A4A10] leading-relaxed">Penjual mengantar barang ke kos/rumah.</span>
                        </div>
                    </label>
                </div>
                
                <!-- Address Input (Hidden by default) -->
                <div id="address-container" class="hidden mt-4 pt-4 border-t border-[#D4A017]/10 transition-all duration-300">
                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-2">Alamat Pengiriman (Wajib untuk DO)</label>
                    <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="3" placeholder="Masukkan alamat kos/rumah lengkap beserta patokan..." class="w-full p-4 bg-white border border-[#D4A017]/30 rounded-xl text-xs text-[#2E1A06] focus:border-[#7A4A10] focus:ring-2 focus:ring-[#7A4A10]/10 focus:outline-none"></textarea>
                </div>
                
                <!-- Chat Hint for Coordination -->
                <div class="mt-4 pt-5 border-t border-[#D4A017]/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-[11px] font-bold text-[#7A4A10] italic">Hubungi penjual untuk koordinasi pengiriman atau lokasi COD</p>
                    <a href="{{ route('chat.index') }}?contact_id={{ $product->seller_id }}&contact_name={{ urlencode($product->seller->name ?? 'Penjual') }}&product_title={{ urlencode($product->title) }}&product_id={{ $product->id }}&return_to=checkout&checkout_product_id={{ $product->id }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] text-[10px] font-bold uppercase tracking-wider rounded-xl transition transform hover:-translate-y-0.5 shadow-md w-full sm:w-auto">
                        Chat Penjual
                    </a>
                </div>
            </section>

            <!-- 4. Metode Pembayaran -->
            <section class="bg-[#F5E4B0] p-6 sm:p-8 rounded-3xl border border-[#D4A017]/25 shadow-sm space-y-5">
                <h2 class="text-md font-bold font-heading text-[#2E1A06] border-b border-[#D4A017]/20 pb-3">Metode Pembayaran</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <!-- QRIS -->
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="qris" class="peer sr-only" required>
                        <div class="p-4 rounded-xl border-2 border-[#D4A017]/20 bg-white peer-checked:border-[#7A4A10] peer-checked:bg-[#FBF6EC] hover:bg-white/80 transition flex items-center justify-center h-16 shadow-sm">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="h-6 object-contain">
                        </div>
                    </label>
                    <!-- DANA -->
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="dana" class="peer sr-only" required>
                        <div class="p-4 rounded-xl border-2 border-[#D4A017]/20 bg-white peer-checked:border-[#7A4A10] peer-checked:bg-[#FBF6EC] hover:bg-white/80 transition flex items-center justify-center h-16 shadow-sm">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" alt="DANA" class="h-5 object-contain">
                        </div>
                    </label>
                    <!-- GoPay -->
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="gopay" class="peer sr-only" required>
                        <div class="p-4 rounded-xl border-2 border-[#D4A017]/20 bg-white peer-checked:border-[#7A4A10] peer-checked:bg-[#FBF6EC] hover:bg-white/80 transition flex items-center justify-center h-16 shadow-sm">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="GoPay" class="h-5 object-contain">
                        </div>
                    </label>
                    <!-- ShopeePay -->
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="shopeepay" class="peer sr-only" required>
                        <div class="p-4 rounded-xl border-2 border-[#D4A017]/20 bg-white peer-checked:border-[#7A4A10] peer-checked:bg-[#FBF6EC] hover:bg-white/80 transition flex items-center justify-center h-16 shadow-sm">
                            <div class="flex items-center gap-1">
                                <div class="w-6 h-5 bg-[#EE4D2D] rounded flex items-center justify-center text-white font-bold text-xs relative">
                                    <span class="absolute top-0.5 left-1 w-3 h-0.5 bg-white/40 rounded-full"></span>
                                    S
                                </div>
                                <span class="text-[#EE4D2D] font-bold text-[13px] tracking-tight">ShopeePay</span>
                            </div>
                        </div>
                    </label>
                </div>
            </section>

            <input type="hidden" name="buyer_id" id="buyer_id_input" value="">

            <!-- 5. Konfirmasi -->
            <button type="submit" class="w-full text-[#FBF6EC] bg-[#7A4A10] hover:bg-[#5f390c] py-5 rounded-2xl font-black text-sm uppercase tracking-wider shadow-xl transition transform hover:-translate-y-1 text-center flex items-center justify-center gap-2">
                Konfirmasi Pembelian
            </button>
        </div>
    </form>
</div>

<script>
    function toggleAddress(show) {
        const container = document.getElementById('address-container');
        const input = document.getElementById('alamat_pengiriman');
        if (show) {
            container.classList.remove('hidden');
            input.setAttribute('required', 'required');
        } else {
            container.classList.add('hidden');
            input.removeAttribute('required');
        }
    }

    // Populate data pembeli dari localStorage
    window.addEventListener('DOMContentLoaded', () => {
        const userStr = localStorage.getItem('preloved_user');
        if (userStr) {
            try {
                const user = JSON.parse(userStr);
                document.getElementById('buyer-name-display').textContent = user.name || 'Mahasiswa Unsoed';
                document.getElementById('buyer-faculty-display').textContent = (user.unsoed_faculty || 'Belum Diatur') + ' / ' + (user.unsoed_major || 'Belum Diatur');
                document.getElementById('buyer_id_input').value = user.id;
            } catch (e) {
                console.error('Gagal memproses data pembeli', e);
            }
        }
    });

    async function handleCheckoutSubmit(e) {
        e.preventDefault();
        
        const form = document.getElementById('checkout-form');
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        const formData = {
            buyer_id: document.getElementById('buyer_id_input').value,
            metode_pengiriman: form.querySelector('input[name="metode_pengiriman"]:checked')?.value,
            alamat_pengiriman: document.getElementById('alamat_pengiriman').value,
            metode_pembayaran: form.querySelector('input[name="metode_pembayaran"]:checked')?.value,
        };

        // Basic validation checking
        if (!formData.metode_pengiriman) {
            window.showToast('Silakan pilih metode pengiriman.', 'error');
            return;
        }

        if (formData.metode_pengiriman === 'do' && !formData.alamat_pengiriman.trim()) {
            window.showToast('Alamat pengiriman wajib diisi untuk Delivery Order.', 'error');
            return;
        }

        if (!formData.metode_pembayaran) {
            window.showToast('Silakan pilih metode pembayaran.', 'error');
            return;
        }

        // Disable button and show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="animate-spin h-5 w-5 border-2 border-[#FBF6EC] border-t-transparent rounded-full mr-2"></span>
            Memproses...
        `;

        try {
            const response = await fetch("{{ route('checkout.store', $product->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Gagal memproses pembelian.');
            }

            if (data.snap_token) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.showToast('Pembayaran berhasil!');
                        
                        // Confirm payment success locally
                        fetch('/payment/confirm-success', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ order_id: result.order_id || result.id || data.snap_token })
                        })
                        .then(() => {
                            setTimeout(() => {
                                window.location.href = data.redirect_url || "{{ route('transactions.history') }}";
                            }, 1000);
                        })
                        .catch(err => {
                            console.error('Error confirming payment:', err);
                            setTimeout(() => {
                                window.location.href = data.redirect_url || "{{ route('transactions.history') }}";
                            }, 1000);
                        });
                    },
                    onPending: function(result) {
                        window.showToast('Pembayaran pending, silakan selesaikan pembayaran Anda.', 'info');
                        setTimeout(() => {
                            window.location.href = "{{ route('transactions.waiting') }}";
                        }, 1000);
                    },
                    onError: function(result) {
                        window.showToast('Pembayaran gagal atau terjadi kesalahan.', 'error');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    },
                    onClose: function() {
                        window.showToast('Pembayaran dibatalkan.', 'info');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                });
            } else {
                window.showToast('Pembayaran sukses dibuat (manual)!');
                setTimeout(() => {
                    window.location.href = data.redirect_url || "{{ route('transactions.history') }}";
                }, 1000);
            }
        } catch (error) {
            console.error('Checkout error:', error);
            window.showToast(error.message || 'Terjadi kesalahan sistem.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    }
</script>
@endsection
