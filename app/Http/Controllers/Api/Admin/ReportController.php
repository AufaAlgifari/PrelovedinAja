<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with([
            'reporter:id,name',
            'reportedProduct:id,title',
            'reportedUser:id,name',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json($reports);
    }

    public function resolve(Request $request, Report $report)
    {
        $report->update(['status' => 'Resolved']);

        $productTitle = $report->reportedProduct->title ?? '(produk sudah dihapus)';
        $productId = $report->reported_product_id;

        if ($report->reportedProduct) {
            $report->reportedProduct->update(['status' => 'Blocked']);
        }

        AuditLogController::record(
            $request->user()->id,
            'resolve_report',
            'Product',
            $productId,
            "Membekukan produk \"{$productTitle}\" karena laporan #{$report->id} terbukti valid."
        );

        return response()->json(['message' => 'Laporan diselesaikan & produk diblokir.', 'report' => $report]);
    }

    public function reject(Request $request, Report $report)
    {
        $report->update(['status' => 'Rejected']);

        AuditLogController::record(
            $request->user()->id,
            'reject_report',
            'Report',
            $report->id,
            "Menolak laporan #{$report->id} karena bukti tidak cukup kuat."
        );

        return response()->json(['message' => 'Laporan ditolak.', 'report' => $report]);
    }
}