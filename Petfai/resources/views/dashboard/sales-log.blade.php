<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto px-6 space-y-6">

            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Sales Log</h1>
                <a href="{{ route('dashboard') }}" class="text-sm text-pink-600 hover:underline">← Back to Dashboard</a>
            </div>

            <form method="GET" action="{{ route('dashboard.sales.log') }}" class="flex items-center gap-3">
                <input type="date" name="date" value="{{ $date }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-pink-700">View</button>
            </form>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; max-width: 32rem;">
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <p class="text-sm text-gray-500">Cash Sales</p>
        <p class="text-2xl font-bold text-gray-900">KSh {{ number_format($cashTotal, 2) }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <p class="text-sm text-gray-500">M-Pesa Sales</p>
        <p class="text-2xl font-bold text-pink-600">KSh {{ number_format($mpesaTotal, 2) }}</p>
    </div>
</div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">
                    Sales on {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                    <span class="text-sm text-gray-500 font-normal">({{ $sales->count() }} sales, KSh {{ number_format($sales->sum('total'), 2) }} total)</span>
                </h3>

                @if ($sales->isEmpty())
                    <p class="text-gray-500 text-sm">No sales recorded for this date.</p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="py-2">Time</th>
                                <th class="py-2">Cashier</th>
                                <th class="py-2">Items</th>
                                <th class="py-2">Payment</th>
                                <th class="py-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr class="border-b last:border-0">
                                    <td class="py-2">{{ $sale->created_at->format('h:i A') }}</td>
                                    <td class="py-2">{{ $sale->cashier->name ?? 'Unknown' }}</td>
                                    <td class="py-2">{{ $sale->items->pluck('product.name')->filter()->join(', ') }}</td>
                                    <td class="py-2 capitalize">{{ $sale->payment_method }}</td>
                                    <td class="py-2 text-right font-semibold">{{ number_format($sale->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>