@props(['orders' => collect()])

<div class="dash-card overflow-hidden">
    <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
        <div>
            <h5 class="dash-title text-base text-slate-800">Mes commandes</h5>
            <p class="text-xs text-slate-500">Suivez vos achats recents.</p>
        </div>
        <span class="dash-pill">Historique</span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-4 py-2 font-semibold">ID</th>
                    <th class="text-left px-4 py-2 font-semibold">Date</th>
                    <th class="text-left px-4 py-2 font-semibold">Total</th>
                    <th class="text-left px-4 py-2 font-semibold">Statut</th>
                    <th class="text-left px-4 py-2 font-semibold">Paiement</th>
                    <th class="text-left px-4 py-2 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="text-slate-600">
                @forelse ($orders as $order)
                    <tr class="border-t border-slate-200">
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $order->order_number }}</td>
                        <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 font-semibold text-emerald-600">{{ number_format($order->total_amount, 2) }} €</td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'processing' => 'bg-indigo-100 text-indigo-700',
                                    'shipped' => 'bg-purple-100 text-purple-700',
                                    'delivered' => 'bg-emerald-100 text-emerald-700',
                                    'cancelled' => 'bg-rose-100 text-rose-700',
                                    'refunded' => 'bg-slate-100 text-slate-600',
                                ];
                                $statusLabels = [
                                    'pending' => 'En attente',
                                    'processing' => 'En cours',
                                    'shipped' => 'Expédiée',
                                    'delivered' => 'Livrée',
                                    'cancelled' => 'Annulée',
                                    'refunded' => 'Remboursée',
                                ];
                            @endphp
                            <span class="rounded-full px-2 py-1 text-xs {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            {{ $order->payments->last()?->status ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('buyer.orderDetails', $order->id) }}" class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-xs text-slate-600 hover:bg-slate-50">
                                Détails
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-slate-200">
                        <td class="px-4 py-3" colspan="6">Aucune commande pour le moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
