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
            <span class="text-xl">⚠️</span>
            <h4 class="text-[10px] font-bold text-brand-600 mt-1.5 uppercase">Laporan Masuk</h4>
            <p id="stat-reports-pending" class="text-2xl font-black mt-0.5">0</p>
        </div>
        <div class="bg-brand-100 p-5 rounded-2xl border border-brand-500/15 text-center">
            <span class="text-xl">✓</span>
            <h4 class="text-[10px] font-bold text-brand-600 mt-1.5 uppercase">Laporan Selesai</h4>
            <p id="stat-reports-resolved" class="text-2xl font-black mt-0.5">0</p>
        </div>
        <div class="bg-brand-100 p-5 rounded-2xl border border-brand-500/15 text-center">
            <span class="text-xl">👤</span>
            <h4 class="text-[10px] font-bold text-brand-600 mt-1.5 uppercase">Verifikasi Tertunda</h4>
            <p id="stat-verify-pending" class="text-2xl font-black mt-0.5">0</p>
        </div>
        <div class="bg-brand-100 p-5 rounded-2xl border border-brand-500/15 text-center">
            <span class="text-xl">📋</span>
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
</div>

<script>
    // Mock default data matching ERD schemas
    let reports = [
        {
            id: 101,
            category: 'Scam',
            reason: 'Penjual meminta transfer uang muka terlebih dahulu sebelum COD di GOR Susilo Soedarman, setelah ditransfer WA langsung diblokir.',
            status: 'Pending',
            reported_product: { id: 1, title: 'Buku Referensi Kalkulus Purcell Ed. 9' },
            reported_user: { name: 'Fadhil - FT Unsoed' },
            reporter: { name: 'Amelia FEB' }
        },
        {
            id: 102,
            category: 'Fake',
            reason: 'Buku fotokopian kasar (bukan cetakan original penerbit), sampul lecek parah padahal dipasang kondisi Like New.',
            status: 'Resolved',
            reported_product: { id: 3, title: 'Kemeja Flanel Uniqlo Hijau Hitam' },
            reported_user: { name: 'Rian - Faperta' },
            reporter: { name: 'Aufa Algifari' }
        }
    ];

    let auditLogs = [
        { id: 1, action: 'resolve_report', target_type: 'Report', target_id: 102, keterangan: 'Laporan diselesaikan oleh Admin, postingan diturunkan sementara.', created_at: '2026-06-10T08:30:00Z' },
        { id: 2, action: 'verify_user', target_type: 'User', target_id: 99, keterangan: 'Menyetujui verifikasi NIM mahasiswa H1D024001.', created_at: '2026-06-10T08:15:00Z' }
    ];

    function loadAdminDashboard() {
        // Render Stats
        document.getElementById('stat-reports-pending').textContent = reports.filter(r => r.status === 'Pending').length;
        document.getElementById('stat-reports-resolved').textContent = reports.filter(r => r.status === 'Resolved').length;
        document.getElementById('stat-verify-pending').textContent = 1;
        document.getElementById('stat-logs').textContent = auditLogs.length;

        renderReports();
        renderAuditLogs();
    }

    function renderReports() {
        const listDiv = document.getElementById('reports-list');
        listDiv.innerHTML = '';

        if(reports.length === 0) {
            listDiv.innerHTML = `
                <div class="text-center py-10 text-brand-600 font-medium">
                    Tidak ada laporan pengaduan masuk.
                </div>
            `;
            return;
        }

        reports.forEach((r, idx) => {
            const card = document.createElement('div');
            card.className = "bg-brand-50 p-5 rounded-2xl border border-brand-500/15 shadow-sm space-y-4";
            
            let badgeClass = "bg-[#7A4A10] text-[#FBF6EC] border-[#7A4A10]";
            if(r.status === 'Resolved') badgeClass = "bg-emerald-50 text-emerald-800 border-emerald-200";

            card.innerHTML = `
                <div class="flex justify-between items-baseline">
                    <span class="text-[10px] font-black uppercase tracking-wider text-rose-700 bg-rose-50 border border-rose-100 px-2.5 py-0.5 rounded-full">🚨 Kategori: ${r.category}</span>
                    <span class="text-[10px] font-bold border rounded-full px-2 py-0.5 ${badgeClass}">${r.status}</span>
                </div>
                
                <div class="space-y-2 text-xs">
                    <p class="leading-relaxed">"${r.reason}"</p>
                    <div class="grid grid-cols-2 gap-3 pt-2 text-[10px] text-brand-600 font-bold uppercase border-t border-brand-500/10">
                        <div>📦 Produk: <span class="text-brand-900">${r.reported_product.title}</span></div>
                        <div>👤 Dilaporkan: <span class="text-brand-900">${r.reported_user.name}</span></div>
                        <div>📣 Pelapor: <span class="text-[#2E1A06]">${r.reporter.name}</span></div>
                    </div>
                </div>

                ${r.status === 'Pending' ? `
                    <div class="pt-3 flex gap-2 border-t border-brand-500/10 justify-end">
                        <button onclick="rejectReport(${r.id})" class="px-3.5 py-1.5 bg-[#FAF4C8] hover:bg-[#FBF6EC] border border-[#D4A017]/30 text-[#7A4A10] text-[10px] font-bold rounded-lg transition">
                            Tolak Laporan
                        </button>
                        <button onclick="resolveReport(${r.id}, ${r.reported_product.id})" class="px-3.5 py-1.5 bg-[#7A4A10] hover:bg-[#5f390c] text-brand-50 text-[10px] font-bold rounded-lg transition">
                            Blokir & Hapus Produk
                        </button>
                    </div>
                ` : ''}
            `;

            listDiv.appendChild(card);
        });
    }

    function renderAuditLogs() {
        const listDiv = document.getElementById('audit-logs-list');
        listDiv.innerHTML = '';

        auditLogs.forEach((log, idx) => {
            const row = document.createElement('div');
            row.className = `py-3 text-xs ${idx > 0 ? 'border-t border-brand-500/10' : ''}`;
            
            const time = new Date(log.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            row.innerHTML = `
                <div class="flex justify-between items-baseline font-bold">
                    <span class="text-[#7A4A10] font-heading text-[10px] uppercase">${log.action}</span>
                    <span class="text-[9px] text-brand-600">${time}</span>
                </div>
                <p class="text-[10px] text-brand-900/75 mt-1 font-light">${log.keterangan}</p>
            `;

            listDiv.appendChild(row);
        });
    }

    function resolveReport(reportId, productId) {
        const rep = reports.find(r => r.id === reportId);
        if (rep) {
            rep.status = 'Resolved';
            
            // Add to audit logs
            auditLogs.unshift({
                id: auditLogs.length + 1,
                action: 'resolve_report',
                target_type: 'Product',
                target_id: productId,
                keterangan: `Membekukan produk ID ${productId} (${rep.reported_product.title}) karena laporan scam terbukti valid.`,
                created_at: new Date().toISOString()
            });

            window.showToast('Produk preloved diblokir & laporan diselesaikan!');
            loadAdminDashboard();
        }
    }

    function rejectReport(reportId) {
        const rep = reports.find(r => r.id === reportId);
        if (rep) {
            rep.status = 'Resolved';

            auditLogs.unshift({
                id: auditLogs.length + 1,
                action: 'reject_report',
                target_type: 'Report',
                target_id: reportId,
                keterangan: `Menolak laporan ID ${reportId} karena bukti tidak cukup kuat.`,
                created_at: new Date().toISOString()
            });

            window.showToast('Laporan ditolak oleh admin.');
            loadAdminDashboard();
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        loadAdminDashboard();
    });
</script>
@endsection
