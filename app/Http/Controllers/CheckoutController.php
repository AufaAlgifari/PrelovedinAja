<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Display the checkout page for a specific product.
     * 
     * @param Product $product
     * @return \Illuminate\View\View
     */
    public function index(Product $product)
    {
        return view('checkout', compact('product'));
    }

    /**
     * Process payment and generate Snap Token.
     */
    public function processPayment(Request $request, Product $product)
    {
        $user = auth()->user();

        if (!$user) {
            $user = \App\Models\User::first(); 
        }

        $orderIdMidtrans = 'PRELOVED-' . time() . '-' . Str::random(5);

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'cart_id' => null,
            'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
            'order_id_midtrans' => $orderIdMidtrans,
            'amount' => $product->price,
            'status' => 'pending',
        ]);

        // Midtrans Parameters
        $params = [
            'transaction_details' => [
                'order_id' => $orderIdMidtrans,
                'gross_amount' => (int) $product->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone_number ?? '081234567890',
            ],
            'item_details' => [
                [
                    'id' => $product->id,
                    'price' => (int) $product->price,
                    'quantity' => 1,
                    'name' => Str::limit($product->title, 50),
                ]
            ],
        ];

        try {
            // Generate Token
            $snapToken = $this->midtransService->getSnapToken($params);

            // Update Transaction
            $transaction->update([
                'snap_token' => $snapToken
            ]);

            // Kembalikan view checkout beserta snap token dan client key
            return view('checkout', [
                'product' => $product,
                'snapToken' => $snapToken,
                'clientKey' => config('midtrans.client_key')
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Midtrans Error: ' . $e->getMessage());
        }
    }
}
