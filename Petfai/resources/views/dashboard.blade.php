<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="border rounded p-4">
                <p class="text-sm text-gray-500">Today's Revenue</p>
                <p class="text-xl font-bold">KES {{ number_format($todayRevenue, 2) }}</p>
            </div>
            <div class="border rounded p-4">
                <p class="text-sm text-gray-500">Today's Profit</p>
                <p class="text-xl font-bold text-green-600">KES {{ number_format($todayProfit, 2) }}</p>
            </div>
            <div class="border rounded p-4">
                <p class="text-sm text-gray-500">Week's Revenue</p>
                <p class="text-xl font-bold">KES {{ number_format($weekRevenue, 2) }}</p>
            </div>
            <div class="border rounded p-4">
                <p class="text-sm text-gray-500">Week's Profit</p>
                <p class="text-xl font-bold text-green-600">KES {{ number_format($weekProfit, 2) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-bold mb-3">Top Selling Products</h2>
                @forelse ($topProducts as $item)
                    <div class="flex justify-between border-b py-2">
                        <span>{{ $item->product->name ?? 'Unknown' }}</span>
                        <span class="font-semibold">{{ $item->total_quantity }} sold</span>
                    </div>
                @empty
                    <p class="text-gray-500">No sales yet</p>
                @endforelse
            </div>

            <div>
                <h2 class="text-lg font-bold mb-3">Low Stock Alerts</h2>
                @forelse ($lowStockProducts as $product)
                    <div class="flex justify-between border-b py-2 text-red-600">
                        <span>{{ $product->name }}</span>
                        <span class="font-semibold">{{ $product->stock_quantity }} left</span>
                    </div>
                @empty
                    <p class="text-gray-500">All stock levels healthy</p>
                @endforelse
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('products.index') }}" class="text-blue-600 underline">Manage Stock →</a>
        </div>
    </div>
</x-app-layout>