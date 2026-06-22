@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-brand-900">
    <!-- Header -->
    <div class="border-b border-brand-500/20 pb-5 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight font-heading">Dashboard Penjual</h1>
            <p class="text-xs text-brand-600 mt-1 font-medium font-heading">Kelola dan pantau seluruh produk preloved yang Anda pasarkan.</p>
        </div>
        <a href="{{ route('products.create') }}" class="px-5 py-3 bg-brand-600 hover:bg-brand-900 text-brand-50 font-bold text-xs rounded-xl shadow-md flex items-center gap-1.5 transition">
            Jual Barang Baru
        </a>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
        <div class="bg-brand-100 p-6 rounded-3xl border border-brand-500/15 shadow-sm text-center">
            <span class="text-2xl"></span>
            <h4 class="text-sm font-bold text-brand-600 mt-2 uppercase">Total Produk Aktif</h4>
            <p id="stat-active" class="text-3xl font-black text-brand-900 mt-1">0</p>
        </div>
        <div class="bg-brand-100 p-6 rounded-3xl border border-brand-500/15 shadow-sm text-center">
            <span class="text-2xl"></span>
            <h4 class="text-sm font-bold text-brand-600 mt-2 uppercase">Terjual / Sold</h4>
            <p id="stat-sold" class="text-3xl font-black text-brand-900 mt-1">0</p>
        </div>
        <div class="bg-brand-100 p-6 rounded-3xl border border-brand-500/15 shadow-sm text-center">
            <span class="text-2xl">
                
            </span>
            <h4 class="text-sm font-bold text-brand-600 mt-2 uppercase">Total Pengunjung</h4>
            <p id="stat-views" class="text-3xl font-black text-brand-900 mt-1">0</p>
        </div>
    </div>

    <!-- Products List Section -->
    <div class="bg-brand-100 p-6 rounded-3xl border border-brand-500/25 shadow-xl">
        <h3 class="text-lg font-extrabold mb-6 font-heading">Daftar Produk Saya</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-brand-500/20 text-xs text-brand-600 uppercase font-bold">
                        <th class="pb-3 w-20">Foto</th>
                        <th class="pb-3 pl-4">Nama Produk</th>
                        <th class="pb-3 pl-4">Harga</th>
                        <th class="pb-3 pl-4">Kondisi</th>
                        <th class="pb-3 pl-4">Status</th>
                        <th class="pb-3 pr-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="seller-products-body" class="divide-y divide-brand-500/10 text-xs">
                    <!-- Dynamically populated via JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    async function loadSellerProducts() {
        const userJson = localStorage.getItem('preloved_user');
        if(!userJson) return;

        const user = JSON.parse(userJson);
        const token = localStorage.getItem('preloved_token');
        let products = [];

        try {
            // Attempt to load seller products from real API
            const response = await fetch('/api/v1/products', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            if (response.ok) {
                const data = await response.json();
                products = data.data || [];
            }
        } catch (error) {
            console.log('Database product list API offline, using local storage.');
        }

        // Merge custom uploaded items from local storage
        const customProducts = JSON.parse(localStorage.getItem('preloved_custom_products') || '[]');
        products = [...customProducts, ...products];

        renderProductsTable(products);
    }

    function renderProductsTable(products) {
        const tbody = document.getElementById('seller-products-body');
        tbody.innerHTML = '';

        if(products.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-10 text-brand-600 font-medium">
                        Anda belum menjual produk apapun. Mulai berjualan sekarang!
                    </td>
                </tr>
            `;
            return;
        }

        let totalActive = 0;
        let totalSold = 0;
        let totalViews = 0;

        products.forEach(p => {
            const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(p.price);
            const imageUrl = p.image_urls && p.image_urls.length > 0 ? p.image_urls[0] : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=150&h=150&q=80';
            const views = p.views_count || 0;

            if (p.status === 'Available') totalActive++;
            if (p.status === 'Sold') totalSold++;
            totalViews += views;

            const row = document.createElement('tr');
            row.className = "hover:bg-brand-50/50 transition duration-150";

            row.innerHTML = `
                <td class="py-4">
                    <img class="w-14 h-14 rounded-xl object-cover border border-brand-500/20 bg-brand-50" src="${imageUrl}">
                </td>
                <td class="py-4 pl-4 font-bold text-[#2E1A06] font-heading">
                    ${p.title}
                </td>
                <td class="py-4 pl-4 font-extrabold text-brand-600">
                    ${formattedPrice}
                </td>
                <td class="py-4 pl-4 font-semibold text-brand-900">
                    ${p.condition}
                </td>
                <td class="py-4 pl-4">
                    <select onchange="updateProductStatus(${p.id}, this.value)" class="bg-brand-50 border border-brand-500/30 rounded-xl px-2 py-1.5 focus:outline-none focus:border-brand-600 font-bold">
                        <option value="Available" ${p.status === 'Available' ? 'selected' : ''}>Available</option>
                        <option value="Reserved" ${p.status === 'Reserved' ? 'selected' : ''}>Reserved</option>
                        <option value="Sold" ${p.status === 'Sold' ? 'selected' : ''}>Sold</option>
                    </select>
                </td>
                <td class="py-4 pr-4 text-right space-x-2">
                    <button onclick="deleteProduct(${p.id})" class="text-rose-600 hover:text-rose-800 p-2 rounded-xl hover:bg-rose-50 transition">
                        ✕ Hapus
                    </button>
                </td>
            `;

            tbody.appendChild(row);
        });

        // Set Stats
        document.getElementById('stat-active').textContent = totalActive;
        document.getElementById('stat-sold').textContent = totalSold;
        document.getElementById('stat-views').textContent = totalViews;
    }

    async function updateProductStatus(productId, newStatus) {
        const token = localStorage.getItem('preloved_token');
        
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
            }
        } catch (error) {
            console.log('Update status API offline, updating locally.');
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
                loadSellerProducts();
                return;
            }
        } catch (error) {
            console.log('Delete API offline, simulating delete.');
        }

        // Simulate local delete
        let customProducts = JSON.parse(localStorage.getItem('preloved_custom_products') || '[]');
        customProducts = customProducts.filter(p => p.id != productId);
        localStorage.setItem('preloved_custom_products', JSON.stringify(customProducts));
        window.showToast('Produk dihapus (Simulasi)!');
        loadSellerProducts();
    }

    window.addEventListener('DOMContentLoaded', () => {
        loadSellerProducts();
    });
</script>
@extends('layouts.app')
@section('title', 'Dashboard Penjual')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Dashboard Penjual</h1>
            <p class="text-sm text-gray-500">Halo, {{ Auth::user()->name }} 👋</p>
        </div>
        <a href="{{ route('seller.products.create') }}"
           class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded-lg flex items-center gap-2">
            + Jual Barang
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-5">
        {{ session('success') }}
    </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-1">Produk Aktif</p>
            <p class="text-2xl font-semibold">{{ $stats['active'] }}</p>
            <p class="text-xs text-gray-400">{{ $stats['pending'] }} menunggu verifikasi</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-1">Pesanan Masuk</p>
            <p class="text-2xl font-semibold">{{ $stats['orders'] }}</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-1">Terjual</p>
            <p class="text-2xl font-semibold">{{ $stats['sold'] }}</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-1">Pendapatan Bulan Ini</p>
            <p class="text-lg font-semibold">Rp {{ number_format($stats['income'], 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Pesanan Terbaru --}}
    <div class="bg-white border border-gray-100 rounded-xl p-5">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Pesanan Terbaru</h2>
        @forelse($recentOrders as $order)
        <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
            <div>
                <p class="text-xs text-gray-400">#{{ $order->order_id_midtrans ?? $order->id }}</p>
                <p class="text-sm font-medium text-gray-800">{{ $order->product->name }}</p>
                <p class="text-xs text-gray-400">Pembeli: {{ $order->user->name }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-semibold">Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
                <span class="text-xs px-2 py-0.5 rounded-full
                    {{ $order->status === 'success' ? 'bg-green-100 text-green-700' :
                      ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-400">Belum ada pesanan.</p>
        @endforelse
    </div>
</div>
@endsection
