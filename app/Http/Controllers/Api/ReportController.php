<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use App\Notifications\NewReportSubmittedNotification;
use App\Notifications\ReportResolvedNotification;
use App\Notifications\ProductReportResolvedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ReportController extends Controller
{
    // POST /reports
    public function store(Request $request)
    {
        $data = $request->validate([
            'reported_product_id' => 'nullable|integer|exists:products,id',
            'reported_user_id'    => 'nullable|integer|exists:users,id',
            'reason'              => 'required|string|max:1000',
            'category'            => 'required|in:Scam,Inappropriate,Fake',
        ]);

        // Minimal salah satu harus diisi
        if (empty($data['reported_product_id']) && empty($data['reported_user_id'])) {
            return response()->json([
                'message' => 'Harus melaporkan produk atau pengguna.',
            ], 422);
        }

        // Tidak bisa melaporkan diri sendiri
        if (
            isset($data['reported_user_id']) &&
            $data['reported_user_id'] === $request->user()->id
        ) {
            return response()->json([
                'message' => 'Kamu tidak bisa melaporkan diri sendiri.',
            ], 422);
        }

        $report = Report::create([
            'reporter_id'         => $request->user()->id,
            'reported_product_id' => $data['reported_product_id'] ?? null,
            'reported_user_id'    => $data['reported_user_id'] ?? null,
            'reason'              => $data['reason'],
            'category'            => $data['category'],
            'status'              => 'Pending',
        ]);

        // Kirim notifikasi ke semua admin
        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewReportSubmittedNotification($report));
        }

        return response()->json([
            'message' => 'Laporan berhasil dikirim dan akan segera ditinjau.',
            'report'  => $report,
        ], 201);
    }

    // PATCH /admin/reports/{id}/resolve
    public function resolve(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Resolved,Dismissed',
        ]);

        $report->update([
            'status' => $request->input('status'),
        ]);

        // Kirim notifikasi ke pelapor (reporter)
        if ($report->reporter) {
            $report->reporter->notify(new ReportResolvedNotification($report));
        }

        // Kirim notifikasi ke penjual produk (jika aduan terkait produk)
        if ($report->reportedProduct && $report->reportedProduct->seller) {
            $report->reportedProduct->seller->notify(new ProductReportResolvedNotification($report));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Laporan berhasil diperbarui.',
            'report' => $report->load(['reporter', 'reportedProduct'])
        ]);
    }
}