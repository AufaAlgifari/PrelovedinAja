<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AuditLog::with('admin:id,name')
            ->latest()
            ->paginate($request->get('per_page', 20));

        return response()->json($logs);
    }

    // Helper statis dipakai controller admin lain untuk mencatat aksi
    public static function record(int $adminId, string $action, string $targetType, int $targetId, string $keterangan): AuditLog
    {
        return AuditLog::create([
            'admin_id'    => $adminId,
            'action'      => $action,
            'target_type' => $targetType,
            'target_id'   => $targetId,
            'keterangan'  => $keterangan,
        ]);
    }
}