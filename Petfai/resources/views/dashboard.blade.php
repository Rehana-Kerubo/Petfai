<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto px-6 space-y-6">

            <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <div class="flex gap-3">
        <a href="{{ route('products.index') }}" class="bg-pink-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-pink-700">Manage Stock</a>
        <a href="{{ route('dashboard.sales.log') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200">Sales Log</a>
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('users.index') }}" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">Manage Users</a>
        @endif
    </div>
</div>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; max-width: 32rem;">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Today's Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">KSh {{ number_format($todayRevenue, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Today's Profit</p>
                    <p class="text-2xl font-bold text-pink-600">KSh {{ number_format($todayProfit, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">This Week's Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">KSh {{ number_format($weekRevenue, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">This Week's Profit</p>
                    <p class="text-2xl font-bold text-pink-600">KSh {{ number_format($weekProfit, 2) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Revenue — Last 7 Days</h3>
                <canvas id="salesChart" height="80"></canvas>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Top 5 Selling Products</h3>
                    @if($topProducts->isEmpty())
                        <p class="text-gray-500 text-sm">No sales data yet.</p>
                    @else
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="py-2">Product</th>
                                    <th class="py-2 text-right">Quantity Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $item)
                                    <tr class="border-b last:border-0">
                                        <td class="py-2">{{ $item->product->name ?? 'Unknown' }}</td>
                                        <td class="py-2 text-right">{{ $item->total_quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Low Stock Products</h3>
                    @if($lowStockProducts->isEmpty())
                        <p class="text-gray-500 text-sm">All products are well stocked.</p>
                    @else
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="py-2">Product</th>
                                    <th class="py-2 text-right">Stock</th>
                                    <th class="py-2 text-right">Threshold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockProducts as $product)
                                    <tr class="border-b last:border-0">
                                        <td class="py-2">{{ $product->name }}</td>
                                        <td class="py-2 text-right text-red-600 font-semibold">{{ $product->stock_quantity }}</td>
                                        <td class="py-2 text-right">{{ $product->low_stock_threshold }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($last7Days->pluck('label')) !!},
                datasets: [{
                    label: 'Revenue (KES)',
                    data: {!! json_encode($last7Days->pluck('total')) !!},
                    backgroundColor: '#db2777',
                    borderRadius: 6,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</x-app-layout>