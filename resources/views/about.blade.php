@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-[#F5E4B0]/60 text-[#2E1A06] py-16 px-4 overflow-hidden border-b border-[#D4A017]/20">
    <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(212,160,23,0.06)_1px,transparent_1px),linear-gradient(to_bottom,rgba(212,160,23,0.06)_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-40"></div>
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#D4A017]/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-5xl mx-auto text-center relative z-10 space-y-6">
        <span class="bg-[#7A4A10]/10 text-[#7A4A10] text-[11px] px-5 py-2 rounded-full font-bold uppercase tracking-wider border border-[#7A4A10]/20">
            Tentang Kami
        </span>
        <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight font-heading">
            Preloved.in Aja <br>
            <span class="gradient-text bg-gradient-to-r from-[#D4A017] to-[#7A4A10]">Pasar Preloved Mahasiswa UNSOED</span>
        </h1>
        <p class="max-w-2xl mx-auto text-[#2E1A06]/85 text-sm md:text-base leading-relaxed font-light">
            Menghubungkan mahasiswa Universitas Jenderal Soedirman untuk bertransaksi barang-barang preloved dengan aman, mudah, dan bebas biaya pengiriman melalui sistem COD di area kampus.
        </p>
    </div>
</section>

<!-- Konten Utama -->
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-20">
    
    <!-- Misi & Latar Belakang -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
            <h2 class="text-2xl font-black text-[#2E1A06] font-heading">Latar Belakang & Misi</h2>
            <div class="w-12 h-1 bg-[#D4A017] rounded-full"></div>
            <p class="text-sm text-[#2E1A06]/80 leading-relaxed font-light">
                Sebagai mahasiswa, kebutuhan akan buku referensi kuliah, peralatan kost, elektronik penunjang belajar, hingga pakaian terkadang menuntut anggaran yang tidak sedikit. Di sisi lain, banyak mahasiswa tingkat akhir atau alumni yang memiliki barang-barang layak pakai yang sudah tidak digunakan lagi.
            </p>
            <p class="text-sm text-[#2E1A06]/80 leading-relaxed font-light">
                <strong>Preloved.in Aja</strong> hadir sebagai jembatan sirkulasi barang di lingkungan UNSOED. Misi kami adalah membantu mahasiswa menghemat pengeluaran, mengurangi limbah lingkungan dengan memperpanjang siklus pakai barang, serta membangun rasa saling percaya dan kolaborasi antar mahasiswa.
            </p>
        </div>
        <div class="bg-[#F5E4B0] p-8 rounded-3xl border border-[#D4A017]/20 shadow-sm space-y-6 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#7A4A10]/5 rounded-full blur-2xl"></div>
            <h3 class="text-lg font-black text-[#7A4A10] font-heading">Mengapa Memilih Kami?</h3>
            
            <div class="space-y-4 text-xs sm:text-sm">
                <div class="flex gap-3">
                    <span class="text-[#7A4A10] font-bold">🤝</span>
                    <div>
                        <h4 class="font-bold text-[#2E1A06]">COD Area Kampus</h4>
                        <p class="text-xs text-[#2E1A06]/70 mt-0.5">Ketemuan langsung di perpustakaan, fakultas, atau gerbang UNSOED. Tanpa ongkos kirim.</p>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <span class="text-[#7A4A10] font-bold">🎓</span>
                    <div>
                        <h4 class="font-bold text-[#2E1A06]">Khusus Mahasiswa UNSOED</h4>
                        <p class="text-xs text-[#2E1A06]/70 mt-0.5">Autentikasi akun menggunakan email institusi resmi (@mhs.unsoed.ac.id) untuk keamanan transaksi.</p>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <span class="text-[#7A4A10] font-bold">🌱</span>
                    <div>
                        <h4 class="font-bold text-[#2E1A06]">Ekologi & Hemat</h4>
                        <p class="text-xs text-[#2E1A06]/70 mt-0.5">Mendukung gerakan ramah lingkungan dengan membeli dan menjual kembali barang layak pakai.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tim Pengembang -->
    <div class="space-y-10 text-center">
        <div class="space-y-3">
            <h2 class="text-2xl font-black text-[#2E1A06] font-heading">Tim Pengembang</h2>
            <p class="text-xs text-[#7A4A10]">Mahasiswa Universitas Jenderal Soedirman yang berdedikasi membangun platform ini</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Team Member 1 -->
            <div class="bg-[#F5E4B0] border border-[#D4A017]/25 rounded-3xl p-6 shadow-sm flex flex-col items-center space-y-4 card-premium">
                <img class="w-24 h-24 rounded-full object-cover border-4 border-[#7A4A10]" src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=150&h=150&q=80" alt="Aufa Algifari">
                <div>
                    <h3 class="font-heading font-black text-[#2E1A06] text-base leading-snug">Aufa Algifari</h3>
                    <p class="text-[11px] font-bold text-[#7A4A10] uppercase tracking-wider mt-0.5">Lead Developer & Checkout Integration</p>
                    <p class="text-xs text-[#2E1A06]/65 mt-2 font-light">Mahasiswa Teknik Informatika UNSOED yang mengintegrasikan sistem pembayaran Midtrans.</p>
                </div>
            </div>

            <!-- Team Member 2 -->
            <div class="bg-[#F5E4B0] border border-[#D4A017]/25 rounded-3xl p-6 shadow-sm flex flex-col items-center space-y-4 card-premium">
                <img class="w-24 h-24 rounded-full object-cover border-4 border-[#7A4A10]" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&h=150&q=80" alt="Nindy">
                <div>
                    <h3 class="font-heading font-black text-[#2E1A06] text-base leading-snug">Nindy</h3>
                    <p class="text-[11px] font-bold text-[#7A4A10] uppercase tracking-wider mt-0.5">Notification Specialist & Real-Time Sync</p>
                    <p class="text-xs text-[#2E1A06]/65 mt-2 font-light">Mahasiswa Teknik Informatika UNSOED yang menangani sistem notifikasi real-time Reverb.</p>
                </div>
            </div>

            <!-- Team Member 3 -->
            <div class="bg-[#F5E4B0] border border-[#D4A017]/25 rounded-3xl p-6 shadow-sm flex flex-col items-center space-y-4 card-premium">
                <img class="w-24 h-24 rounded-full object-cover border-4 border-[#7A4A10]" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80" alt="Tim Pengembang">
                <div>
                    <h3 class="font-heading font-black text-[#2E1A06] text-base leading-snug">Rian & Dina</h3>
                    <p class="text-[11px] font-bold text-[#7A4A10] uppercase tracking-wider mt-0.5">Product & UI Design Team</p>
                    <p class="text-xs text-[#2E1A06]/65 mt-2 font-light">Berkontribusi merancang pengalaman pengguna (UX) dan desain visual antarmuka platform.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
