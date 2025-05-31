<x-app-layout>
    <div class="py-10 px-4 sm:px-8">
        <!-- Header Section -->
        <!-- <div class="mb-10 mt-20">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Order History</h1>
            <p class="text-gray-600 text-lg mb-4">View all your past orders and their details below. Use the filter to find orders by status.</p>
            <hr class="border-gray-200">
        </div> -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4 mt-20">
            <form method="GET" class="flex items-center gap-2">
                <label for="status" class="text-sm text-gray-700 font-medium">Filter by Status:</label>
                <select name="status" id="status" class="border-gray-300 rounded-lg" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="successful" {{ request('status') == 'successful' ? 'selected' : '' }}>Successful</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </form>
        </div>
        @if($orders->count())
            <div class="space-y-8">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 md:p-8">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                            <div>
                                <span class="font-semibold text-gray-700 text-lg">Order #{{ $order->order_id }}</span>
                                <span class="ml-4 text-gray-500 text-sm">{{ $order->purchase_date->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                    {{ $order->status === 'successful' ? 'bg-green-100 text-green-700' : ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <span class="font-bold text-blue-600 text-lg">
                                    ₱{{ number_format($order->order_total, 2) }}
                                </span>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($order->details as $detail)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="font-medium text-gray-900">{{ $detail->product->product_name ?? 'Product deleted' }}</span>
                                            </td>
                                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                                {{ $detail->quantity }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-gray-500 text-center py-16">You have no orders yet.</div>
        @endif
    </div>
</x-app-layout>