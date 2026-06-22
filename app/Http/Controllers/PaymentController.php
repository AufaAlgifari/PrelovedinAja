<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        
        // Fix SSL certificate issue on Windows for development
        // WARNING: Only disable SSL verification in development/sandbox mode
        if (!Config::$isProduction) {
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => [],
            ];
        }
    }

    /**
     * Show checkout page
     */
    public function checkout(Request $request)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk checkout.')
                ->with('redirect', url()->current());
        }

        $cartItems = $request->user()->carts()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Cart is empty');
        }

        $totalAmount = $cartItems->sum(function ($cart) {
            return $cart->product->price;
        });

        return view('transactions.checkout', compact('cartItems', 'totalAmount'));
    }

    /**
     * Create Midtrans token (Snap Token)
     */
    public function createSnapToken(Request $request)
    {
        $user = $request->user();
        $cartItems = $user->carts()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $totalAmount = $cartItems->sum(function ($cart) {
            return $cart->product->price;
        });

        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'cart_id' => $cartItems->first()->id,
            'transaction_id' => 'TXN-' . microtime(true) * 1000 . '-' . Str::random(8) . '-' . $user->id,
            'order_id_midtrans' => 'ORDER-' . microtime(true) * 1000 . '-' . Str::random(8) . '-' . $user->id,
            'amount' => $totalAmount,
            'status' => 'pending',
            'payment_type' => null,
            'snap_token' => null,
        ]);

        // Prepare Midtrans parameter
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id_midtrans,
                'gross_amount' => (int) $totalAmount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '08123456789',
            ],
            'item_details' => $cartItems->map(function ($cart) {
                return [
                    'id' => $cart->product->id,
                    'price' => (int) $cart->product->price,
                    'quantity' => 1,
                    'name' => $cart->product->title,
                ];
            })->toArray(),
            'enabled_payments' => [
                'credit_card', 'gcg_payment', 'bank_transfer', 'bank_bca', 
                'cimb_clicks', 'bca_klikbca', 'mandiri_clickpay', 
                'echannel', 'permata_va', 'bri_epay', 'telkomsel_cash',
                'gopay', 'shopeepay'
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            // Save snap token to transaction
            $transaction->update([
                'snap_token' => $snapToken,
            ]);

            return response()->json([
                'snap_token' => $snapToken,
                'client_key' => config('midtrans.client_key'),
                'transaction_id' => $transaction->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create Midtrans token from cart (API endpoint for Bearer token auth)
     * Works with both real sessions and demo mode (localStorage token)
     */
    public function createSnapTokenFromCart(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $cartItems = $user->carts()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $totalAmount = $cartItems->sum(function ($cart) {
            return $cart->product->price;
        });

        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'cart_id' => $cartItems->first()->id,
            'transaction_id' => 'TXN-' . microtime(true) * 1000 . '-' . Str::random(8) . '-' . $user->id,
            'order_id_midtrans' => 'ORDER-' . microtime(true) * 1000 . '-' . Str::random(8) . '-' . $user->id,
            'amount' => $totalAmount,
            'status' => 'pending',
            'payment_type' => null,
            'snap_token' => null,
        ]);

        // Prepare Midtrans parameter
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id_midtrans,
                'gross_amount' => (int) $totalAmount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '08123456789',
            ],
            'item_details' => $cartItems->map(function ($cart) {
                return [
                    'id' => $cart->product->id,
                    'price' => (int) $cart->product->price,
                    'quantity' => 1,
                    'name' => $cart->product->title,
                ];
            })->toArray(),
            'enabled_payments' => [
                'credit_card', 'gcg_payment', 'bank_transfer', 'bank_bca', 
                'cimb_clicks', 'bca_klikbca', 'mandiri_clickpay', 
                'echannel', 'permata_va', 'bri_epay', 'telkomsel_cash',
                'gopay', 'shopeepay'
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            $transaction->update([
                'snap_token' => $snapToken,
            ]);

            return response()->json([
                'snap_token' => $snapToken,
                'client_key' => config('midtrans.client_key'),
                'transaction_id' => $transaction->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle Midtrans notification (webhook)
     */
    public function handleNotification(Request $request)
    {
        $notif = json_decode($request->getContent());
        
        $transaction = Transaction::where('order_id_midtrans', $notif->order_id)->first();
        
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Update transaction status based on Midtrans response
        $transactionStatus = $notif->transaction_status;
        $fraudStatus = isset($notif->fraud_status) ? $notif->fraud_status : null;

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->update(['status' => 'challenge']);
            } else if ($fraudStatus == 'accept') {
                $transaction->update(['status' => 'success']);
                $this->completeTransaction($transaction);
            }
        } else if ($transactionStatus == 'settlement') {
            $transaction->update(['status' => 'success']);
            $this->completeTransaction($transaction);
        } else if ($transactionStatus == 'pending') {
            $transaction->update(['status' => 'pending']);
        } else if ($transactionStatus == 'deny') {
            $transaction->update(['status' => 'failed']);
        } else if ($transactionStatus == 'expire') {
            $transaction->update(['status' => 'expired']);
        } else if ($transactionStatus == 'cancel') {
            $transaction->update(['status' => 'failed']);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Payment success callback
     */
    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $transaction = Transaction::where('order_id_midtrans', $orderId)->first();

        if (!$transaction) {
            return redirect('/')->with('error', 'Transaction not found');
        }

        return view('transactions.success', compact('transaction'));
    }

    /**
     * Payment pending callback
     */
    public function paymentPending(Request $request)
    {
        $orderId = $request->query('order_id');
        $transaction = Transaction::where('order_id_midtrans', $orderId)->first();

        if (!$transaction) {
            return redirect('/')->with('error', 'Transaction not found');
        }

        return view('transactions.pending', compact('transaction'));
    }

    /**
     * Payment error callback
     */
    public function paymentError(Request $request)
    {
        $orderId = $request->query('order_id');
        $transaction = Transaction::where('order_id_midtrans', $orderId)->first();

        if (!$transaction) {
            return redirect('/')->with('error', 'Transaction not found');
        }

        return view('transactions.error', compact('transaction'));
    }

    /**
     * Complete transaction (clear cart, etc)
     */
    private function completeTransaction($transaction)
    {
        // Clear user cart items
        if ($transaction->user) {
            $transaction->user->carts()->delete();
        }
    }
}
