@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-brand-900">
    <!-- Header -->
    <div class="border-b border-brand-500/20 pb-5 mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight font-heading">Dashboard Moderasi Admin</h1>
        <p class="text-xs text-brand-600 mt-1 font-medium font-heading">Pantau laporan transaksi, verifikasi identitas mahasiswa, dan tinjau audit log aktivitas.</p>
    </div>

    <!-- Stats grid -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mb-10">
        <div class="bg-brand-100 p-5 rounded-2xl border border-brand-500/15 text-center">
            <span class="text-xl"></span>
            <h4 class="text-[10px] font-bold text-brand-600 mt-1.5 uppercase">Laporan Masuk</h4>
            <p id="stat-reports-pending" class="text-2xl font-black mt-0.5">0</p>
        </div>
        <div class="bg-brand-100 p-5 rounded-2xl border border-brand-500/15 text-center">
            <span class="text-xl"></span>
            <h4 class="text-[10px] font-bold text-brand-600 mt-1.5 uppercase">Laporan Selesai</h4>
            <p id="stat-reports-resolved" class="text-2xl font-black mt-0.5">0</p>
        </div>
        <div class="bg-brand-100 p-5 rounded-2xl border border-brand-500/15 text-center">
            <span class="text-xl"></span>
            <h4 class="text-[10px] font-bold text-brand-600 mt-1.5 uppercase">Verifikasi Tertunda</h4>
            <p id="stat-verify-pending" class="text-2xl font-black mt-0.5">0</p>
        </div>
        <div class="bg-brand-100 p-5 rounded-2xl border border-brand-500/15 text-center">
            <span class="text-xl"></span>
            <h4 class="text-[10px] font-bold text-brand-600 mt-1.5 uppercase">Total Audit Log</h4>
            <p id="stat-logs" class="text-2xl font-black mt-0.5">0</p>
        </div>
    </div>

    <!-- Reports Queue & Audit Logs Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left 2 Cols: Reports Queue -->
        <div class="lg:col-span-2 bg-brand-100 p-6 rounded-3xl border border-brand-500/25 shadow-xl space-y-6">
            <h3 class="text-lg font-extrabold font-heading">Antrean Laporan Pengaduan</h3>

            <div id="reports-list" class="space-y-4">
                <!-- Dynamically populated via JS -->
            </div>
        </div>

        <!-- Right 1 Col: Audit Logs (ERD Compliance) -->
        <div class="bg-brand-100 p-6 rounded-3xl border border-brand-500/25 shadow-xl flex flex-col h-fit">
            <h3 class="text-lg font-extrabold mb-6 font-heading">Log Aktivitas (Audit Logs)</h3>

            <div id="audit-logs-list" class="space-y-4 divide-y divide-brand-500/10 max-h-[50vh] overflow-y-auto pr-2">
                <!-- Dynamically populated via JS -->
            </div>
        </div>
    </div>

    <!-- Tambahan Stat: Transaksi & Listing -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 my-10">
        <div class="bg-brand-100 p-5 rounded-2xl border border-brand-500/15 text-center">
            <span class="text-xl"></span>
            <h4 class="text-[10px] font-bold text-brand-600 mt-1.5 uppercase">Listing Aktif</h4>
            <p id="stat-listings-active" class="text-2xl font-black mt-0.5">0</p>
        </div>
        <div class="bg-brand-100 p-5 rounded-2xl border border-brand-500/15 text-center">
            <span class="text-xl"></span>
            <h4 class="text-[10px] font-bold text-brand-600 mt-1.5 uppercase">Total Transaksi</h4>
            <p id="stat-transactions-total" class="text-2xl font-black mt-0.5">0</p>
        </div>
        <div class="bg-brand-100 p-5 rounded-2xl border border-brand-500/15 text-center">
            <span class="text-xl"></span>
            <h4 class="text-[10px] font-bold text-brand-600 mt-1.5 uppercase">Total GMV</h4>
            <p id="stat-transactions-gmv" class="text-2xl font-black mt-0.5">Rp0</p>
        </div>
    </div>

    <!-- Listings Management -->
    <div class="bg-brand-100 p-6 rounded-3xl border border-brand-500/25 shadow-xl space-y-6 mb-10">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-extrabold font-heading">Manajemen Listing Produk</h3>
            <input id="product-search" type="text" placeholder="Cari judul produk..."
                   class="text-xs px-3 py-2 rounded-lg border border-brand-500/20 bg-brand-50 focus:outline-none focus:ring-2 focus:ring-brand-500/30"
                   onkeyup="if(event.key==='Enter') loadProducts(1)">
        </div>
        <div id="products-list" class="space-y-3"></div>
        <div id="products-pagination" class="flex justify-center gap-2 pt-2"></div>
    </div>

    <!-- Users Management -->
    <div class="bg-brand-100 p-6 rounded-3xl border border-brand-500/25 shadow-xl space-y-6 mb-10">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-extrabold font-heading">Manajemen Pengguna</h3>
            <input id="user-search" type="text" placeholder="Cari nama/email..."
                   class="text-xs px-3 py-2 rounded-lg border border-brand-500/20 bg-brand-50 focus:outline-none focus:ring-2 focus:ring-brand-500/30"
                   onkeyup="if(event.key==='Enter') loadUsers(1)">
        </div>
        <div id="users-list" class="space-y-3"></div>
        <div id="users-pagination" class="flex justify-center gap-2 pt-2"></div>
    </div>

    <!-- Transactions -->
    <div class="bg-brand-100 p-6 rounded-3xl border border-brand-500/25 shadow-xl space-y-6 mb-10">
        <h3 class="text-lg font-extrabold font-heading">Riwayat Transaksi</h3>
        <div id="transactions-list" class="space-y-3"></div>
        <div id="transactions-pagination" class="flex justify-center gap-2 pt-2"></div>
    </div>
</div>

<script>
    const API_BASE = '/api/v1/admin';

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
            window.showToast('Sesi habis atau akses ditolak. Silakan login ulang.', 'error');
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

    function formatTime(iso) {
        return new Date(iso).toLocaleString('id-ID', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' });
    }

    function renderPagination(containerId, meta, loadFn) {
        const el = document.getElementById(containerId);
        if (!meta || meta.last_page <= 1) { el.innerHTML = ''; return; }

        let html = '';
        for (let p = 1; p <= meta.last_page; p++) {
            html += `<button onclick="${loadFn}(${p})"
                class="px-3 py-1 text-[10px] font-bold rounded-lg border ${p === meta.current_page ? 'bg-[#7A4A10] text-brand-50 border-[#7A4A10]' : 'bg-brand-50 border-brand-500/20 text-brand-900'}">
                ${p}
            </button>`;
        }
        el.innerHTML = html;
    }

    // ── Dashboard Init ─────────────────────────────────────

    async function loadAdminDashboard() {
        await Promise.all([
            loadStats(),
            loadReports(),
            loadAuditLogs(),
            loadProducts(1),
            loadUsers(1),
            loadTransactions(1),
        ]);
    }

    async function loadStats() {
        try {
            const stats = await apiFetch(`${API_BASE}/stats`);
            document.getElementById('stat-reports-pending').textContent = stats.reports_pending;
            document.getElementById('stat-reports-resolved').textContent = stats.reports_resolved;
            document.getElementById('stat-verify-pending').textContent = stats.users_suspended;
            document.getElementById('stat-logs').textContent = stats.audit_logs_total;
            document.getElementById('stat-listings-active').textContent = stats.listings_active;
            document.getElementById('stat-transactions-total').textContent = stats.transactions_total;
            document.getElementById('stat-transactions-gmv').textContent = formatRupiah(stats.transactions_gmv);
        } catch (e) {
            console.error('Gagal memuat statistik:', e);
        }
    }

    // ── Reports ─────────────────────────────────────────────

    let reports = [];

    async function loadReports() {
        try {
            const data = await apiFetch(`${API_BASE}/reports?status=Pending`);
            reports = data.data;
            renderReports();
        } catch (e) {
            console.error('Gagal memuat laporan:', e);
        }
    }

    function renderReports() {
        const listDiv = document.getElementById('reports-list');
        listDiv.innerHTML = '';

        if (reports.length === 0) {
            listDiv.innerHTML = `<div class="text-center py-10 text-brand-600 font-medium">Tidak ada laporan pengaduan masuk.</div>`;
            return;
        }

        reports.forEach((r) => {
            const card = document.createElement('div');
            card.className = "bg-brand-50 p-5 rounded-2xl border border-brand-500/15 shadow-sm space-y-4";

            card.innerHTML = `
                <div class="flex justify-between items-baseline">
                    <span class="text-[10px] font-black uppercase tracking-wider text-rose-700 bg-rose-50 border border-rose-100 px-2.5 py-0.5 rounded-full">🚨 Kategori: ${r.category}</span>
                    <span class="text-[10px] font-bold border rounded-full px-2 py-0.5 bg-[#7A4A10] text-[#FBF6EC] border-[#7A4A10]">${r.status}</span>
                </div>
                <div class="space-y-2 text-xs">
                    <p class="leading-relaxed">"${r.reason}"</p>
                    <div class="grid grid-cols-2 gap-3 pt-2 text-[10px] text-brand-600 font-bold uppercase border-t border-brand-500/10">
                        <div>📦 Produk: <span class="text-brand-900">${r.reported_product?.title ?? '(dihapus)'}</span></div>
                        <div>👤 Dilaporkan: <span class="text-brand-900">${r.reported_user?.name ?? '-'}</span></div>
                        <div>📣 Pelapor: <span class="text-[#2E1A06]">${r.reporter?.name ?? '-'}</span></div>
                    </div>
                </div>
                <div class="pt-3 flex gap-2 border-t border-brand-500/10 justify-end">
                    <button onclick="rejectReport(${r.id})" class="px-3.5 py-1.5 bg-[#FAF4C8] hover:bg-[#FBF6EC] border border-[#D4A017]/30 text-[#7A4A10] text-[10px] font-bold rounded-lg transition">
                        Tolak Laporan
                    </button>
                    <button onclick="resolveReport(${r.id})" class="px-3.5 py-1.5 bg-[#7A4A10] hover:bg-[#5f390c] text-brand-50 text-[10px] font-bold rounded-lg transition">
                        Blokir & Hapus Produk
                    </button>
                </div>
            `;
            listDiv.appendChild(card);
        });
    }

    async function resolveReport(reportId) {
        try {
            await apiFetch(`${API_BASE}/reports/${reportId}/resolve`, { method: 'PATCH' });
            window.showToast('Produk diblokir & laporan diselesaikan!');
            await Promise.all([loadStats(), loadReports(), loadAuditLogs()]);
        } catch (e) {
            window.showToast(e.message, 'error');
        }
    }

    async function rejectReport(reportId) {
        try {
            await apiFetch(`${API_BASE}/reports/${reportId}/reject`, { method: 'PATCH' });
            window.showToast('Laporan ditolak oleh admin.');
            await Promise.all([loadStats(), loadReports(), loadAuditLogs()]);
        } catch (e) {
            window.showToast(e.message, 'error');
        }
    }

    // ── Audit Logs ──────────────────────────────────────────

    async function loadAuditLogs() {
        try {
            const data = await apiFetch(`${API_BASE}/audit-logs`);
            renderAuditLogs(data.data);
        } catch (e) {
            console.error('Gagal memuat audit log:', e);
        }
    }

    function renderAuditLogs(logs) {
        const listDiv = document.getElementById('audit-logs-list');
        listDiv.innerHTML = '';

        logs.forEach((log, idx) => {
            const row = document.createElement('div');
            row.className = `py-3 text-xs ${idx > 0 ? 'border-t border-brand-500/10' : ''}`;
            row.innerHTML = `
                <div class="flex justify-between items-baseline font-bold">
                    <span class="text-[#7A4A10] font-heading text-[10px] uppercase">${log.action}</span>
                    <span class="text-[9px] text-brand-600">${formatTime(log.created_at)}</span>
                </div>
                <p class="text-[10px] text-brand-900/75 mt-1 font-light">${log.keterangan}</p>
                <p class="text-[9px] text-brand-600 mt-0.5">oleh ${log.admin?.name ?? 'Admin'}</p>
            `;
            listDiv.appendChild(row);
        });
    }

    // ── Listings (Products) ─────────────────────────────────

    async function loadProducts(page = 1) {
        try {
            const search = document.getElementById('product-search').value;
            const data = await apiFetch(`${API_BASE}/products?page=${page}&search=${encodeURIComponent(search)}`);
            renderProducts(data.data);
            renderPagination('products-pagination', data, 'loadProducts');
        } catch (e) {
            console.error('Gagal memuat listing:', e);
        }
    }

    function renderProducts(products) {
        const listDiv = document.getElementById('products-list');
        listDiv.innerHTML = '';

        if (products.length === 0) {
            listDiv.innerHTML = `<div class="text-center py-6 text-brand-600 text-xs">Tidak ada listing ditemukan.</div>`;
            return;
        }

        products.forEach((p) => {
            const row = document.createElement('div');
            row.className = "flex items-center justify-between bg-brand-50 p-4 rounded-xl border border-brand-500/10 text-xs";
            row.innerHTML = `
                <div>
                    <p class="font-bold">${p.title}</p>
                    <p class="text-[10px] text-brand-600">${formatRupiah(p.price)} • ${p.seller?.name ?? '-'} • <span class="uppercase font-bold">${p.status}</span></p>
                </div>
                <button onclick="deleteProduct(${p.id}, '${p.title.replace(/'/g, "\\'")}')"
                    class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-700 text-[10px] font-bold rounded-lg transition">
                    Hapus Listing
                </button>
            `;
            listDiv.appendChild(row);
        });
    }

    async function deleteProduct(id, title) {
        if (!confirm(`Hapus listing "${title}"? Tindakan ini tidak bisa dibatalkan.`)) return;
        try {
            await apiFetch(`${API_BASE}/products/${id}`, { method: 'DELETE' });
            window.showToast('Listing berhasil dihapus.');
            await Promise.all([loadStats(), loadProducts(1), loadAuditLogs()]);
        } catch (e) {
            window.showToast(e.message, 'error');
        }
    }

    // ── Users ───────────────────────────────────────────────

    async function loadUsers(page = 1) {
        try {
            const search = document.getElementById('user-search').value;
            const data = await apiFetch(`${API_BASE}/users?page=${page}&search=${encodeURIComponent(search)}`);
            renderUsers(data.data);
            renderPagination('users-pagination', data, 'loadUsers');
        } catch (e) {
            console.error('Gagal memuat pengguna:', e);
        }
    }

    function renderUsers(users) {
        const listDiv = document.getElementById('users-list');
        listDiv.innerHTML = '';

        if (users.length === 0) {
            listDiv.innerHTML = `<div class="text-center py-6 text-brand-600 text-xs">Tidak ada pengguna ditemukan.</div>`;
            return;
        }

        users.forEach((u) => {
            const row = document.createElement('div');
            row.className = "flex items-center justify-between bg-brand-50 p-4 rounded-xl border border-brand-500/10 text-xs";

            const isSuspended = u.status === 'suspended';
            const actionBtn = u.role === 'admin'
                ? `<span class="text-[10px] text-brand-600 italic">Admin</span>`
                : isSuspended
                    ? `<button onclick="unsuspendUser(${u.id})" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-700 text-[10px] font-bold rounded-lg transition">Aktifkan Kembali</button>`
                    : `<button onclick="suspendUser(${u.id}, '${u.name.replace(/'/g, "\\'")}')" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-700 text-[10px] font-bold rounded-lg transition">Tangguhkan</button>`;

            row.innerHTML = `
                <div>
                    <p class="font-bold">${u.name} ${isSuspended ? '<span class="text-rose-600 text-[9px] font-black uppercase ml-1">[Suspended]</span>' : ''}</p>
                    <p class="text-[10px] text-brand-600">${u.email} • ${u.unsoed_faculty ?? '-'}</p>
                </div>
                ${actionBtn}
            `;
            listDiv.appendChild(row);
        });
    }

    async function suspendUser(id, name) {
        const reason = prompt(`Alasan menangguhkan akun "${name}":`);
        if (!reason || reason.trim().length < 5) {
            if (reason !== null) window.showToast('Alasan minimal 5 karakter.', 'error');
            return;
        }
        try {
            await apiFetch(`${API_BASE}/users/${id}/suspend`, {
                method: 'PATCH',
                body: JSON.stringify({ reason }),
            });
            window.showToast('Akun berhasil ditangguhkan.');
            await Promise.all([loadStats(), loadUsers(1), loadAuditLogs()]);
        } catch (e) {
            window.showToast(e.message, 'error');
        }
    }

    async function unsuspendUser(id) {
        try {
            await apiFetch(`${API_BASE}/users/${id}/unsuspend`, { method: 'PATCH' });
            window.showToast('Akun berhasil diaktifkan kembali.');
            await Promise.all([loadStats(), loadUsers(1), loadAuditLogs()]);
        } catch (e) {
            window.showToast(e.message, 'error');
        }
    }

    // ── Transactions ────────────────────────────────────────

    async function loadTransactions(page = 1) {
        try {
            const data = await apiFetch(`${API_BASE}/transactions?page=${page}`);
            renderTransactions(data.data);
            renderPagination('transactions-pagination', data, 'loadTransactions');
        } catch (e) {
            console.error('Gagal memuat transaksi:', e);
        }
    }

    function renderTransactions(transactions) {
        const listDiv = document.getElementById('transactions-list');
        listDiv.innerHTML = '';

        if (transactions.length === 0) {
            listDiv.innerHTML = `<div class="text-center py-6 text-brand-600 text-xs">Belum ada transaksi.</div>`;
            return;
        }

        transactions.forEach((t) => {
            const row = document.createElement('div');
            row.className = "flex items-center justify-between bg-brand-50 p-4 rounded-xl border border-brand-500/10 text-xs";
            row.innerHTML = `
                <div>
                    <p class="font-bold">${t.product?.title ?? '-'}</p>
                    <p class="text-[10px] text-brand-600">${t.user?.name ?? '-'} • ${formatRupiah(t.amount)} • ${formatTime(t.created_at)}</p>
                </div>
                <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full border ${t.status === 'success' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-[#FAF4C8] text-[#7A4A10] border-[#D4A017]/30'}">
                    ${t.status}
                </span>
            `;
            listDiv.appendChild(row);
        });
    }

    window.addEventListener('DOMContentLoaded', () => {
        loadAdminDashboard();
    });
</script>
@endsection