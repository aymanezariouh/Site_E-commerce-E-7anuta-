<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order #{{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-6">Order Status Timeline</h3>
                    <div class="flex items-center justify-between">

                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $order->status == 'pending' || in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-sm mt-2 {{ $order->status == 'pending' ? 'font-bold text-blue-600' : 'text-gray-600' }}">Pending</span>
                        </div>

                        <div class="flex-1 h-1 mx-4 {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }}"></div>

                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-sm mt-2 {{ $order->status == 'processing' ? 'font-bold text-blue-600' : 'text-gray-600' }}">Processing</span>
                        </div>

                        <div class="flex-1 h-1 mx-4 {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }}"></div>

                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-sm mt-2 {{ $order->status == 'shipped' ? 'font-bold text-blue-600' : 'text-gray-600' }}">Shipped</span>
                        </div>

                        <div class="flex-1 h-1 mx-4 {{ $order->status == 'delivered' ? 'bg-green-500' : 'bg-gray-300' }}"></div>

                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $order->status == 'delivered' ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-sm mt-2 {{ $order->status == 'delivered' ? 'font-bold text-blue-600' : 'text-gray-600' }}">Delivered</span>
                        </div>
                    </div>

                    <div class="mt-6 p-4 rounded-lg {{ $order->status == 'pending' ? 'bg-yellow-50 border border-yellow-200' : ($order->status == 'processing' ? 'bg-blue-50 border border-blue-200' : ($order->status == 'shipped' ? 'bg-purple-50 border border-purple-200' : ($order->status == 'delivered' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'))) }}">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($order->status == 'pending')
                                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                @elseif($order->status == 'processing')
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                    </svg>
                                @elseif($order->status == 'shipped')
                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                                    </svg>
                                @elseif($order->status == 'delivered')
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium {{ $order->status == 'pending' ? 'text-yellow-800' : ($order->status == 'processing' ? 'text-blue-800' : ($order->status == 'shipped' ? 'text-purple-800' : ($order->status == 'delivered' ? 'text-green-800' : 'text-red-800'))) }}">
                                    @if($order->status == 'pending')
                                        Order Received
                                    @elseif($order->status == 'processing')
                                        Order Being Processed
                                    @elseif($order->status == 'shipped')
                                        Order Shipped
                                    @elseif($order->status == 'delivered')
                                        Order Delivered
                                    @else
                                        Order {{ ucfirst($order->status) }}
                                    @endif
                                </h4>
                                <p class="text-sm {{ $order->status == 'pending' ? 'text-yellow-700' : ($order->status == 'processing' ? 'text-blue-700' : ($order->status == 'shipped' ? 'text-purple-700' : ($order->status == 'delivered' ? 'text-green-700' : 'text-red-700'))) }}">
                                    @if($order->status == 'pending')
                                        We have received your order and it's being prepared for processing.
                                    @elseif($order->status == 'processing')
                                        Your order is currently being processed and will be shipped soon.
                                    @elseif($order->status == 'shipped')
                                        Your order has been shipped and is on its way to you.
                                        @if($order->shipped_at)
                                            Shipped on {{ $order->shipped_at->format('M d, Y') }}.
                                        @endif
                                    @elseif($order->status == 'delivered')
                                        Your order has been successfully delivered.
                                        @if($order->delivered_at)
                                            Delivered on {{ $order->delivered_at->format('M d, Y') }}.
                                        @endif
                                    @else
                                        Please contact support for more information about your order.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

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
                                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                                <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                                @if($order->shipped_at)
                                    <p><strong>Shipped Date:</strong> {{ $order->shipped_at->format('M d, Y H:i') }}</p>
                                @endif
                                @if($order->delivered_at)
                                    <p><strong>Delivered Date:</strong> {{ $order->delivered_at->format('M d, Y H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium mb-4">Shipping Address</h3>
                            @if($order->shipping_address)
                                <div class="text-sm bg-gray-50 p-4 rounded-lg">
                                    <p class="font-medium">{{ $order->shipping_address['name'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['city'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['phone'] ?? '' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($order->payments->isNotEmpty())
                        @php $payment = $order->payments->first(); @endphp
                        <div class="mt-8">
                            <h3 class="text-lg font-medium mb-4">Informations de paiement</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Méthode</p>
                                        <p class="font-medium text-gray-900">
                                            @if($payment->payment_method === 'cod')
                                                💵 Paiement à la livraison
                                            @elseif($payment->payment_method === 'bank_transfer')
                                                🏦 Virement bancaire
                                            @elseif($payment->payment_method === 'card')
                                                💳 Carte bancaire
                                            @else
                                                {{ ucfirst($payment->payment_method) }}
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Statut</p>
                                        <p>
                                            <span class="px-2 py-1 rounded text-sm
                                                @if($payment->status === 'completed') bg-green-100 text-green-800
                                                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($payment->status === 'failed') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </p>
                                    </div>
                                    @if($payment->transaction_id)
                                    <div>
                                        <p class="text-sm text-gray-500">Référence</p>
                                        <p class="font-mono text-sm text-gray-900">{{ $payment->transaction_id }}</p>
                                    </div>
                                    @endif
                                    <div>
                                        <p class="text-sm text-gray-500">Montant</p>
                                        <p class="font-medium text-gray-900">{{ number_format($payment->amount, 2) }} MAD</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

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
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                                                @if($item->product->description)
                                                    <div class="text-sm text-gray-500">{{ Str::limit($item->product->description, 50) }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($item->unit_price, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap font-medium">${{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right font-medium text-gray-900">Total:</td>
                                        <td class="px-6 py-4 font-bold text-lg">${{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('buyer.orders') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            ← Back to Orders
                        </a>

                        @if($order->status == 'delivered')
                            <div class="space-x-2">
                                @foreach($order->items as $item)
                                    @if(!$item->product->reviews()->where('user_id', Auth::id())->exists())
                                        <a href="{{ route('marketplace.show', $item->product->id) }}#review" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Review {{ $item->product->name }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
