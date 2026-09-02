<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto px-6">

            <div id="receipt" class="bg-white rounded-lg shadow-sm p-6">
                <div class="text-center mb-4">
                    <h2 class="text-lg font-bold text-gray-900">Beauty & Cosmetics Shop</h2>
                    <p class="text-xs text-gray-500">Receipt #{{ $sale->id }}</p>
                    <p class="text-xs text-gray-500">{{ $sale->created_at->format('d M Y, h:i A') }}</p>
                </div>

                <table class="w-full text-sm mb-4">
                    <thead>
                        <tr class="border-b text-left text-gray-500">
                            <th class="py-1">Item</th>
                            <th class="py-1 text-right">Qty</th>
                            <th class="py-1 text-right">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->items as $item)
                            <tr class="border-b last:border-0">
                                <td class="py-1">{{ $item->product->name ?? 'Unknown' }}</td>
                                <td class="py-1 text-right">{{ $item->quantity }}</td>
                                <td class="py-1 text-right">{{ number_format($item->price_at_sale * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="border-t pt-3 flex justify-between font-bold text-gray-900">
                    <span>Total</span>
                    <span>KSh {{ number_format($sale->total, 2) }}</span>
                </div>

                <p class="text-xs text-gray-500 mt-2">Payment: {{ ucfirst($sale->payment_method) }}</p>
                <p class="text-xs text-gray-500">Served by: {{ $sale->cashier->name ?? 'N/A' }}</p>

                <p class="text-center text-xs text-gray-400 mt-4">Thank you for shopping with us!</p>
            </div>

            <div class="flex gap-3 mt-4 print:hidden">
                <button onclick="window.print()" class="bg-pink-600 text-white px-4 py-2 rounded-lg text-sm w-full">Print Receipt</button>
                <a href="{{ route('sales.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm w-full text-center">New Sale</a>
            </div>

        </div>
    </div>
</x-app-layout>