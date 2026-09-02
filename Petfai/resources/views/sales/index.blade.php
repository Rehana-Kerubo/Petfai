<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto">
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
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>