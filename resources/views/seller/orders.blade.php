<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <h2 class="dash-title text-2xl text-slate-800">Seller orders</h2>
                <p class="text-sm text-slate-600 mt-1">Manage customer orders containing your products.</p>
            </section>

            @if (session('success'))
                <div class="dash-card bg-emerald-50 border-emerald-200 px-4 py-3">
                    <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="dash-card bg-rose-50 border-rose-200 px-4 py-3">
                    <p class="text-rose-700 text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <div class="dash-card overflow-hidden">
                <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
                    <div>
                        <h5 class="dash-title text-base text-slate-800">Orders</h5>
                        <p class="text-xs text-slate-500">Sales tracking for your store.</p>
                    </div>
                    <span class="dash-pill">{{ $orders->total() }} order(s)</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="text-left px-4 py-2 font-semibold">Order #</th>
                                <th class="text-left px-4 py-2 font-semibold">Customer</th>
                                <th class="text-left px-4 py-2 font-semibold">Your items</th>
                                <th class="text-left px-4 py-2 font-semibold">Your amount</th>
                                <th class="text-left px-4 py-2 font-semibold">Status</th>
                                <th class="text-left px-4 py-2 font-semibold">Date</th>
                                <th class="text-left px-4 py-2 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-600">
                            @forelse ($orders as $order)
                                <tr class="border-t border-slate-200">
                                    <td class="px-4 py-3 font-medium text-slate-800">{{ $order->order_number }}</td>
                                    <td class="px-4 py-3">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $order->seller_items_count }} item(s)</td>
                                    <td class="px-4 py-3 font-semibold text-emerald-600">{{ number_format($order->seller_total, 2) }} EUR</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-amber-100 text-amber-700',
                                                'processing' => 'bg-blue-100 text-blue-700',
                                                'shipped' => 'bg-purple-100 text-purple-700',
                                                'delivered' => 'bg-emerald-100 text-emerald-700',
                                                'cancelled' => 'bg-rose-100 text-rose-700',
                                                'refunded' => 'bg-slate-100 text-slate-600',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Pending',
                                                'processing' => 'Accepted',
                                                'shipped' => 'Shipped',
                                                'delivered' => 'Delivered',
                                                'cancelled' => 'Cancelled',
                                                'refunded' => 'Refunded',
                                            ];
                                        @endphp
                                        <span class="rounded-full px-2 py-1 text-xs {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                                            {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('seller.orders.show', $order) }}" class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-xs text-slate-600 hover:bg-slate-50">Details</a>

                                            @if ($order->status === 'pending')
                                                <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" class="rounded-lg bg-blue-600 px-2 py-1 text-xs text-white hover:bg-blue-700">Accept</button>
                                                </form>
                                            @elseif ($order->status === 'processing')
                                                <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="shipped">
                                                    <button type="submit" class="rounded-lg bg-purple-600 px-2 py-1 text-xs text-white hover:bg-purple-700">Mark shipped</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t border-slate-200">
                                    <td class="px-4 py-3" colspan="7">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($orders->hasPages())
                    <div class="px-4 py-3 border-t border-slate-200">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
