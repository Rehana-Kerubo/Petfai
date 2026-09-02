<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto flex gap-6">
        <div class="flex-1">
            <h1 class="text-2xl font-bold mb-4">Sales</h1>

            <form method="GET" action="{{ route('sales.index') }}" class="mb-6">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search products..."
                    class="border rounded px-4 py-2 w-full max-w-md"
                >
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded ml-2">Search</button>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($products as $product)
                    <div class="border rounded p-4">
                        <h2 class="font-semibold">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $product->category }}</p>
                        <p class="mt-2 font-bold">KES {{ number_format($product->selling_price, 2) }}</p>
                        <p class="text-sm {{ $product->stock_quantity <= $product->low_stock_threshold ? 'text-red-500' : 'text-gray-500' }}">
                            Stock: {{ $product->stock_quantity }}
                        </p>
                        <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-2">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white text-sm px-3 py-1 rounded" @if($product->stock_quantity < 1) disabled @endif>
                                Add to Cart
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="w-80 border-l pl-6">
            <h2 class="text-xl font-bold mb-4">Cart</h2>

            @forelse ($cart as $productId => $item)
                <div class="mb-3 border-b pb-2">
                    <p class="font-semibold">{{ $item['name'] }}</p>
                    <p class="text-sm text-gray-500">KES {{ number_format($item['price'], 2) }} each</p>
                    <div class="flex items-center gap-2 mt-1">
                        <form method="POST" action="{{ route('cart.update', $productId) }}" class="flex items-center gap-1">
                            @csrf
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 border rounded px-1">
                            <button type="submit" class="text-sm text-blue-600">Update</button>
                        </form>
                        <form method="POST" action="{{ route('cart.remove', $productId) }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-600">Remove</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Cart is empty</p>
            @endforelse

            @if (count($cart) > 0)
                <div class="mt-4 pt-4 border-t">
                    <p class="font-bold text-lg">Total: KES {{ number_format($cartTotal, 2) }}</p>
                    <button class="mt-2 w-full bg-blue-600 text-white py-2 rounded">Checkout</button>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>