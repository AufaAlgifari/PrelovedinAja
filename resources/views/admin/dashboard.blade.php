@extends('layouts.app')

@section('content')

{{-- Override layout supaya full width tanpa padding bawaan --}}
<style>
    /* Sembunyikan navbar utama dari layouts.app kalau ada */
    body { background-color: #FBF6EC; }
</style>

<!-- Admin Navbar -->
<nav class="bg-white border-b border-[#D4A017]/20 px-6 py-3 flex items-center justify-between sticky top-0 z-50 shadow-sm">
    <div class="flex items-center gap-8">
        <span class="text-lg font-extrabold text-[#2E1A06] font-heading tracking-tight">Preloved.in</span>
        <div class="hidden md:flex items-center gap-1 text-xs font-semibold text-[#7A4A10]">
            <a href="#" onclick="showSection('dashboard')" id="nav-dashboard" class="px-3 py-1.5 rounded-lg bg-[#F5E4B0] text-[#2E1A06] font-bold border-b-2 border-[#7A4A10]">Dashboard</a>
            <a href="#" onclick="showSection('users')" id="nav-users" class="px-3 py-1.5 rounded-lg hover:bg-[#F5E4B0] transition">Users</a>
            <a href="#" onclick="showSection('listings')" id="nav-listings" class="px-3 py-1.5 rounded-lg hover:bg-[#F5E4B0] transition">Listings</a>
            <a href="#" onclick="showSection('reports')" id="nav-reports" class="px-3 py-1.5 rounded-lg hover:bg-[#F5E4B0] transition">Reports</a>
            <a href="#" onclick="showSection('transactions')" id="nav-transactions" class="px-3 py-1.5 rounded-lg hover:bg-[#F5E4B0] transition">Transactions</a>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <button class="relative p-2 rounded-full hover:bg-[#F5E4B0] transition">
            <svg class="w-5 h-5 text-[#7A4A10]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span id="notif-badge" class="hidden absolute top-1 right-1 w-2 h-2 bg-rose-500 rounded-full"></span>
        </button>
        <div class="flex items-center gap-2 bg-[#F5E4B0] px-3 py-1.5 rounded-full border border-[#D4A017]/30">
            <div class="w-6 h-6 rounded-full bg-[#7A4A10] flex items-center justify-center text-[#FBF6EC] text-[10px] font-black">A</div>
            <span id="admin-name" class="text-xs font-bold text-[#2E1A06]">Admin</span>
        </div>
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
            <table class="w-full text-xs">
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
            <input id="product-search" type="text" placeholder="Cari judul produk..."
                   class="text-xs px-3 py-2 rounded-lg border border-[#D4A017]/20 bg-[#FBF6EC] focus:outline-none focus:ring-2 focus:ring-[#7A4A10]/20"
                   onkeyup="if(event.key==='Enter') loadProducts(1)">
        </div>
        <div class="bg-white rounded-2xl border border-[#D4A017]/20 shadow-sm overflow-hidden">
            <table class="w-full text-xs">
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
            <input id="user-search" type="text" placeholder="Cari nama/email..."
                   class="text-xs px-3 py-2 rounded-lg border border-[#D4A017]/20 bg-[#FBF6EC] focus:outline-none focus:ring-2 focus:ring-[#7A4A10]/20"
                   onkeyup="if(event.key==='Enter') loadUsers(1)">
        </div>
        <div class="bg-white rounded-2xl border border-[#D4A017]/20 shadow-sm overflow-hidden">
            <table class="w-full text-xs">
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


    <!-- ── SECTION: TRANSACTIONS ── -->
    <div id="section-transactions" class="hidden">
        <div class="mb-6">
            <h2 class="text-xl font-extrabold font-heading">Riwayat Transaksi</h2>
        </div>

        <!-- Transaction Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
            <div class="bg-white p-5 rounded-2xl border border-[#D4A017]/20 shadow-sm text-center">
                <p class="text-[10px] font-bold text-[#7A4A10] uppercase">Total Transaksi</p>
                <p id="stat-trx-total" class="text-3xl font-black mt-1">—</p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-[#D4A017]/20 shadow-sm text-center">
                <p class="text-[10px] font-bold text-[#7A4A10] uppercase">Transaksi Sukses</p>
                <p id="stat-trx-success" class="text-3xl font-black mt-1">—</p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-[#D4A017]/20 shadow-sm text-center">
                <p class="text-[10px] font-bold text-[#7A4A10] uppercase">Total GMV</p>
                <p id="stat-transactions-gmv" class="text-3xl font-black mt-1">—</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-[#D4A017]/20 shadow-sm overflow-hidden">
            <table class="w-full text-xs">
                <thead>
                    <tr class="text-[10px] font-black uppercase text-[#7A4A10] border-b border-[#D4A017]/20 bg-[#FBF6EC]">
                        <th class="text-left p-4">Produk</th>
                        <th class="text-left p-4">Pembeli</th>
                        <th class="text-left p-4">Jumlah</th>
                        <th class="text-left p-4">Tanggal</th>
                        <th class="text-left p-4">Status</th>
                    </tr>
                </thead>
                <tbody id="transactions-table" class="divide-y divide-[#D4A017]/10"></tbody>
            </table>
        </div>
        <div id="transactions-pagination" class="flex justify-center gap-2 pt-4"></div>
    </div>

</div>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    const API_BASE = '/api/v1/admin';

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

    // ── Navigation ───────────────────────────────────────────

    const sections = ['dashboard', 'users', 'listings', 'reports', 'transactions'];

    function showSection(name) {
        sections.forEach(s => {
            document.getElementById(`section-${s}`).classList.toggle('hidden', s !== name);
            const nav = document.getElementById(`nav-${s}`);
            if (nav) {
                nav.classList.toggle('bg-[#F5E4B0]', s === name);
                nav.classList.toggle('font-bold', s === name);
                nav.classList.toggle('border-b-2', s === name);
                nav.classList.toggle('border-[#7A4A10]', s === name);
                nav.classList.toggle('text-[#2E1A06]', s === name);
            }
        });

        // Lazy load section data
        if (name === 'listings') loadProducts(1);
        if (name === 'users') loadUsers(1);
        if (name === 'transactions') loadTransactions(1);
        if (name === 'reports') loadAllReports(1);
    }

    // ── Init ─────────────────────────────────────────────────

    async function loadAdminDashboard() {
        // Set admin name from localStorage
        const user = JSON.parse(localStorage.getItem('preloved_user') || '{}');
        if (user.name) document.getElementById('admin-name').textContent = user.name;

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
            if (stats.reports_pending > 0) document.getElementById('notif-badge').classList.remove('hidden');

            // Stat transaksi (untuk section transactions)
            if (document.getElementById('stat-trx-total')) document.getElementById('stat-trx-total').textContent = stats.transactions_total.toLocaleString('id-ID');
            if (document.getElementById('stat-transactions-gmv')) document.getElementById('stat-transactions-gmv').textContent = formatRupiah(stats.transactions_gmv);
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
                const statusClass = r.status === 'Resolved'
                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                    : r.status === 'Pending'
                        ? 'bg-amber-50 text-amber-700 border-amber-200'
                        : 'bg-[#F5E4B0] text-[#7A4A10] border-[#D4A017]/30';

                const statusLabel = r.status === 'Resolved' ? 'Selesai' : r.status === 'Pending' ? 'Menunggu' : r.status;
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
                            <span class="px-2 py-0.5 rounded-full border text-[10px] font-bold ${statusClass}">${statusLabel}</span>
                        </td>
                        <td class="p-3">
                            ${r.status === 'Pending' ? `
                                <div class="flex gap-1">
                                    <button onclick="rejectReport(${r.id})" title="Tolak" class="px-2 py-1 text-[10px] font-bold bg-[#FAF4C8] border border-[#D4A017]/30 text-[#7A4A10] rounded-lg hover:bg-[#F5E4B0] transition">Tolak</button>
                                    <button onclick="resolveReport(${r.id})" title="Blokir" class="px-2 py-1 text-[10px] font-bold bg-[#7A4A10] text-white rounded-lg hover:bg-[#5f390c] transition">Blokir</button>
                                </div>
                            ` : `<span class="text-[10px] text-[#7A4A10]">—</span>`}
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
                const badgeClass = r.status === 'Resolved'
                    ? 'bg-emerald-50 text-emerald-800 border-emerald-200'
                    : 'bg-[#7A4A10] text-[#FBF6EC] border-[#7A4A10]';

                card.innerHTML = `
                    <div class="flex justify-between items-baseline">
                        <span class="text-[10px] font-black uppercase tracking-wider text-rose-700 bg-rose-50 border border-rose-100 px-2.5 py-0.5 rounded-full">🚨 ${r.category}</span>
                        <span class="text-[10px] font-bold border rounded-full px-2 py-0.5 ${badgeClass}">${r.status}</span>
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

    // ── Transactions ─────────────────────────────────────────

    async function loadTransactions(page = 1) {
        try {
            const data = await apiFetch(`${API_BASE}/transactions?page=${page}`);
            const tbody = document.getElementById('transactions-table');
            tbody.innerHTML = '';

            // Load stat cards juga
            const stats = await apiFetch(`${API_BASE}/stats`);
            document.getElementById('stat-trx-total').textContent = stats.transactions_total.toLocaleString('id-ID');
            document.getElementById('stat-transactions-gmv').textContent = formatRupiah(stats.transactions_gmv);

            if (data.data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="py-8 text-center text-[#7A4A10] text-xs">Belum ada transaksi.</td></tr>`;
                return;
            }

            data.data.forEach(t => {
                tbody.innerHTML += `
                    <tr class="hover:bg-[#FBF6EC] transition">
                        <td class="p-4 font-semibold">${t.product?.title ?? '-'}</td>
                        <td class="p-4 text-[#7A4A10]">${t.user?.name ?? '-'}</td>
                        <td class="p-4">${formatRupiah(t.amount)}</td>
                        <td class="p-4 text-[#7A4A10]">${formatDate(t.created_at)}</td>
                        <td class="p-4">
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full border ${t.status === 'success' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200'}">${t.status}</span>
                        </td>
                    </tr>
                `;
            });
            renderPagination('transactions-pagination', data, 'loadTransactions');
        } catch (e) { console.error('Gagal memuat transaksi:', e); }
    }

    // ── Boot ─────────────────────────────────────────────────

    window.addEventListener('DOMContentLoaded', () => {
        loadAdminDashboard();
    });
</script>

@endsection