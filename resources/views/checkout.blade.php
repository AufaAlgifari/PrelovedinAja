@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back to Product Link -->
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#7A4A10] hover:text-[#2E1A06] transition">
            ← Kembali
        </a>
    </div>

    <div class="bg-[#F5E4B0] p-6 sm:p-10 rounded-3xl border border-[#D4A017]/25 shadow-xl text-[#2E1A06]">
        <h1 class="text-2xl font-black mb-6 border-b border-[#D4A017]/30 pb-4">Ringkasan Checkout</h1>
        
        <div class="flex items-start gap-4 mb-6">
            <div class="w-24 h-24 bg-[#FBF6EC] rounded-xl overflow-hidden border border-[#D4A017]/20 flex-shrink-0">
                <img src="{{ $product->image_urls[0] ?? 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
            </div>
            
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-block px-2 py-1 bg-[#FBF6EC] border border-[#D4A017]/35 text-[#7A4A10] text-[10px] font-extrabold uppercase tracking-wider rounded-full">
                        {{ $product->category }}
                    </span>
                    <span class="inline-block px-2 py-1 border border-[#D4A017]/30 text-[#7A4A10] text-[10px] font-extrabold uppercase tracking-wider rounded-full">
                        {{ $product->condition }}
                    </span>
                </div>
                <h3 class="text-lg font-bold leading-tight mb-2">{{ $product->title }}</h3>
                <p class="text-xl font-black text-[#7A4A10]">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-[#FBF6EC] rounded-2xl p-5 border border-[#D4A017]/20 mb-8">
            <div class="flex justify-between items-center border-b border-[#D4A017]/20 pb-3 mb-3">
                <span class="text-sm font-bold text-[#7A4A10]">Subtotal Produk</span>
                <span class="text-sm font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-lg font-black text-[#7A4A10]">Total Pembayaran</span>
                <span class="text-xl font-black text-[#7A4A10]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button onclick="alert('Integrasi Midtrans segera hadir!')" class="w-full sm:w-auto px-8 py-4 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-bold text-sm uppercase tracking-wider rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                Lanjut ke Pembayaran
            </button>
        </div>
    </div>
</div>
@endsection
