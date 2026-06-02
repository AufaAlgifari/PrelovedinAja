@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Keranjang Belanja Anda</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-lg"></div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">Kemeja Flanel Uniqlo Preloved</h3>
                        <p class="text-xs text-gray-400">Penjual: @mhs_faperta</p>
                        <p class="text-sm font-bold text-blue-600 mt-1">Rp 85.000</p>
                    </div>
                </div>
                <button class="text-red-500 hover:text-red-700 p-2 text-xs font-semibold">Hapus</button>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm h-fit">
            <h3 class="text-md font-bold text-gray-800 mb-4">Ringkasan Pesanan</h3>
            <div class="border-b border-gray-100 pb-4 mb-4 space-y-2 text-sm text-gray-600">
                <div class="flex justify-between"><span>Subtotal</span><span>Rp 85.000</span></div>
                <div class="flex justify-between"><span>Biaya Admin Kampus</span><span>Rp 0</span></div>
            </div>
            <div class="flex justify-between font-bold text-gray-800 text-md mb-6">
                <span>Total</span><span class="text-blue-600">Rp 85.000</span>
            </div>
            
            <form action="/api/transactions" method="POST">
                @csrf
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold text-center text-sm hover:bg-blue-700 transition block shadow-sm">
                    Checkout Sekarang (COD / Kurir)
                </button>
            </form>
        </div>
    </div>
</div>
@endsection