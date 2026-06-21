<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user:id,name', 'product:id,title']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json($transactions);
    }

    public function stats()
    {
        return response()->json([
            'total_transactions' => Transaction::count(),
            'total_success'      => Transaction::where('status', 'success')->count(),
            'total_pending'      => Transaction::where('status', 'pending')->count(),
            'total_gmv'          => (int) Transaction::where('status', 'success')->sum('amount'),
        ]);
    }
}