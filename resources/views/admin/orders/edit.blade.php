@if ($errors->any())
    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg text-center font-semibold">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-admin-layout>
    <div class="flex justify-center items-start min-h-screen bg-gray-100 py-16">
        <div class="w-full max-w-3xl bg-white rounded-xl shadow-xl p-10 mt-16">
            <h2 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Edit Order</h2>
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg text-center font-semibold">{{ session('error') }}</div>
            @endif
            <form method="POST" action="{{ route('admin.transaction.update', $order->order_id) }}">
                @csrf
                @method('PUT')

                <!-- User Selection -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">User</label>
                    <select name="user_id" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                        <option value="">Select User</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ $order->details->first()->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Products Selection -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Products</label>
                    <div id="products-list">
                        @php
                            $orderProducts = $order->details->keyBy('product_id');
                        @endphp
                        @foreach(\App\Models\Product::all() as $product)
                            @php
                                $checked = $orderProducts->has($product->product_id);
                                $qty = $checked ? $orderProducts[$product->product_id]->quantity : '';
                            @endphp
                            <div class="flex items-center mb-2">
                                <input type="checkbox" name="products[{{ $product->product_id }}][selected]" value="1"
                                    class="mr-2 product-checkbox"
                                    id="product-{{ $product->product_id }}"
                                    data-price="{{ $product->price }}"
                                    {{ $checked ? 'checked' : '' }}>
                                <label for="product-{{ $product->product_id }}" class="mr-4">{{ $product->product_name }}</label>
                                <input type="number" name="products[{{ $product->product_id }}][quantity]" min="1"
                                    placeholder="Qty"
                                    class="w-20 border border-gray-300 rounded px-2 py-1 product-qty"
                                    data-price="{{ $product->price }}"
                                    value="{{ $qty }}"
                                    {{ $checked ? '' : 'disabled' }}>
                                <span class="ml-2 text-gray-500">₱{{ number_format($product->price, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    @error('products') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Order Total -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Order Total</label>
                    <input type="number" name="order_total" id="order_total"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100"
                        value="{{ $order->order_total }}"
                        readonly required>
                </div>

                <!-- Purchase Date -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Purchase Date</label>
                    <input type="date" name="purchase_date" class="w-full border border-gray-300 rounded-lg px-4 py-2"
                        value="{{ \Illuminate\Support\Carbon::parse($order->purchase_date)->format('Y-m-d') }}" required>
                    @error('purchase_date') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="successful" {{ $order->status == 'successful' ? 'selected' : '' }}>Successful</option>
                        <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    @error('status') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('all-transaction.index') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold shadow hover:bg-gray-300 transition">
                        &larr; Go Back
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-teal-600 text-white rounded-lg font-semibold shadow hover:bg-teal-700 transition"
                        style="background-color: #0891b2; color: #fff;">
                        Update Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function computeTotal() {
            let total = 0;
            document.querySelectorAll('#products-list .product-checkbox').forEach(function(checkbox) {
                if (checkbox.checked) {
                    const qtyInput = checkbox.parentElement.querySelector('.product-qty');
                    const price = parseFloat(checkbox.dataset.price);
                    const qty = parseInt(qtyInput.value) || 0;
                    total += price * qty;
                }
            });
            document.getElementById('order_total').value = total.toFixed(2);
        }

        document.querySelectorAll('#products-list input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const qtyInput = this.parentElement.querySelector('input[type="number"]');
                qtyInput.disabled = !this.checked;
                if (!this.checked) qtyInput.value = '';
                computeTotal();
            });
        });
        document.querySelectorAll('#products-list input[type="number"]').forEach(function(qtyInput) {
            qtyInput.addEventListener('input', computeTotal);
        });

        // Initial compute on page load
        computeTotal();
    </script>
</x-admin-layout>

@if(session('js_error'))
    <script>
        console.error("Order update error: {{ session('js_error') }}");
        alert("Order update error: {{ session('js_error') }}");
    </script>
@endif