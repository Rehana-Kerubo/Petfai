<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalesController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->input('search');

        $products = Product::when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%");
            })
            ->orderBy('name')
            ->get();

        $cart = session()->get('cart', []);
        $cartTotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('sales.index', [
            'products' => $products,
            'search' => $query,
            'cart' => $cart,
            'cartTotal' => $cartTotal,
        ]);
    }

    public function addToCart(Request $request, Product $product)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$product->id])) {
        $cart[$product->id]['quantity']++;
    } else {
        $cart[$product->id] = [
            'name' => $product->name,
            'price' => $product->selling_price,
            'quantity' => 1,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->route('sales.index');
}

public function removeFromCart(Product $product)
{
    $cart = session()->get('cart', []);
    unset($cart[$product->id]);
    session()->put('cart', $cart);

    return redirect()->route('sales.index');
}

public function updateCartQuantity(Request $request, Product $product)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$product->id])) {
        $cart[$product->id]['quantity'] = max(1, (int) $request->input('quantity'));
    }

    session()->put('cart', $cart);

    return redirect()->route('sales.index');
}
}