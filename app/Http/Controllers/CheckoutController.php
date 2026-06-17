<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
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
}
