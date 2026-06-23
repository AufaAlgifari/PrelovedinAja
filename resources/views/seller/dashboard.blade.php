@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-brand-900">
    <!-- Header -->
    <div class="border-b border-brand-500/20 pb-5 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight font-heading">Dashboard Penjual</h1>
            <p class="text-xs text-brand-650 mt-1 font-medium">Kelola produk preloved Anda dan pantau pesanan dari pembeli.</p>
        </div>
        <a href="{{ route('products.create') }}" class="px-5 py-3 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-bold text-xs rounded-xl shadow-md flex items-center gap-1.5 transition transform hover:-translate-y-0.5">
            Jual Barang Baru
        </a>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-md">
        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-xs font-bold">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Statistics Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-[#FBF6EC] p-5 rounded-3xl border border-[#D4A017]/25 shadow-sm text-center">
            <p class="text-[10px] font-bold text-brand-600 uppercase tracking-wider">Produk Aktif</p>
            <p class="text-2xl font-black text-brand-900 mt-1">{{ $stats['active'] }}</p>
            <p class="text-[9px] text-brand-600/70 mt-1 font-semibold">{{ $stats['pending'] }} menunggu verifikasi</p>
        </div>
        <div class="bg-[#FBF6EC] p-5 rounded-3xl border border-[#D4A017]/25 shadow-sm text-center">
            <p class="text-[10px] font-bold text-brand-600 uppercase tracking-wider">Pesanan Masuk</p>
            <p class="text-2xl font-black text-brand-900 mt-1">{{ $stats['orders'] }}</p>
        </div>
        <div class="bg-[#FBF6EC] p-5 rounded-3xl border border-[#D4A017]/25 shadow-sm text-center">
            <p class="text-[10px] font-bold text-brand-600 uppercase tracking-wider">Terjual / Sold</p>
            <p class="text-2xl font-black text-brand-900 mt-1">{{ $stats['sold'] }}</p>
        </div>
        <div class="bg-[#FBF6EC] p-5 rounded-3xl border border-[#D4A017]/25 shadow-sm text-center">
            <p class="text-[10px] font-bold text-brand-600 tracking-wider uppercase">Pendapatan Bulan Ini</p>
            <p class="text-lg font-black text-[#7A4A10] mt-1.5">Rp {{ number_format($stats['income'], 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Main Content Layout (Two Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- LEFT: Products List -->
        <div class="lg:col-span-8 bg-[#F5E4B0] p-6 sm:p-8 rounded-3xl border border-[#D4A017]/25 shadow-xl space-y-6">
            <h3 class="text-md font-bold font-heading">Daftar Produk Saya</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#D4A017]/25 text-[10px] text-brand-600 uppercase font-bold">
                            <th class="pb-3 w-16">Foto</th>
                            <th class="pb-3 pl-4">Nama Produk</th>
                            <th class="pb-3 pl-4">Harga</th>
                            <th class="pb-3 pl-4">Kondisi</th>
                            <th class="pb-3 pl-4">Status</th>
                            <th class="pb-3 pr-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="seller-products-body" class="divide-y divide-[#D4A017]/15 text-xs">
                        <tr>
                            <td colspan="6" class="text-center py-10 text-brand-650 font-medium">
                                Memuat produk...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RIGHT: Recent Orders & Confirmation -->
        <div class="lg:col-span-4 bg-[#F5E4B0] p-6 sm:p-8 rounded-3xl border border-[#D4A017]/25 shadow-xl space-y-6">
            <div class="flex justify-between items-center border-b border-[#D4A017]/25 pb-3">
                <div class="flex items-center gap-2">
                    <h3 class="text-md font-bold font-heading">Pesanan Terbaru</h3>
                    <span class="text-[9px] font-black text-brand-50 bg-[#7A4A10] px-2 py-0.5 rounded-full uppercase tracking-wider">{{ $badge }}</span>
                </div>
                <a href="{{ route('seller.orders') }}" class="text-[10px] font-extrabold text-[#7A4A10] hover:text-[#5f390c] transition underline">
                    Lihat Semua
                </a>
            </div>

            <div class="space-y-4">
                @forelse($recentOrders as $order)
                    <div class="p-4 bg-[#FBF6EC]/70 rounded-2xl border border-[#D4A017]/20 space-y-3 shadow-sm">
                        <div class="flex justify-between items-center text-[10px]">
                            <span class="text-brand-600 font-bold">TRX-#{{ $order->id }}</span>
                            
                            <!-- Badges -->
                            <span class="px-2 py-0.5 border rounded-full font-extrabold uppercase text-[9px] tracking-wide
                                {{ $order->status === 'success' ? 'bg-sky-50 text-sky-700 border-sky-200' :
                                  ($order->status === 'completed' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' :
                                  ($order->status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-100')) }}">
                                @if($order->status === 'success')
                                    Menunggu Barang
                                @elseif($order->status === 'completed')
                                    Selesai
                                @else
                                    {{ ucfirst($order->status) }}
                                @endif
                            </span>
                        </div>

                        <div>
                            <h4 class="font-extrabold text-[#2E1A06] text-xs leading-snug">{{ $order->product->title ?? 'Produk Preloved' }}</h4>
                            <p class="text-[10px] text-brand-600 mt-1">Pembeli: <strong>{{ $order->user->name }}</strong></p>
                            <p class="text-[10px] text-brand-650">Kirim: {{ $order->shipping_method === 'COD' ? 'COD (Ketemuan)' : 'Delivery' }}</p>
                        </div>

                        <div class="flex flex-col gap-2 pt-2.5 border-t border-[#D4A017]/15">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] text-brand-600 font-medium">Tagihan:</span>
                                <span class="text-xs font-black text-brand-900">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                            </div>

                            @if($order->status === 'success')
                                <form action="{{ route('seller.transactions.confirm-delivery', $order->id) }}" method="POST" class="pt-1" onsubmit="return handleConfirmDelivery(event, {{ $order->id }})">
                                    @csrf
                                    <button type="submit" class="w-full py-2 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-bold rounded-xl text-[9px] uppercase tracking-wider shadow-md transition transform hover:-translate-y-0.5 text-center flex items-center justify-center gap-1">
                                        Konfirmasi Barang Sampai
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-brand-650 text-center py-8 font-medium">Belum ada pesanan masuk.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    // Client-Side Login Guard
    (function() {
        const userJson = localStorage.getItem('preloved_user');
        if (!userJson) {
            window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.pathname);
        }
    })();

    async function loadSellerProducts() {
        const userJson = localStorage.getItem('preloved_user');
        if(!userJson) return;

        const user = JSON.parse(userJson);
        const token = localStorage.getItem('preloved_token');
        
        // Initial products from database parsed from Blade
        let products = @json($dbProducts ?? []);
        
        // Filter out database products that don't belong to the logged-in seller
        products = products.filter(p => p.seller_id === user.id || (p.seller && p.seller.id === user.id) || (p.seller && p.seller.email === user.email));

        // Merge custom uploaded items from local storage
        const customProducts = JSON.parse(localStorage.getItem('preloved_custom_products') || '[]');
        
        // Filter only own custom products for simulation
        const ownCustom = customProducts.filter(p => p.seller && p.seller.email === user.email);
        
        // Combine them (avoiding duplicates if they are already in the database)
        const dbProductIds = new Set(products.map(p => p.id));
        const filteredOwnCustom = ownCustom.filter(p => !dbProductIds.has(p.id));
        
        products = [...filteredOwnCustom, ...products];

        renderProductsTable(products);
    }

    function renderProductsTable(products) {
        const tbody = document.getElementById('seller-products-body');
        tbody.innerHTML = '';

        if(products.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-10 text-brand-650 font-medium">
                        Anda belum menjual produk apapun. Mulai berjualan sekarang!
                    </td>
                </tr>
            `;
            return;
        }

        products.forEach(p => {
            const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(p.price);
            const imageUrl = p.image_urls && p.image_urls.length > 0 ? p.image_urls[0] : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=150&h=150&q=80';
            
            let displayCondition = p.condition;
            if (displayCondition === 'New' || displayCondition === 'Like New') displayCondition = 'Baru';
            else if (displayCondition === 'Good') displayCondition = 'Bekas';
            else if (displayCondition === 'Well Used') displayCondition = 'Usang';

            const row = document.createElement('tr');
            row.className = "hover:bg-[#FBF6EC]/40 transition duration-150";

            row.innerHTML = `
                <td class="py-3.5">
                    <img class="w-11 h-11 rounded-xl object-cover border border-[#D4A017]/25 bg-[#FBF6EC]" src="${imageUrl}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=150&h=150&q=80';">
                </td>
                <td class="py-3.5 pl-4 font-bold text-[#2E1A06] font-heading">
                    ${p.title}
                </td>
                <td class="py-3.5 pl-4 font-extrabold text-[#7A4A10]">
                    ${formattedPrice}
                </td>
                <td class="py-3.5 pl-4 font-semibold">
                    ${displayCondition}
                </td>
                <td class="py-3.5 pl-4">
                    <select onchange="updateProductStatus(${p.id}, this.value)" class="bg-[#FBF6EC] border border-[#D4A017]/35 rounded-xl px-2 py-1.5 focus:outline-none focus:border-brand-600 font-bold text-xs text-[#2E1A06]">
                        <option value="Available" ${p.status === 'Available' ? 'selected' : ''}>Available</option>
                        <option value="Reserved" ${p.status === 'Reserved' ? 'selected' : ''}>Reserved</option>
                        <option value="Sold" ${p.status === 'Sold' ? 'selected' : ''}>Sold</option>
                    </select>
                </td>
                <td class="py-3.5 pr-4 text-right">
                    <button onclick="deleteProduct(${p.id})" class="text-rose-600 hover:text-rose-800 p-2 rounded-xl hover:bg-rose-50/50 transition font-bold">
                        ✕ Hapus
                    </button>
                </td>
            `;

            tbody.appendChild(row);
        });
    }

    async function updateProductStatus(productId, newStatus) {
        const token = localStorage.getItem('preloved_token');
        const isDemo = !token || token === 'mock_token_12345';
        
        if (!isDemo) {
            try {
                const response = await fetch(`/api/v1/products/${productId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                if (response.ok) {
                    window.showToast('Status produk berhasil diperbarui.');
                    setTimeout(() => { window.location.reload(); }, 800);
                    return;
                }
            } catch (error) {
                console.log('Update status API error, updating locally.');
            }
        }

        // Simulate local updates
        const customProducts = JSON.parse(localStorage.getItem('preloved_custom_products') || '[]');
        const target = customProducts.find(p => p.id == productId);
        if (target) {
            target.status = newStatus;
            localStorage.setItem('preloved_custom_products', JSON.stringify(customProducts));
            window.showToast('Status diperbarui (Simulasi)!');
            loadSellerProducts();
        }
    }

    async function deleteProduct(productId) {
        if(!confirm('Apakah Anda yakin ingin menghapus produk preloved ini?')) return;
        const token = localStorage.getItem('preloved_token');
        const isDemo = !token || token === 'mock_token_12345';

        if (!isDemo) {
            try {
                const response = await fetch(`/api/v1/products/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.ok) {
                    window.showToast('Produk berhasil dihapus.');
                    setTimeout(() => { window.location.reload(); }, 800);
                    return;
                }
            } catch (error) {
                console.log('Delete API error, simulating delete.');
            }
        }

        // Simulate local delete
        let customProducts = JSON.parse(localStorage.getItem('preloved_custom_products') || '[]');
        customProducts = customProducts.filter(p => p.id != productId);
        localStorage.setItem('preloved_custom_products', JSON.stringify(customProducts));
        window.showToast('Produk dihapus (Simulasi)!');
        loadSellerProducts();
    }

    function handleConfirmDelivery(event, orderId) {
        const token = localStorage.getItem('preloved_token');
        const isDemo = !token || token === 'mock_token_12345';
        
        if (isDemo) {
            event.preventDefault();
            window.showToast('Pengiriman barang berhasil dikonfirmasi (Simulasi)!');
            setTimeout(() => {
                window.location.reload();
            }, 800);
            return false;
        }
        return true;
    }

    window.addEventListener('DOMContentLoaded', () => {
        loadSellerProducts();
    });
</script>
@endsection
