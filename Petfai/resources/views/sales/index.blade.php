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

        <div class="mt-2 flex flex-col gap-2">
            <button type="button" onclick="document.getElementById('cashModal').classList.remove('hidden')" class="w-full bg-gray-700 text-white py-2 rounded">
                Pay with Cash
            </button>

            <button type="button" onclick="document.getElementById('mpesaModal').classList.remove('hidden')" class="w-full bg-green-600 text-white py-2 rounded">
                Pay with M-Pesa
            </button>
        </div>
    </div>
@endif

@if (session('success'))
    <div class="mt-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
@endif

<!-- Cash Modal -->
<div id="cashModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded p-6 w-96">
        <h3 class="font-bold text-lg mb-3">Cash Payment</h3>
        <p class="text-sm text-gray-600 mb-3">Total due: <span class="font-bold">KES {{ number_format($cartTotal, 2) }}</span></p>

        <form method="POST" action="{{ route('sales.checkout') }}" onsubmit="return validateCash({{ $cartTotal }})">
            @csrf
            <input type="hidden" name="payment_method" value="cash">
            <input
                type="number"
                step="0.01"
                name="amount_given"
                id="amountGiven"
                placeholder="Amount given by customer"
                class="border rounded px-3 py-2 w-full mb-2"
                required
            >
            <p id="balancePreview" class="text-sm text-gray-500 mb-3"></p>
            <button type="submit" class="w-full bg-gray-700 text-white py-2 rounded">Complete Sale</button>
            <button type="button" onclick="document.getElementById('cashModal').classList.add('hidden')" class="w-full mt-2 text-gray-500 py-1">Cancel</button>
        </form>
    </div>
</div>

<script>
document.getElementById('amountGiven')?.addEventListener('input', function() {
    const total = {{ $cartTotal }};
    const given = parseFloat(this.value) || 0;
    const balance = given - total;
    const preview = document.getElementById('balancePreview');

    if (given > 0) {
        preview.textContent = balance >= 0
            ? `Balance to give: KES ${balance.toFixed(2)}`
            : `Short by: KES ${Math.abs(balance).toFixed(2)}`;
        preview.className = balance >= 0 ? 'text-sm text-green-600 mb-3' : 'text-sm text-red-600 mb-3';
    } else {
        preview.textContent = '';
    }
});

function validateCash(total) {
    const given = parseFloat(document.getElementById('amountGiven').value) || 0;
    if (given < total) {
        alert('Amount given is less than the total. Please confirm the correct amount.');
        return false;
    }
    return true;
}
</script>

<!-- M-Pesa Modal -->
<div id="mpesaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded p-6 w-96">
        <div id="mpesaStep1">
            <h3 class="font-bold text-lg mb-3">M-Pesa Payment</h3>
            <input type="text" id="mpesaPhone" placeholder="Phone number (07XXXXXXXX)" class="border rounded px-3 py-2 w-full mb-3">
            <button onclick="startMpesaPayment()" class="w-full bg-green-600 text-white py-2 rounded">Send Payment Request</button>
            <button onclick="document.getElementById('mpesaModal').classList.add('hidden')" class="w-full mt-2 text-gray-500 py-1">Cancel</button>
        </div>

        <div id="mpesaStep2" class="hidden text-center">
            <p class="mb-3">Sending payment request...</p>
            <p class="text-sm text-gray-500">Enter your M-Pesa PIN on your phone to complete.</p>
        </div>

        <div id="mpesaStep3" class="hidden text-center">
            <p class="text-green-600 font-bold mb-3">✓ Payment Received</p>
            <form method="POST" action="{{ route('sales.checkout') }}">
                @csrf
                <input type="hidden" name="payment_method" value="mpesa">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Complete Sale</button>
            </form>
        </div>
    </div>
</div>

<script>
function startMpesaPayment() {
    document.getElementById('mpesaStep1').classList.add('hidden');
    document.getElementById('mpesaStep2').classList.remove('hidden');

    setTimeout(() => {
        document.getElementById('mpesaStep2').classList.add('hidden');
        document.getElementById('mpesaStep3').classList.remove('hidden');
    }, 2000);
}
</script>
        </div>
    </div>
</x-app-layout>