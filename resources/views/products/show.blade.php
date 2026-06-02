@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        
        <div class="space-y-4">
            <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden flex items-center justify-center border">
                <span class="text-gray-400 text-sm">Foto Produk Utama</span>
            </div>
        </div>

        <div class="flex flex-col justify-between">
            <div>
                <span class="inline-block px-3 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full mb-3">
                    Status: {{ $product->status ?? 'Available' }}
                </span>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->title ?? 'Buku Referensi Kalkulus Purcell' }}</h1>
                <p class="text-2xl font-bold text-blue-600 mb-6">Rp {{ number_format($product->price ?? 120000, 0, ',', '.') }}</p>

                <div class="border-t border-b border-gray-100 py-4 mb-6 space-y-2 text-sm text-gray-600">
                    <p><strong>Kondisi:</strong> <span class="text-gray-800">{{ $product->condition ?? 'Like New' }}</span></p>
                    <p><strong>Kategori:</strong> <span class="text-gray-800">{{ $product->category ?? 'Textbooks' }}</span></p>
                    <p><strong>Penjual:</strong> <span class="text-blue-600 font-medium">{{ $product->seller->name ?? 'Mhs FEB Unsoed' }}</span></p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi Produk</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        {{ $product->description ?? 'Buku masih sangat mulus, jarang dipakai, tidak ada coretan di halaman dalam. Sangat cocok untuk mahasiswa tingkat awal teknik/mipa.' }}
                    </p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-4">
                <form action="/api/cart" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id ?? 1 }}">
                    <button type="submit" class="w-full bg-white border-2 border-blue-600 text-blue-600 py-3 rounded-xl font-semibold text-sm hover:bg-blue-50 transition">
                        + Keranjang
                    </button>
                </form>

                <form action="/api/chats" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id ?? 1 }}">
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold text-sm hover:bg-blue-700 transition shadow-sm">
                        Chat Penjual
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection