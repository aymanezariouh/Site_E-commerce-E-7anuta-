<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $order->order_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 rounded text-sm
                                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                                    @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($order->total_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('admin.updateOrderStatus', $order->id) }}" method="POST" class="inline-flex items-center space-x-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="text-sm border-gray-300 rounded-md">
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
                                                        Update
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No orders found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>