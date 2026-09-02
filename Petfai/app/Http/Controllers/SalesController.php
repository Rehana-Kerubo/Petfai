<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

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
public function checkout(Request $request)
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('sales.index')->with('error', 'Cart is empty.');
    }

    $paymentMethod = $request->input('payment_method', 'cash');

    DB::transaction(function () use ($cart, $paymentMethod) {
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $sale = Sale::create([
            'cashier_id' => auth()->id(),
            'total' => $total,
            'payment_method' => $paymentMethod,
        ]);

        foreach ($cart as $productId => $item) {
            $product = Product::findOrFail($productId);

            if ($product->stock_quantity < $item['quantity']) {
                throw new \Exception("Not enough stock for {$product->name}");
            }

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price_at_sale' => $product->selling_price,
                'cost_at_sale' => $product->buying_price,
            ]);

            $product->decrement('stock_quantity', $item['quantity']);
        }
    });

    session()->forget('cart');

    return redirect()->route('sales.index')->with('success', 'Sale completed!');
}
}