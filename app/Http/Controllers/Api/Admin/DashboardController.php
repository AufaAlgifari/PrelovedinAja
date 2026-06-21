<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Report;
use App\Models\Transaction;
use App\Models\User;
use App\Models\AuditLog;

class DashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'reports_pending'    => Report::where('status', 'Pending')->count(),
            'reports_resolved'   => Report::where('status', 'Resolved')->count(),
            'users_suspended'    => User::where('status', 'suspended')->count(),
            'users_total'        => User::count(),
            'listings_active'    => Product::where('status', 'Available')->count(),
            'listings_total'     => Product::count(),
            'transactions_total' => Transaction::count(),
            'transactions_gmv'   => (int) Transaction::where('status', 'success')->sum('amount'),
            'audit_logs_total'   => AuditLog::count(),
        ]);
    }
}