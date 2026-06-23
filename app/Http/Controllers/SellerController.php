<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        
        // Fallback for demo/fallback mode if user is not in database session
        if (!$userId) {
            $fallbackUser = \App\Models\User::first();
            $userId = $fallbackUser ? $fallbackUser->id : 0;
        }

        $stats = [
            'active'   => Product::where('seller_id', $userId)->where('status', 'Available')->count(),
            'pending'  => Product::where('seller_id', $userId)->where('status', 'Pending')->count(), // Safe fallback
            'sold'     => Product::where('seller_id', $userId)->where('status', 'Sold')->count(),
            'income'   => Transaction::whereHas('product', fn($q) => $q->where('seller_id', $userId))
                            ->whereIn('status', ['success', 'completed'])
                            ->whereMonth('created_at', now()->month)
                            ->sum('amount'),
            'orders'   => Transaction::whereHas('product', fn($q) => $q->where('seller_id', $userId))
                            ->whereIn('status', ['pending', 'success', 'completed'])
                            ->count(),
            'completed_transactions' => Transaction::whereHas('product', fn($q) => $q->where('seller_id', $userId))
                        ->whereIn('status', ['success', 'completed'])
                        ->count(),
        ];
        $recentOrders = Transaction::with(['product', 'user'])
            ->whereHas('product', fn($q) => $q->where('seller_id', $userId))
            ->latest()->take(5)->get();
        
        $completedTransactions = Transaction::whereHas('product', fn($q) => $q->where('seller_id', $userId))
            ->whereIn('status', ['success', 'completed'])
            ->count();

        $badge = $completedTransactions < 5
            ? 'Penjual Baru'
            : 'Penjual Permata';

        // Retrieve actual seller products from database
        $dbProducts = Product::where('seller_id', $userId)->latest()->get();

        return view('seller.dashboard', compact(
            'stats',
            'recentOrders',
            'completedTransactions',
            'badge',
            'dbProducts'
        ));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:1000',
            'category'    => 'required|string',
            'condition'   => 'required|string',
            'weight'      => 'nullable|numeric',
            'city'        => 'required|string|max:100',
            'image'       => 'nullable|image|max:5120',
        ]);

        $validated['seller_id'] = Auth::id();
        $validated['status']  = 'Available'; // default status

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Produk berhasil diposting.');
    }

    public function destroy(Product $product)
    {
        abort_if($product->seller_id !== Auth::id(), 403);
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function orders()
    {
        $userId = Auth::id();
        if (!$userId) {
            $fallbackUser = \App\Models\User::first();
            $userId = $fallbackUser ? $fallbackUser->id : 0;
        }

        $orders = Transaction::with(['product', 'user'])
            ->whereHas('product', fn($q) => $q->where('seller_id', $userId))
            ->latest()->paginate(15);
        return view('seller.orders', compact('orders'));
    }

    /**
     * Confirm delivery of the transaction by the seller.
     */
    public function confirmDelivery(Transaction $transaction)
    {
        $user = Auth::user();
        if (!$user || ($transaction->seller_id !== $user->id && $transaction->product->seller_id !== $user->id)) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->update([
            'status' => 'completed'
        ]);

        // Pastikan produk tetap sold
        if ($transaction->product) {
            $transaction->product->update(['status' => 'Sold']);
        }

        return back()
            ->with('success', 'Pengiriman barang berhasil dikonfirmasi! Pembeli sekarang dapat memberikan ulasan.');
    }
}