<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order #{{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Order Information -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">Order Information</h3>
                            <div class="space-y-2">
                                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                <p><strong>Status:</strong> 
                                    <span class="px-2 py-1 rounded text-sm
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                                <p><strong>Total Amount:</strong> {{ number_format($order->total_amount, 2) }} €</p>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">Shipping Address</h3>
                            @if($order->shipping_address)
                                <div class="text-sm">
                                    <p>{{ $order->shipping_address['name'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['city'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['phone'] ?? '' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium mb-4">Order Items</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->product_name ?? $item->product->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->unit_price, 2) }} €</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->total_price, 2) }} €</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
