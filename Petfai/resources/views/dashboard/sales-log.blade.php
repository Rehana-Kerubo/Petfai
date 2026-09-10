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

            <h3 class="font-semibold text-gray-800">
                Sales on {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                <span class="text-sm text-gray-500 font-normal">({{ $sales->count() }} sales, KSh {{ number_format($sales->sum('total'), 2) }} total)</span>
            </h3>

            <div class="space-y-4">
                @forelse ($sales as $sale)
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-2 flex justify-between items-center text-sm">
                            <div>
                                <span class="font-semibold text-gray-800">{{ $sale->created_at->format('h:i A') }}</span>
                                <span class="text-gray-500 ml-2">by {{ $sale->cashier->name ?? 'Unknown' }}</span>
                                <span class="text-gray-500 ml-2 capitalize">· {{ $sale->payment_method }}</span>
                            </div>
                            <span class="font-bold text-gray-900">KSh {{ number_format($sale->total, 2) }}</span>
                        </div>

                        <table class="w-full text-sm">
                            <tbody>
                                @foreach ($sale->items as $item)
                                    <tr class="border-t border-gray-100">
                                        <td class="py-2 px-4">{{ $item->product->name ?? 'Unknown' }}</td>
                                        <td class="py-2 px-4 text-right text-gray-500">{{ $item->quantity }} × {{ number_format($item->price_at_sale, 2) }}</td>
                                        <td class="py-2 px-4 text-right font-medium w-28">{{ number_format($item->quantity * $item->price_at_sale, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No sales recorded for this date.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>