@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-[#F5E4B0]/60 text-[#2E1A06] w-full min-h-[calc(100vh-80px)] flex flex-col justify-center items-center py-20 px-4 overflow-hidden border-b border-[#D4A017]/20">
    <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(212,160,23,0.06)_1px,transparent_1px),linear-gradient(to_bottom,rgba(212,160,23,0.06)_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-40"></div>
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#D4A017]/10 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 right-0 w-80 h-80 bg-[#7A4A10]/5 rounded-full blur-3xl"></div>

    <div class="w-full max-w-5xl mx-auto text-center relative z-10 space-y-6">
        <h1 class="text-4xl md:text-6xl font-black tracking-tight leading-tight font-heading">
            Preloved.in <br>
            <span class="gradient-text bg-gradient-to-r from-[#D4A017] to-[#7A4A10]">Pasar Preloved Mahasiswa UNSOED</span>
        </h1>
        <p class="max-w-2xl mx-auto text-[#2E1A06]/85 text-sm md:text-base leading-relaxed font-light">
            Menghubungkan mahasiswa Universitas Jenderal Soedirman untuk bertransaksi barang-barang preloved dengan aman, mudah, dan bebas biaya pengiriman melalui sistem COD di area kampus.
        </p>
    </div>
</section>

<!-- Konten Utama -->
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    <!-- ① Latar Belakang & Misi — 2 kolom sejajar center -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <!-- Kolom Kiri: Teks -->
        <div class="space-y-5">
            <h2 class="text-2xl font-black text-[#2E1A06] font-heading">Latar Belakang &amp; Misi</h2>
            <div class="w-12 h-1 bg-[#D4A017] rounded-full"></div>
            <p class="text-sm text-[#2E1A06]/80 leading-relaxed font-light">
                Sebagai mahasiswa, kebutuhan akan buku referensi kuliah, peralatan kost, elektronik penunjang belajar, hingga pakaian terkadang menuntut anggaran yang tidak sedikit. Di sisi lain, banyak mahasiswa tingkat akhir atau alumni yang memiliki barang-barang layak pakai yang sudah tidak digunakan lagi.
            </p>
            <p class="text-sm text-[#2E1A06]/80 leading-relaxed font-light">
                <strong>Preloved.in</strong> hadir sebagai jembatan sirkulasi barang di lingkungan UNSOED. Misi kami adalah membantu mahasiswa menghemat pengeluaran, mengurangi limbah lingkungan dengan memperpanjang siklus pakai barang, serta membangun rasa saling percaya dan kolaborasi antar mahasiswa.
            </p>
        </div>

        <!-- Kolom Kanan: 3 card terpisah dengan SVG outline icons -->
        <div class="space-y-4">
            <!-- Card 1 -->
            <div class="bg-white border border-[#D4A017]/25 rounded-2xl p-5 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow duration-200">
                <div class="shrink-0 w-10 h-10 bg-[#F5E4B0] rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#7A4A10]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-[#2E1A06] text-sm">COD Area Kampus</h4>
                    <p class="text-xs text-[#2E1A06]/65 mt-1 leading-relaxed">Ketemuan langsung di perpustakaan, fakultas, atau gerbang UNSOED.</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white border border-[#D4A017]/25 rounded-2xl p-5 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow duration-200">
                <div class="shrink-0 w-10 h-10 bg-[#F5E4B0] rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#7A4A10]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-[#2E1A06] text-sm">Khusus Mahasiswa UNSOED</h4>
                    <p class="text-xs text-[#2E1A06]/65 mt-1 leading-relaxed">Autentikasi akun menggunakan email institusi resmi (@mhs.unsoed.ac.id) untuk keamanan transaksi.</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white border border-[#D4A017]/25 rounded-2xl p-5 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow duration-200">
                <div class="shrink-0 w-10 h-10 bg-[#F5E4B0] rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#7A4A10]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-[#2E1A06] text-sm">Ekologi &amp; Hemat</h4>
                    <p class="text-xs text-[#2E1A06]/65 mt-1 leading-relaxed">Mendukung gerakan ramah lingkungan dengan membeli dan menjual kembali barang layak pakai.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ② Section Statistik -->
    <div class="mt-20 bg-[#2E1A06] rounded-3xl px-8 py-12 text-[#FBF6EC] relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-[#D4A017]/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-[#7A4A10]/20 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <p class="text-center text-xs font-bold uppercase tracking-widest text-[#D4A017] mb-8">Platform dalam Angka</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div class="space-y-1">
                    <p class="text-3xl font-black text-[#D4A017]">500+</p>
                    <p class="text-xs text-[#FBF6EC]/60 font-light">Mahasiswa Terdaftar</p>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-[#D4A017]">1.200+</p>
                    <p class="text-xs text-[#FBF6EC]/60 font-light">Produk Terjual</p>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-[#D4A017]">7</p>
                    <p class="text-xs text-[#FBF6EC]/60 font-light">Fakultas UNSOED</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ③ Tim Pengembang -->
    <div class="mt-32 space-y-10 text-center">
        <div class="space-y-3">
            <h2 class="text-2xl font-black text-[#2E1A06] font-heading">Tim Pengembang</h2>
            <p class="text-xs text-[#7A4A10]">Mahasiswa Universitas Jenderal Soedirman yang berdedikasi membangun platform ini</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Team Member 1 -->
            <div class="bg-[#F5E4B0] border border-[#D4A017]/25 rounded-3xl p-6 shadow-sm flex flex-col items-center space-y-4 card-premium">
                <img class="w-24 h-24 rounded-full object-cover border-4 border-[#7A4A10]" src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=150&h=150&q=80" alt="Aufa Salsabila Alghifari">
                <div>
                    <h3 class="font-heading font-black text-[#2E1A06] text-base leading-snug">Aufa Salsabila Alghifari</h3>
                    <p class="text-[11px] font-bold text-[#7A4A10] uppercase tracking-wider mt-0.5">Lead Developer &amp; Checkout Integration</p>
                    <p class="text-xs text-[#2E1A06]/65 mt-2 font-light">Mahasiswa Teknik Informatika UNSOED yang mengintegrasikan sistem pembayaran Midtrans.</p>
                </div>
            </div>

            <!-- Team Member 2 -->
            <div class="bg-[#F5E4B0] border border-[#D4A017]/25 rounded-3xl p-6 shadow-sm flex flex-col items-center space-y-4 card-premium">
                <img class="w-24 h-24 rounded-full object-cover border-4 border-[#7A4A10]" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&h=150&q=80" alt="Nindya Alif Romland">
                <div>
                    <h3 class="font-heading font-black text-[#2E1A06] text-base leading-snug">Nindya Alif Romland</h3>
                    <p class="text-[11px] font-bold text-[#7A4A10] uppercase tracking-wider mt-0.5">Notification Specialist &amp; Real-Time Sync</p>
                    <p class="text-xs text-[#2E1A06]/65 mt-2 font-light">Mahasiswa Teknik Informatika UNSOED yang menangani sistem notifikasi real-time Reverb.</p>
                </div>
            </div>

            <!-- Team Member 3 -->
            <div class="bg-[#F5E4B0] border border-[#D4A017]/25 rounded-3xl p-6 shadow-sm flex flex-col items-center space-y-4 card-premium">
                <img class="w-24 h-24 rounded-full object-cover border-4 border-[#7A4A10]" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&h=150&q=80" alt="Melysa Ayu Wulansari">
                <div>
                    <h3 class="font-heading font-black text-[#2E1A06] text-base leading-snug">Melysa Ayu Wulansari</h3>
                    <p class="text-[11px] font-bold text-[#7A4A10] uppercase tracking-wider mt-0.5">UI/UX Designer &amp; Frontend Developer</p>
                    <p class="text-xs text-[#2E1A06]/65 mt-2 font-light">Mahasiswa Teknik Informatika UNSOED yang merancang desain visual dan memastikan antarmuka pengguna ramah serta responsif.</p>
                </div>
            </div>

            <!-- Team Member 4 -->
            <div class="bg-[#F5E4B0] border border-[#D4A017]/25 rounded-3xl p-6 shadow-sm flex flex-col items-center space-y-4 card-premium">
                <img class="w-24 h-24 rounded-full object-cover border-4 border-[#7A4A10]" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80" alt="Yunan Faila Sofi">
                <div>
                    <h3 class="font-heading font-black text-[#2E1A06] text-base leading-snug">Yunan Faila Sofi</h3>
                    <p class="text-[11px] font-bold text-[#7A4A10] uppercase tracking-wider mt-0.5">Database Administrator &amp; Backend Specialist</p>
                    <p class="text-xs text-[#2E1A06]/65 mt-2 font-light">Mahasiswa Teknik Informatika UNSOED yang bertanggung jawab atas arsitektur basis data dan efisiensi query server.</p>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
