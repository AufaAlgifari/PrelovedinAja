@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto text-center py-16 px-4">
    <h1 class="text-3xl md:text-5xl font-bold text-gray-800 tracking-tight leading-tight">
        Pasar Kampus Terpercaya untuk <br>
        <span class="text-blue-600">Barang Preloved</span> Berkualitas
    </h1>
    <div class="w-48 h-1.5 bg-gray-200 mx-auto mt-6 rounded-full"></div>
    <div class="w-32 h-1 bg-gray-100 mx-auto mt-2 rounded-full"></div>

    <div class="mt-8 max-w-xl mx-auto">
        <form action="#" method="GET" class="relative flex items-center border-2 border-blue-100 bg-white rounded-full shadow-sm p-1.5 focus-within:border-blue-400 transition">
            <span class="pl-3 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" name="search" placeholder="Cari buku, elektronik, furnitur..." class="w-full pl-3 pr-4 text-sm text-gray-700 bg-transparent focus:outline-none">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-full text-xs font-semibold hover:bg-blue-700 transition">Cari</button>
        </form>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h3 class="text-lg font-bold text-gray-800 border-b-4 border-gray-700 inline-block pb-1 mb-8">Kategori Populer</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-blue-100 p-8 rounded-2xl flex flex-col justify-between min-h-[180px]">
            <div>
                <div class="h-4 bg-gray-700 w-1/3 rounded mb-2"></div>
                <div class="h-3 bg-gray-700 w-1/2 rounded"></div>
            </div>
            <button class="bg-gray-700 text-white text-xs px-4 py-2 rounded w-max mt-4">Lihat</button>
        </div>

        <div class="bg-blue-100 p-8 rounded-2xl flex flex-col justify-between min-h-[180px]">
            <div>
                <div class="h-4 bg-gray-700 w-1/2 rounded mb-2"></div>
                <div class="h-3 bg-gray-700 w-2/3 rounded"></div>
            </div>
            <button class="bg-gray-700 text-white text-xs px-4 py-2 rounded w-max mt-4">Lihat</button>
        </div>

        <div class="bg-blue-100 p-8 rounded-2xl flex flex-col justify-between min-h-[180px]">
            <div>
                <div class="h-4 bg-gray-700 w-1/2 rounded mb-2"></div>
                <div class="h-3 bg-gray-700 w-2/3 rounded"></div>
            </div>
            <button class="bg-gray-700 text-white text-xs px-4 py-2 rounded w-max mt-4">Lihat</button>
        </div>

        <div class="md:col-span-2 bg-blue-100 p-8 rounded-2xl flex flex-col justify-between min-h-[180px]">
            <div>
                <div class="h-4 bg-gray-700 w-1/3 rounded mb-2"></div>
                <div class="h-3 bg-gray-700 w-1/2 rounded"></div>
            </div>
            <button class="bg-gray-700 text-white text-xs px-4 py-2 rounded w-max mt-4">Lihat</button>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <h3 class="text-md font-bold text-gray-700 uppercase tracking-wider mb-2">Cara Kerja Preloved.in</h3>
    <div class="w-32 h-1 bg-gray-300 mx-auto mb-12 rounded-full"></div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-4xl mx-auto">
        <div class="flex flex-col items-center">
            <div class="w-24 h-24 bg-gray-200 rounded-lg shadow-inner mb-4"></div>
            <div class="h-3 bg-gray-300 w-2/3 rounded mb-2"></div>
            <div class="h-2 bg-gray-200 w-1/2 rounded"></div>
        </div>
        <div class="flex flex-col items-center">
            <div class="w-24 h-24 bg-gray-200 rounded-lg shadow-inner mb-4"></div>
            <div class="h-3 bg-gray-300 w-2/3 rounded mb-2"></div>
            <div class="h-2 bg-gray-200 w-1/2 rounded"></div>
        </div>
        <div class="flex flex-col items-center">
            <div class="w-24 h-24 bg-gray-200 rounded-lg shadow-inner mb-4"></div>
            <div class="h-3 bg-gray-300 w-2/3 rounded mb-2"></div>
            <div class="h-2 bg-gray-200 w-1/2 rounded"></div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 mb-10">
    <div class="bg-gray-200 rounded-2xl p-8 md:p-12 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
            <div class="h-5 bg-white w-1/3 rounded mb-4"></div>
            <div class="h-3 bg-white w-5/6 rounded mb-2"></div>
            <div class="h-3 bg-white w-2/3 rounded mb-8"></div>
            <div class="flex space-x-3">
                <div class="w-24 h-8 bg-gray-700 rounded shadow-sm"></div>
                <div class="w-24 h-8 bg-gray-700 rounded shadow-sm"></div>
            </div>
        </div>
        <div class="bg-gray-700 rounded-xl p-6 flex flex-col space-y-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-full"></div>
                <div class="flex-1 space-y-2">
                    <div class="h-3 bg-white w-1/3 rounded"></div>
                    <div class="h-2 bg-white w-1/2 rounded"></div>
                </div>
            </div>
            <div class="h-2 bg-white w-full rounded"></div>
            <div class="h-2 bg-white w-5/6 rounded"></div>
        </div>
    </div>
</section>
@endsection