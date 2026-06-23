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
        $stats = [
            'active'   => Product::where('user_id', $user->id)->where('status', 'available')->count(),
            'pending'  => Product::where('user_id', $user->id)->where('status', 'pending')->count(),
            'sold'     => Product::where('user_id', $user->id)->where('status', 'sold')->count(),
            'income'   => Transaction::whereHas('product', fn($q) => $q->where('user_id', $user->id))
                            ->where('status', 'success')
                            ->whereMonth('created_at', now()->month)
                            ->sum('amount'),
            'orders'   => Transaction::whereHas('product', fn($q) => $q->where('user_id', $user->id))
                            ->whereIn('status', ['pending', 'success'])
                            ->count(),
            'completed_transactions' => Transaction::whereHas('product', fn($q) => $q->where('user_id', $user->id))
                        ->where('status', 'success')
                        ->count(),
        ];
        $recentOrders = Transaction::with('product')
            ->whereHas('product', fn($q) => $q->where('user_id', $user->id))
            ->latest()->take(5)->get();
        
        $completedTransactions = Transaction::whereHas('product', fn($q) => $q->where('user_id', $user->id))
            ->where('status', 'success')
            ->count();

        $badge = $completedTransactions < 5
            ? 'Penjual Baru'
            : 'Penjual Aktif';

        return view('seller.dashboard', compact(
            'stats',
            'recentOrders',
            'completedTransactions',
            'badge'
        ));
    }

    public function create()
    {
        return view('seller.products.create');
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

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'pending'; // menunggu verifikasi admin

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Produk berhasil diposting, menunggu verifikasi admin.');
    }

    public function destroy(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function orders()
    {
        $orders = Transaction::with(['product', 'user'])
            ->whereHas('product', fn($q) => $q->where('user_id', Auth::id()))
            ->latest()->paginate(15);
        return view('seller.orders', compact('orders'));
    }
}