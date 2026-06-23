@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-brand-900">
    <!-- Header -->
    <div class="border-b border-brand-500/20 pb-5 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight font-heading">Daftar Pesanan Masuk</h1>
            <p class="text-xs text-brand-650 mt-1 font-medium">Lihat seluruh riwayat pesanan dari pembeli untuk produk preloved Anda.</p>
        </div>
        <a href="{{ route('seller.dashboard') }}" class="px-5 py-3 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-bold text-xs rounded-xl shadow-md flex items-center gap-1.5 transition transform hover:-translate-y-0.5">
            Kembali ke Dashboard
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

    <!-- Orders Card -->
    <div class="bg-[#F5E4B0] p-6 sm:p-8 rounded-3xl border border-[#D4A017]/25 shadow-xl space-y-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#D4A017]/25 text-[10px] text-brand-600 uppercase font-bold">
                        <th class="pb-3 w-20">ID Order</th>
                        <th class="pb-3 pl-4">Produk</th>
                        <th class="pb-3 pl-4">Pembeli</th>
                        <th class="pb-3 pl-4">Pengiriman</th>
                        <th class="pb-3 pl-4">Tagihan</th>
                        <th class="pb-3 pl-4">Status</th>
                        <th class="pb-3 pr-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#D4A017]/15 text-xs">
                    @forelse($orders as $order)
                        <tr class="hover:bg-[#FBF6EC]/40 transition duration-150">
                            <td class="py-4 font-bold text-[#7A4A10]">
                                TRX-#{{ $order->id }}
                            </td>
                            <td class="py-4 pl-4 font-bold text-[#2E1A06] font-heading">
                                {{ $order->product->title ?? 'Produk Preloved' }}
                            </td>
                            <td class="py-4 pl-4">
                                <div class="font-bold text-[#2E1A06]">{{ $order->user->name ?? 'Mahasiswa' }}</div>
                                <div class="text-[10px] text-brand-650">{{ $order->user->email ?? '' }}</div>
                            </td>
                            <td class="py-4 pl-4 font-medium">
                                <div>{{ $order->shipping_method === 'COD' ? 'COD (Ketemuan)' : 'Delivery' }}</div>
                                @if($order->alamat_pengiriman)
                                    <div class="text-[9px] text-brand-650 max-w-xs truncate" title="{{ $order->alamat_pengiriman }}">
                                        {{ $order->alamat_pengiriman }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 pl-4 font-extrabold text-brand-900">
                                Rp {{ number_format($order->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-4 pl-4">
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
                            </td>
                            <td class="py-4 pr-4 text-right">
                                @if($order->status === 'success')
                                    <form action="{{ route('seller.transactions.confirm-delivery', $order->id) }}" method="POST" onsubmit="return handleConfirmDelivery(event, {{ $order->id }})">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-bold rounded-xl text-[9px] uppercase tracking-wider shadow-md transition transform hover:-translate-y-0.5">
                                            Konfirmasi Barang Sampai
                                        </button>
                                    </form>
                                @else
                                    <span class="text-brand-650 text-[10px] italic">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-brand-650 font-medium bg-[#FBF6EC]/20 rounded-2xl">
                                Belum ada pesanan masuk untuk produk Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="pt-4 border-t border-[#D4A017]/15">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Client-Side Login Guard
    (function() {
        const userJson = localStorage.getItem('preloved_user');
        if (!userJson) {
            window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.pathname);
        }
    })();

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
</script>
@endpush
@endsection
