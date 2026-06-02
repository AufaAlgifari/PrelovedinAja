<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

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

        return response()->json([
            'message' => 'Laporan berhasil dikirim dan akan segera ditinjau.',
            'report'  => $report,
        ], 201);
    }
}