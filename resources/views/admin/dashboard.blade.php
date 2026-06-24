@extends('layouts.app')

@section('content')

{{-- Override layout supaya full width tanpa padding bawaan --}}
<style>
    /* Sembunyikan navbar utama dari layouts.app kalau ada */
    body { background-color: #FBF6EC; }
</style>

<!-- Admin Navbar -->
<nav class="bg-[#F5E4B0] border-b border-[#D4A017]/30 sticky top-0 z-40 w-full shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left Side: Brand Logo and Title -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <svg class="w-8 h-8" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 20L165 42L100 64L35 42L100 20Z" fill="var(--primary-color)" />
                        <path d="M52 48.5V68C52 70.5 49.5 72 47 72C44.5 72 42 70.5 42 68V45" stroke="var(--cta-color)" stroke-width="4.5" stroke-linecap="round"/>
                        <circle cx="47" cy="72" r="6.5" fill="var(--text-color)"/>
                        <path d="M68 62C68 38 132 38 132 62" stroke="var(--surface-color)" stroke-width="15" stroke-linecap="round"/>
                        <path d="M42 62H158L168 165C168 171 163 175 157 175H43C37 175 32 171 32 165L42 62Z" fill="var(--primary-color)"/>
                        <path d="M72 88H108C122 88 132 98 132 110C132 122 122 132 108 132H72V88ZM72 132V150" stroke="var(--bg-color)" stroke-width="13" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-lg font-black tracking-tight leading-none text-[#2E1A06] font-heading">Preloved.in <span class="text-[#7A4A10]">Admin</span></span>
                </a>
            </div>

            <!-- Middle: Nav Links (without Transactions) -->
            <div class="hidden md:flex items-center gap-6 text-xs font-bold uppercase tracking-wider">
                <button id="nav-dashboard" onclick="showSection('dashboard')" class="px-3 py-2 rounded-lg transition-all">Dashboard</button>
                <button id="nav-users" onclick="showSection('users')" class="px-3 py-2 rounded-lg transition-all">Pengguna</button>
                <button id="nav-listings" onclick="showSection('listings')" class="px-3 py-2 rounded-lg transition-all">Produk</button>
                <button id="nav-reports" onclick="showSection('reports')" class="px-3 py-2 rounded-lg transition-all">Laporan</button>
            </div>

            <!-- Right Side: Notification Bell & Admin Profile Dropdown -->
            <div class="flex items-center gap-4">
                <!-- Notifications -->
                <div class="relative">
                    <button onclick="toggleAdminNotifDropdown()" class="relative p-2 text-[#7A4A10] hover:text-[#2E1A06] rounded-xl hover:bg-[#FAF4C8]/50 transition-all focus:outline-none flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span id="notif-badge" class="absolute top-1.5 right-1.5 bg-rose-600 text-white text-[9px] font-bold h-4 w-4 rounded-full flex items-center justify-center hidden">!</span>
                    </button>
                    <!-- Admin Notification Dropdown -->
                    <div id="admin-notif-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-80 rounded-2xl shadow-xl bg-[#FBF6EC] border border-[#D4A017]/25 focus:outline-none z-50 overflow-hidden">
                        <div class="px-4 py-3 bg-[#F5E4B0]/55 flex justify-between items-center border-b border-[#D4A017]/10">
                            <span class="text-xs font-extrabold text-[#2E1A06] font-heading">Notifikasi Admin</span>
                            <button onclick="markAllAdminNotificationsRead()" class="text-[9px] font-bold text-[#7A4A10] hover:text-[#2E1A06] focus:outline-none transition">Tandai Semua Dibaca</button>
                        </div>
                        <div id="admin-notif-items" class="max-h-72 overflow-y-auto divide-y divide-[#D4A017]/10 text-xs">
                            <div class="p-5 text-center text-[#7A4A10] font-medium">Memuat notifikasi...</div>
                        </div>
                    </div>
                </div>

                <!-- Admin Profile Dropdown -->
                <div class="relative">
                    <button onclick="toggleAdminProfileDropdown()" class="flex items-center gap-2 focus:outline-none hover:bg-[#FAF4C8]/50 p-1.5 rounded-full transition duration-150">
                        <div id="admin-avatar-placeholder" class="h-8 w-8 rounded-full bg-[#7A4A10] text-[#FBF6EC] flex items-center justify-center font-bold text-xs border border-[#D4A017]/30">
                            A
                        </div>
                        <span id="admin-name" class="text-xs font-bold text-[#2E1A06] hidden sm:inline">Admin</span>
                        <svg class="w-4 h-4 text-[#7A4A10]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <!-- Dropdown Content -->
                    <div id="admin-profile-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-2xl shadow-xl bg-[#FBF6EC] border border-[#D4A017]/25 divide-y divide-[#D4A017]/10 focus:outline-none z-50 overflow-hidden">
                        <div class="py-1">
                            <a href="{{ route('profile.index') }}" class="block px-4 py-2.5 text-xs font-bold text-[#2E1A06] hover:bg-[#F5E4B0]/50">Profil Saya</a>
                        </div>
                        <div class="py-1">
                            <button onclick="window.logoutUser()" class="w-full text-left block px-4 py-2.5 text-xs font-black text-rose-700 hover:bg-rose-50 flex items-center gap-2">
                                Keluar Akun
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button onclick="toggleAdminMobileMenu()" class="md:hidden p-2 text-[#7A4A10] hover:text-[#2E1A06] focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Admin Mobile Menu -->
    <div id="admin-mobile-menu" class="hidden md:hidden bg-[#F5E4B0] border-t border-[#D4A017]/20 px-4 py-3 flex flex-col gap-2 shadow-inner">
        <button id="mobile-nav-dashboard" onclick="showSection('dashboard'); toggleAdminMobileMenu()" class="text-left px-3 py-2 rounded-lg text-xs font-bold uppercase tracking-wider text-[#2E1A06] hover:bg-[#FAF4C8]/50 transition">Dashboard</button>
        <button id="mobile-nav-users" onclick="showSection('users'); toggleAdminMobileMenu()" class="text-left px-3 py-2 rounded-lg text-xs font-bold uppercase tracking-wider text-[#2E1A06] hover:bg-[#FAF4C8]/50 transition">Pengguna</button>
        <button id="mobile-nav-listings" onclick="showSection('listings'); toggleAdminMobileMenu()" class="text-left px-3 py-2 rounded-lg text-xs font-bold uppercase tracking-wider text-[#2E1A06] hover:bg-[#FAF4C8]/50 transition">Produk</button>
        <button id="mobile-nav-reports" onclick="showSection('reports'); toggleAdminMobileMenu()" class="text-left px-3 py-2 rounded-lg text-xs font-bold uppercase tracking-wider text-[#2E1A06] hover:bg-[#FAF4C8]/50 transition">Laporan</button>
    </div>
</nav>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-[#2E1A06]">

    <!-- ── SECTION: DASHBOARD ── -->
    <div id="section-dashboard">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-extrabold font-heading">Dashboard Admin</h1>
            <p class="text-sm text-[#7A4A10] mt-0.5">Welcome back, Administrator. Here's what's happening on campus today.</p>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-white p-5 rounded-2xl border border-[#D4A017]/20 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-[#F5E4B0] rounded-xl">
                        <svg class="w-5 h-5 text-[#7A4A10]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">↑ Live</span>
                </div>
                <p class="text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider">Total Pengguna</p>
                <p id="stat-users-total" class="text-3xl font-black mt-1">—</p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-[#D4A017]/20 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-[#F5E4B0] rounded-xl">
                        <svg class="w-5 h-5 text-[#7A4A10]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">↑ Live</span>
                </div>
                <p class="text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider">Total Listing Aktif</p>
                <p id="stat-listings-active" class="text-3xl font-black mt-1">—</p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-[#D4A017]/20 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-rose-50 rounded-xl">
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <span id="reports-urgency" class="text-[10px] font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-100">! High</span>
                </div>
                <p class="text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider">Laporan Masuk</p>
                <p id="stat-reports-pending" class="text-3xl font-black mt-1">—</p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-[#D4A017]/20 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-[#F5E4B0] rounded-xl">
                        <svg class="w-5 h-5 text-[#7A4A10]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">↑ Live</span>
                </div>
                <p class="text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider">Transaksi Selesai</p>
                <p id="stat-transactions-total" class="text-3xl font-black mt-1">—</p>
            </div>
        </div>

        <!-- Chart + Recent Reports -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Chart Aktivitas 7 Hari -->
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-[#D4A017]/20 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-extrabold font-heading">Aktivitas Platform (7 Hari Terakhir)</h3>
                    <div class="flex items-center gap-3 text-[10px] font-bold">
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#7A4A10] inline-block"></span> Listing Baru</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#D4A017] inline-block"></span> Pengguna Baru</span>
                    </div>
                </div>
                <canvas id="activityChart" height="120"></canvas>
            </div>

            <!-- Audit Log ringkas -->
            <div class="bg-white p-6 rounded-2xl border border-[#D4A017]/20 shadow-sm flex flex-col">
                <h3 class="font-extrabold font-heading mb-4">Log Aktivitas Terbaru</h3>
                <div id="audit-logs-list" class="space-y-3 overflow-y-auto max-h-64 flex-1 pr-1 divide-y divide-[#D4A017]/10">
                    <p class="text-xs text-[#7A4A10]">Memuat...</p>
                </div>
            </div>
        </div>

        <!-- Recent Reports Table -->
        <div class="bg-white p-6 rounded-2xl border border-[#D4A017]/20 shadow-sm mb-8">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-extrabold font-heading">Laporan Masuk Terbaru</h3>
                <button onclick="showSection('reports')" class="text-xs font-bold text-[#7A4A10] hover:underline">View All Reports →</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs min-w-[600px] md:min-w-0">
                    <thead>
                        <tr class="text-[10px] font-black uppercase text-[#7A4A10] border-b border-[#D4A017]/20">
                            <th class="text-left pb-3 pl-2">Pelapor</th>
                            <th class="text-left pb-3">Subjek Laporan</th>
                            <th class="text-left pb-3">Tanggal</th>
                            <th class="text-left pb-3">Status</th>
                            <th class="text-left pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="reports-table-body" class="divide-y divide-[#D4A017]/10">
                        <tr><td colspan="5" class="py-6 text-center text-[#7A4A10]">Memuat...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{-- end section-dashboard --}}


    <!-- ── SECTION: REPORTS (Full) ── -->
    <div id="section-reports" class="hidden">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-extrabold font-heading">Semua Laporan Pengaduan</h2>
        </div>
        <div id="reports-list" class="space-y-4"></div>
        <div id="reports-pagination" class="flex justify-center gap-2 pt-4"></div>
    </div>


    <!-- ── SECTION: LISTINGS ── -->
    <div id="section-listings" class="hidden">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-extrabold font-heading">Manajemen Listing Produk</h2>
            <div class="flex items-center gap-2">
                <input id="product-search" type="text" placeholder="Cari judul produk..."
                       class="text-xs px-3 py-2 rounded-lg border border-[#D4A017]/20 bg-[#FBF6EC] focus:outline-none focus:ring-2 focus:ring-[#7A4A10]/20"
                       onkeyup="if(event.key==='Enter') loadProducts(1)">
                <button onclick="resetProductFilter()" class="px-3 py-2 bg-white text-xs font-bold border border-[#D4A017]/30 text-[#7A4A10] hover:bg-[#F5E4B0] rounded-lg transition">Reset</button>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-[#D4A017]/20 shadow-sm overflow-x-auto">
            <table class="w-full text-xs min-w-[600px] md:min-w-0">
                <thead>
                    <tr class="text-[10px] font-black uppercase text-[#7A4A10] border-b border-[#D4A017]/20 bg-[#FBF6EC]">
                        <th class="text-left p-4">Judul</th>
                        <th class="text-left p-4">Penjual</th>
                        <th class="text-left p-4">Harga</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody id="products-table" class="divide-y divide-[#D4A017]/10"></tbody>
            </table>
        </div>
        <div id="products-pagination" class="flex justify-center gap-2 pt-4"></div>
    </div>


    <!-- ── SECTION: USERS ── -->
    <div id="section-users" class="hidden">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-extrabold font-heading">Manajemen Pengguna</h2>
            <div class="flex items-center gap-2">
                <input id="user-search" type="text" placeholder="Cari nama/email..."
                       class="text-xs px-3 py-2 rounded-lg border border-[#D4A017]/20 bg-[#FBF6EC] focus:outline-none focus:ring-2 focus:ring-[#7A4A10]/20"
                       onkeyup="if(event.key==='Enter') loadUsers(1)">
                <button onclick="resetUserFilter()" class="px-3 py-2 bg-white text-xs font-bold border border-[#D4A017]/30 text-[#7A4A10] hover:bg-[#F5E4B0] rounded-lg transition">Reset</button>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-[#D4A017]/20 shadow-sm overflow-x-auto">
            <table class="w-full text-xs min-w-[650px] md:min-w-0">
                <thead>
                    <tr class="text-[10px] font-black uppercase text-[#7A4A10] border-b border-[#D4A017]/20 bg-[#FBF6EC]">
                        <th class="text-left p-4">Nama</th>
                        <th class="text-left p-4">Email</th>
                        <th class="text-left p-4">Fakultas</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody id="users-table" class="divide-y divide-[#D4A017]/10"></tbody>
            </table>
        </div>
        <div id="users-pagination" class="flex justify-center gap-2 pt-4"></div>
    </div>


</div>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    const API_BASE = '/api/v1/admin';

    // ── Client-Side Admin Guard ─────────────────────────────
    (function() {
        const userJson = localStorage.getItem('preloved_user');
        if (!userJson) {
            window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.pathname);
            return;
        }
        const user = JSON.parse(userJson);
        if (user.role !== 'admin') {
            window.location.href = "{{ route('home') }}";
        }
    })();

    // ── Helpers ─────────────────────────────────────────────

    function authHeaders() {
        const token = localStorage.getItem('preloved_token');
        return {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        };
    }

    async function apiFetch(url, options = {}) {
        const res = await fetch(url, {
            ...options,
            headers: { ...authHeaders(), ...(options.headers || {}) },
        });
        if (res.status === 401 || res.status === 403) {
            window.showToast('Sesi habis atau akses ditolak.', 'error');
            throw new Error('Unauthorized');
        }
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            throw new Error(err.message || 'Terjadi kesalahan.');
        }
        return res.json();
    }

    function formatRupiah(num) {
        return 'Rp' + Number(num || 0).toLocaleString('id-ID');
    }

    function formatDate(iso) {
        return new Date(iso).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function formatTime(iso) {
        return new Date(iso).toLocaleString('id-ID', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' });
    }

    function initials(name) {
        if (!name) return '?';
        return name.split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase();
    }

    function avatarBg(name) {
        const colors = ['#7A4A10','#D4A017','#2E7D32','#1565C0','#6A1B9A','#C62828'];
        let hash = 0;
        for (let c of (name || '')) hash = c.charCodeAt(0) + ((hash << 5) - hash);
        return colors[Math.abs(hash) % colors.length];
    }

    function renderPagination(containerId, meta, loadFn) {
        const el = document.getElementById(containerId);
        if (!meta || meta.last_page <= 1) { el.innerHTML = ''; return; }
        let html = '';
        for (let p = 1; p <= meta.last_page; p++) {
            html += `<button onclick="${loadFn}(${p})"
                class="px-3 py-1 text-[10px] font-bold rounded-lg border transition ${p === meta.current_page
                    ? 'bg-[#7A4A10] text-[#FBF6EC] border-[#7A4A10]'
                    : 'bg-white border-[#D4A017]/30 text-[#2E1A06] hover:bg-[#F5E4B0]'}">${p}</button>`;
        }
        el.innerHTML = html;
    }

    window.showToast = function(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-lg border text-sm font-semibold transition-all duration-300 transform translate-y-10 opacity-0 pointer-events-auto max-w-sm`;
        if (type === 'success') toast.className += ' bg-emerald-50 text-emerald-800 border-emerald-100', toast.innerHTML = `<span>✓</span><span>${message}</span>`;
        else if (type === 'error') toast.className += ' bg-rose-50 text-rose-800 border-rose-100', toast.innerHTML = `<span>✕</span><span>${message}</span>`;
        else toast.className += ' bg-amber-50 text-amber-800 border-amber-100', toast.innerHTML = `<span>ℹ</span><span>${message}</span>`;
        container.appendChild(toast);
        setTimeout(() => toast.classList.remove('translate-y-10', 'opacity-0'), 10);
        setTimeout(() => { toast.classList.add('translate-y-10', 'opacity-0'); setTimeout(() => toast.remove(), 300); }, 3500);
    };

    // ── Admin Dropdowns ──────────────────────────────────────
    function toggleAdminNotifDropdown() {
        const dropdown = document.getElementById('admin-notif-dropdown');
        const profileDropdown = document.getElementById('admin-profile-dropdown');
        if (profileDropdown) profileDropdown.classList.add('hidden');
        if (dropdown) {
            const isOpen = !dropdown.classList.contains('hidden');
            dropdown.classList.toggle('hidden');
            if (!isOpen) {
                loadAdminNotifications();
            }
        }
    }

    function toggleAdminProfileDropdown() {
        const dropdown = document.getElementById('admin-profile-dropdown');
        const notifDropdown = document.getElementById('admin-notif-dropdown');
        if (notifDropdown) notifDropdown.classList.add('hidden');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    function toggleAdminMobileMenu() {
        const menu = document.getElementById('admin-mobile-menu');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }

    // Close when clicking outside
    document.addEventListener('click', function(e) {
        const notifContainer = document.getElementById('admin-notif-dropdown')?.parentElement;
        const profileContainer = document.getElementById('admin-profile-dropdown')?.parentElement;
        
        if (notifContainer && !notifContainer.contains(e.target)) {
            document.getElementById('admin-notif-dropdown')?.classList.add('hidden');
        }
        if (profileContainer && !profileContainer.contains(e.target)) {
            document.getElementById('admin-profile-dropdown')?.classList.add('hidden');
        }
    });

    async function loadAdminNotifications() {
        const token = localStorage.getItem('preloved_token');
        const container = document.getElementById('admin-notif-items');
        if (!token || !container) return;

        try {
            const res = await fetch('/api/v1/notifications', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            if (!res.ok) {
                container.innerHTML = `<div class="p-5 text-center text-[#7A4A10]">Gagal memuat notifikasi.</div>`;
                return;
            }

            const json = await res.json();
            const notifications = json.data || [];
            
            if (notifications.length === 0) {
                container.innerHTML = `<div class="p-5 text-center text-[#7A4A10]">Tidak ada notifikasi baru.</div>`;
                return;
            }

            container.innerHTML = notifications.slice(0, 10).map(notif => {
                const data = notif.data || {};
                const isUnread = !notif.read_at;
                const timeStr = formatDate(notif.created_at);
                const bg = isUnread ? 'bg-[#FAF4C8]/30 font-semibold' : '';

                return `
                    <div class="p-3 hover:bg-[#F5E4B0]/20 transition border-b border-[#D4A017]/10 ${bg}">
                        <div class="flex justify-between items-start gap-2">
                            <div class="flex-1 min-w-0">
                                <p class="text-[#2E1A06] text-[11px] font-bold truncate">${data.title || 'Notifikasi'}</p>
                                <p class="text-[#7A4A10] text-[10px] mt-0.5 leading-relaxed">${data.message || ''}</p>
                                <span class="text-[9px] text-[#7A4A10]/60 block mt-1">${timeStr}</span>
                            </div>
                            ${isUnread ? `<button onclick="markAdminNotificationRead('${notif.id}')" class="text-[9px] font-bold text-[#7A4A10] hover:text-[#2E1A06] shrink-0">✓ Baca</button>` : ''}
                        </div>
                    </div>
                `;
            }).join('');
        } catch (e) {
            container.innerHTML = `<div class="p-5 text-center text-[#7A4A10]">Gagal memuat notifikasi.</div>`;
        }
    }

    async function markAdminNotificationRead(id) {
        const token = localStorage.getItem('preloved_token');
        if (!token) return;
        try {
            await fetch(`/api/v1/notifications/${id}/read`, {
                method: 'PATCH',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            loadAdminNotifications();
            loadStats();
        } catch (e) {
            console.error(e);
        }
    }

    async function markAllAdminNotificationsRead() {
        const token = localStorage.getItem('preloved_token');
        if (!token) return;
        try {
            await fetch('/api/v1/notifications/read-all', {
                method: 'PATCH',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            loadAdminNotifications();
            loadStats();
        } catch (e) {
            console.error(e);
        }
    }

    // ── Navigation ───────────────────────────────────────────

    const sections = ['dashboard', 'users', 'listings', 'reports'];

    function showSection(name) {
        sections.forEach(s => {
            const secEl = document.getElementById(`section-${s}`);
            if (secEl) secEl.classList.toggle('hidden', s !== name);
            const nav = document.getElementById(`nav-${s}`);
            if (nav) {
                nav.classList.toggle('bg-[#F5E4B0]', s === name);
                nav.classList.toggle('font-bold', s === name);
                nav.classList.toggle('border-b-2', s === name);
                nav.classList.toggle('border-[#7A4A10]', s === name);
                nav.classList.toggle('text-[#2E1A06]', s === name);
            }
            const mNav = document.getElementById(`mobile-nav-${s}`);
            if (mNav) {
                mNav.classList.toggle('bg-[#FAF4C8]', s === name);
                mNav.classList.toggle('font-extrabold', s === name);
                mNav.classList.toggle('text-[#7A4A10]', s === name);
            }
        });

        // Lazy load section data
        if (name === 'listings') loadProducts(1);
        if (name === 'users') loadUsers(1);
        if (name === 'reports') loadAllReports(1);
    }

    // ── Init ─────────────────────────────────────────────────

    async function loadAdminDashboard() {
        // Set admin name from localStorage
        const user = JSON.parse(localStorage.getItem('preloved_user') || '{}');
        if (user.name) {
            document.getElementById('admin-name').textContent = user.name;
            const init = initials(user.name);
            document.getElementById('admin-avatar-placeholder').textContent = init;
        }

        await Promise.all([
            loadStats(),
            loadRecentReports(),
            loadAuditLogs(),
            loadActivityChart(),
        ]);
    }

    // ── Stats ────────────────────────────────────────────────

    async function loadStats() {
        try {
            const stats = await apiFetch(`${API_BASE}/stats`);

            document.getElementById('stat-users-total').textContent = stats.users_total.toLocaleString('id-ID');
            document.getElementById('stat-listings-active').textContent = stats.listings_active.toLocaleString('id-ID');
            document.getElementById('stat-reports-pending').textContent = stats.reports_pending;
            document.getElementById('stat-transactions-total').textContent = stats.transactions_total.toLocaleString('id-ID');

            // Ubah urgensi laporan
            const badge = document.getElementById('reports-urgency');
            if (stats.reports_pending > 10) {
                badge.textContent = '! High'; badge.className = 'text-[10px] font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-100';
            } else if (stats.reports_pending > 0) {
                badge.textContent = '! Medium'; badge.className = 'text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-100';
            } else {
                badge.textContent = '✓ Clear'; badge.className = 'text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full';
            }

            // Notif badge
            const notifBadge = document.getElementById('notif-badge');
            if (notifBadge) {
                if (stats.reports_pending > 0) {
                    notifBadge.classList.remove('hidden');
                } else {
                    notifBadge.classList.add('hidden');
                }
            }
        } catch (e) {
            console.error('Gagal memuat statistik:', e);
        }
    }

    // ── Activity Chart ───────────────────────────────────────

    async function loadActivityChart() {
        // Generate label 7 hari terakhir
        const days = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
        const labels = [];
        for (let i = 6; i >= 0; i--) {
            const d = new Date(); d.setDate(d.getDate() - i);
            labels.push(days[d.getDay()]);
        }

        // Data dummy untuk chart (karena backend belum ada endpoint statistik per-hari)
        // Ganti dengan fetch ke endpoint real kalau nanti tersedia
        const listingData = [4, 7, 5, 9, 6, 3, 5];
        const userDataArr  = [2, 4, 3, 6, 4, 2, 3];

        const ctx = document.getElementById('activityChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Listing Baru',
                        data: listingData,
                        backgroundColor: '#7A4A10',
                        borderRadius: 6,
                        barPercentage: 0.5,
                    },
                    {
                        label: 'Pengguna Baru',
                        data: userDataArr,
                        backgroundColor: '#D4A017',
                        borderRadius: 6,
                        barPercentage: 0.5,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                    y: { grid: { color: '#D4A01720' }, ticks: { font: { size: 10 }, precision: 0 } }
                }
            }
        });
    }

    // ── Report Status Badge Standardizer ──────────────────
    function getStatusBadgeHtml(status) {
        let label = status;
        let css = '';
        if (status === 'Pending') {
            label = 'Menunggu';
            css = 'bg-amber-50 text-amber-700 border-amber-200';
        } else if (status === 'Resolved') {
            label = 'Selesai';
            css = 'bg-emerald-50 text-emerald-700 border-emerald-200';
        } else if (status === 'Rejected') {
            label = 'Rejected';
            css = 'bg-rose-50 text-rose-700 border-rose-200';
        } else if (status === 'Suspended') {
            label = 'Suspended';
            css = 'bg-rose-100 text-rose-800 border-rose-300';
        } else {
            css = 'bg-[#F5E4B0] text-[#7A4A10] border-[#D4A017]/30';
        }
        return `<span class="px-2 py-0.5 rounded-full border text-[10px] font-bold ${css}">${label}</span>`;
    }

    // ── Recent Reports (dashboard table) ────────────────────

    async function loadRecentReports() {
        try {
            const data = await apiFetch(`${API_BASE}/reports?per_page=5`);
            const tbody = document.getElementById('reports-table-body');
            tbody.innerHTML = '';

            if (data.data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="py-8 text-center text-[#7A4A10] text-xs">Tidak ada laporan.</td></tr>`;
                return;
            }

            data.data.forEach(r => {
                const bg = avatarBg(r.reporter?.name);
                const init = initials(r.reporter?.name);

                tbody.innerHTML += `
                    <tr class="hover:bg-[#FBF6EC] transition">
                        <td class="p-3 pl-2">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-black text-white flex-shrink-0" style="background:${bg}">${init}</div>
                                <span class="font-semibold">${r.reporter?.name ?? '-'}</span>
                            </div>
                        </td>
                        <td class="p-3">${r.category}</td>
                        <td class="p-3 text-[#7A4A10]">${formatDate(r.created_at)}</td>
                        <td class="p-3">
                            ${getStatusBadgeHtml(r.status)}
                        </td>
                        <td class="p-3">
                            ${r.status === 'Pending' ? `
                                <div class="flex gap-1">
                                    <button onclick="rejectReport(${r.id})" title="Tolak" class="px-2 py-1 text-[10px] font-bold bg-[#FAF4C8] border border-[#D4A017]/30 text-[#7A4A10] rounded-lg hover:bg-[#F5E4B0] transition">Tolak</button>
                                    <button onclick="resolveReport(${r.id})" title="Blokir" class="px-2 py-1 text-[10px] font-bold bg-[#7A4A10] text-white rounded-lg hover:bg-[#5f390c] transition">Blokir</button>
                                </div>
                            ` : getStatusBadgeHtml(r.status)}
                        </td>
                    </tr>
                `;
            });
        } catch (e) {
            console.error('Gagal memuat laporan terbaru:', e);
        }
    }

    // ── Reports Full Page ────────────────────────────────────

    async function loadAllReports(page = 1) {
        try {
            const data = await apiFetch(`${API_BASE}/reports?page=${page}`);
            const listDiv = document.getElementById('reports-list');
            listDiv.innerHTML = '';

            if (data.data.length === 0) {
                listDiv.innerHTML = `<div class="text-center py-10 text-[#7A4A10] text-sm">Tidak ada laporan.</div>`;
                return;
            }

            data.data.forEach(r => {
                const card = document.createElement('div');
                card.className = "bg-white p-5 rounded-2xl border border-[#D4A017]/20 shadow-sm space-y-4";

                card.innerHTML = `
                    <div class="flex justify-between items-baseline">
                        <span class="text-[10px] font-black uppercase tracking-wider text-rose-700 bg-rose-50 border border-rose-100 px-2.5 py-0.5 rounded-full">🚨 ${r.category}</span>
                        ${getStatusBadgeHtml(r.status)}
                    </div>
                    <p class="text-xs leading-relaxed">"${r.reason}"</p>
                    <div class="grid grid-cols-2 gap-3 text-[10px] text-[#7A4A10] font-bold uppercase border-t border-[#D4A017]/10 pt-3">
                        <div>📦 Produk: <span class="text-[#2E1A06]">${r.reported_product?.title ?? '(dihapus)'}</span></div>
                        <div>👤 Dilaporkan: <span class="text-[#2E1A06]">${r.reported_user?.name ?? '-'}</span></div>
                        <div>📣 Pelapor: <span class="text-[#2E1A06]">${r.reporter?.name ?? '-'}</span></div>
                        <div>🗓 Tanggal: <span class="text-[#2E1A06]">${formatDate(r.created_at)}</span></div>
                    </div>
                    ${r.status === 'Pending' ? `
                        <div class="flex gap-2 justify-end border-t border-[#D4A017]/10 pt-3">
                            <button onclick="rejectReport(${r.id})" class="px-3.5 py-1.5 bg-[#FAF4C8] hover:bg-[#F5E4B0] border border-[#D4A017]/30 text-[#7A4A10] text-[10px] font-bold rounded-lg transition">Tolak Laporan</button>
                            <button onclick="resolveReport(${r.id})" class="px-3.5 py-1.5 bg-[#7A4A10] hover:bg-[#5f390c] text-white text-[10px] font-bold rounded-lg transition">Blokir & Hapus Produk</button>
                        </div>
                    ` : ''}
                `;
                listDiv.appendChild(card);
            });

            renderPagination('reports-pagination', data, 'loadAllReports');
        } catch (e) {
            console.error('Gagal memuat semua laporan:', e);
        }
    }

    async function resolveReport(reportId) {
        try {
            await apiFetch(`${API_BASE}/reports/${reportId}/resolve`, { method: 'PATCH' });
            window.showToast('Produk diblokir & laporan diselesaikan!');
            await Promise.all([loadStats(), loadRecentReports(), loadAuditLogs(), loadAllReports(1)]);
        } catch (e) { window.showToast(e.message, 'error'); }
    }

    async function rejectReport(reportId) {
        try {
            await apiFetch(`${API_BASE}/reports/${reportId}/reject`, { method: 'PATCH' });
            window.showToast('Laporan ditolak.');
            await Promise.all([loadStats(), loadRecentReports(), loadAuditLogs(), loadAllReports(1)]);
        } catch (e) { window.showToast(e.message, 'error'); }
    }

    // ── Audit Logs ───────────────────────────────────────────

    async function loadAuditLogs() {
        try {
            const data = await apiFetch(`${API_BASE}/audit-logs?per_page=10`);
            const el = document.getElementById('audit-logs-list');
            el.innerHTML = '';

            if (data.data.length === 0) {
                el.innerHTML = `<p class="text-xs text-[#7A4A10]">Belum ada log.</p>`;
                return;
            }

            data.data.forEach((log, idx) => {
                const row = document.createElement('div');
                row.className = `pt-3 text-xs ${idx === 0 ? '' : ''}`;
                row.innerHTML = `
                    <div class="flex justify-between items-baseline">
                        <span class="text-[10px] font-black uppercase text-[#7A4A10]">${log.action}</span>
                        <span class="text-[9px] text-[#7A4A10]/70">${formatTime(log.created_at)}</span>
                    </div>
                    <p class="text-[10px] text-[#2E1A06]/70 mt-0.5">${log.keterangan}</p>
                `;
                el.appendChild(row);
            });
        } catch (e) {
            console.error('Gagal memuat audit log:', e);
        }
    }

    // ── Listings ─────────────────────────────────────────────

    async function loadProducts(page = 1) {
        try {
            const search = document.getElementById('product-search').value;
            const data = await apiFetch(`${API_BASE}/products?page=${page}&search=${encodeURIComponent(search)}`);
            const tbody = document.getElementById('products-table');
            tbody.innerHTML = '';

            if (data.data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="py-8 text-center text-[#7A4A10] text-xs">Tidak ada listing.</td></tr>`;
                return;
            }

            data.data.forEach(p => {
                tbody.innerHTML += `
                    <tr class="hover:bg-[#FBF6EC] transition">
                        <td class="p-4 font-semibold">${p.title}</td>
                        <td class="p-4 text-[#7A4A10]">${p.seller?.name ?? '-'}</td>
                        <td class="p-4">${formatRupiah(p.price)}</td>
                        <td class="p-4">
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full border ${p.status === 'Available' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200'}">${p.status}</span>
                        </td>
                        <td class="p-4">
                            <button onclick="deleteProduct(${p.id}, '${p.title.replace(/'/g, "\\'")}')"
                                class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-700 text-[10px] font-bold rounded-lg transition">
                                Hapus
                            </button>
                        </td>
                    </tr>
                `;
            });
            renderPagination('products-pagination', data, 'loadProducts');
        } catch (e) { console.error('Gagal memuat listing:', e); }
    }

    async function deleteProduct(id, title) {
        if (!confirm(`Hapus listing "${title}"? Tidak bisa dibatalkan.`)) return;
        try {
            await apiFetch(`${API_BASE}/products/${id}`, { method: 'DELETE' });
            window.showToast('Listing berhasil dihapus.');
            await Promise.all([loadStats(), loadProducts(1), loadAuditLogs()]);
        } catch (e) { window.showToast(e.message, 'error'); }
    }

    function resetProductFilter() {
        document.getElementById('product-search').value = '';
        loadProducts(1);
    }

    // ── Users ────────────────────────────────────────────────

    async function loadUsers(page = 1) {
        try {
            const search = document.getElementById('user-search').value;
            const data = await apiFetch(`${API_BASE}/users?page=${page}&search=${encodeURIComponent(search)}`);
            const tbody = document.getElementById('users-table');
            tbody.innerHTML = '';

            if (data.data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="py-8 text-center text-[#7A4A10] text-xs">Tidak ada pengguna.</td></tr>`;
                return;
            }

            data.data.forEach(u => {
                const isSuspended = u.status === 'suspended';
                const actionBtn = u.role === 'admin'
                    ? `<span class="text-[10px] text-[#7A4A10] italic">Admin</span>`
                    : isSuspended
                        ? `<button onclick="unsuspendUser(${u.id})" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-700 text-[10px] font-bold rounded-lg transition">Aktifkan</button>`
                        : `<button onclick="suspendUser(${u.id}, '${u.name.replace(/'/g, "\\'")}')" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-700 text-[10px] font-bold rounded-lg transition">Tangguhkan</button>`;

                tbody.innerHTML += `
                    <tr class="hover:bg-[#FBF6EC] transition">
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-black text-white flex-shrink-0" style="background:${avatarBg(u.name)}">${initials(u.name)}</div>
                                <span class="font-semibold">${u.name} ${isSuspended ? '<span class="text-rose-600 text-[9px] font-black ml-1">[Suspended]</span>' : ''}</span>
                            </div>
                        </td>
                        <td class="p-4 text-[#7A4A10]">${u.email}</td>
                        <td class="p-4">${u.unsoed_faculty ?? '-'}</td>
                        <td class="p-4">
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full border ${isSuspended ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200'}">${u.status}</span>
                        </td>
                        <td class="p-4">${actionBtn}</td>
                    </tr>
                `;
            });
            renderPagination('users-pagination', data, 'loadUsers');
        } catch (e) { console.error('Gagal memuat users:', e); }
    }

    async function suspendUser(id, name) {
        const reason = prompt(`Alasan menangguhkan akun "${name}":`);
        if (!reason || reason.trim().length < 5) {
            if (reason !== null) window.showToast('Alasan minimal 5 karakter.', 'error');
            return;
        }
        try {
            await apiFetch(`${API_BASE}/users/${id}/suspend`, { method: 'PATCH', body: JSON.stringify({ reason }) });
            window.showToast('Akun berhasil ditangguhkan.');
            await Promise.all([loadStats(), loadUsers(1), loadAuditLogs()]);
        } catch (e) { window.showToast(e.message, 'error'); }
    }

    async function unsuspendUser(id) {
        try {
            await apiFetch(`${API_BASE}/users/${id}/unsuspend`, { method: 'PATCH' });
            window.showToast('Akun berhasil diaktifkan kembali.');
            await Promise.all([loadStats(), loadUsers(1), loadAuditLogs()]);
        } catch (e) { window.showToast(e.message, 'error'); }
    }

    function resetUserFilter() {
        document.getElementById('user-search').value = '';
        loadUsers(1);
    }

    // ── Boot ─────────────────────────────────────────────────

    window.addEventListener('DOMContentLoaded', () => {
        loadAdminDashboard();
    });
</script>

@endsection