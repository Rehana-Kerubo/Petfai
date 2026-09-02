<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Manage Stock</h1>

        <form method="GET" action="{{ route('products.index') }}" class="mb-4">
    <input
        type="text"
        name="search"
        value="{{ $search }}"
        placeholder="Search products..."
        class="border rounded px-4 py-2 w-full max-w-md"
    >
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded ml-2">Search</button>
</form>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b text-left">
                    <th class="p-2">Name</th>
                    <th class="p-2">Buying Price</th>
                    <th class="p-2">Selling Price</th>
                    <th class="p-2">Stock</th>
                    <th class="p-2">Low Stock Alert</th>
                    <th class="p-2"></th>
                </tr>
            </thead>
           <tbody>
    @foreach ($products as $product)
        <tr class="border-b" id="row-display-{{ $product->id }}">
            <td class="p-2">{{ $product->name }}</td>
            <td class="p-2">{{ number_format($product->buying_price, 2) }}</td>
            <td class="p-2">{{ number_format($product->selling_price, 2) }}</td>
            <td class="p-2">{{ $product->stock_quantity }}</td>
            <td class="p-2">{{ $product->low_stock_threshold }}</td>
            <td class="p-2">
                <button type="button" onclick="toggleEdit({{ $product->id }})" class="text-sm text-blue-600 underline">
                    Edit
                </button>
            </td>
        </tr>

        <tr class="border-b hidden bg-gray-50" id="row-edit-{{ $product->id }}">
            <form method="POST" action="{{ route('products.update', $product) }}">
                @csrf
                @method('PATCH')
                <td class="p-2">{{ $product->name }}</td>
                <td class="p-2">
                    <input type="number" step="0.01" name="buying_price" value="{{ $product->buying_price }}" class="border rounded px-2 py-1 w-24">
                </td>
                <td class="p-2">
                    <input type="number" step="0.01" name="selling_price" value="{{ $product->selling_price }}" class="border rounded px-2 py-1 w-24">
                </td>
                <td class="p-2">
                    <input type="number" name="stock_quantity" value="{{ $product->stock_quantity }}" class="border rounded px-2 py-1 w-20">
                </td>
                <td class="p-2">
                    <input type="number" name="low_stock_threshold" value="{{ $product->low_stock_threshold }}" class="border rounded px-2 py-1 w-20">
                </td>
                <td class="p-2 flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">Save</button>
                    <button type="button" onclick="toggleEdit({{ $product->id }})" class="text-sm text-gray-500">Cancel</button>
                </td>
            </form>
        </tr>
    @endforeach
</tbody>
        </table>
    </div>
<script>
function toggleEdit(productId) {
    document.getElementById('row-display-' + productId).classList.toggle('hidden');
    document.getElementById('row-edit-' + productId).classList.toggle('hidden');
}
</script>
</x-app-layout>