<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="dash-title text-2xl text-slate-800">Détails commande</h2>
                        <p class="text-sm text-slate-600 mt-1">{{ $order->order_number }}</p>
                    </div>
                    <a href="{{ route('seller.orders') }}" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-600 hover:bg-slate-50">
                        ← Retour aux commandes
                    </a>
                </div>
            </section>

            @if (session('success'))
                <div class="dash-card bg-emerald-50 border-emerald-200 px-4 py-3">
                    <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Order Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Products -->
                    <div class="dash-card overflow-hidden">
                        <div class="border-b border-slate-200 px-4 py-3">
                            <h5 class="dash-title text-base text-slate-800">Vos produits dans cette commande</h5>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-50 text-slate-600">
                                    <tr>
                                        <th class="text-left px-4 py-2 font-semibold">Produit</th>
                                        <th class="text-left px-4 py-2 font-semibold">Quantité</th>
                                        <th class="text-left px-4 py-2 font-semibold">Prix unitaire</th>
                                        <th class="text-left px-4 py-2 font-semibold">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="text-slate-600">
                                    @foreach ($sellerItems as $item)
                                        <tr class="border-t border-slate-200">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    @php
                                                        $image = is_array($item->product->images) && count($item->product->images) ? $item->product->images[0] : null;
                                                    @endphp
                                                    @if ($image)
                                                        <img class="h-10 w-10 rounded-md object-cover" src="{{ $image }}" alt="{{ $item->product->name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-md bg-slate-100"></div>
                                                    @endif
                                                    <span class="font-medium text-slate-800">{{ $item->product->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">{{ $item->quantity }}</td>
                                            <td class="px-4 py-3">{{ number_format($item->unit_price, 2) }} €</td>
                                            <td class="px-4 py-3 font-semibold">{{ number_format($item->total_price, 2) }} €</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-slate-50">
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-right font-semibold text-slate-800">Total de vos produits:</td>
                                        <td class="px-4 py-3 font-bold text-emerald-600">{{ number_format($sellerTotal, 2) }} €</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    @if ($order->shipping_address)
                        <div class="dash-card p-4">
                            <h5 class="dash-title text-base text-slate-800 mb-3">Adresse de livraison</h5>
                            <div class="text-sm text-slate-600">
                                @if (is_array($order->shipping_address))
                                    @foreach ($order->shipping_address as $key => $value)
                                        <p><span class="font-medium">{{ ucfirst($key) }}:</span> {{ $value }}</p>
                                    @endforeach
                                @else
                                    <p>{{ $order->shipping_address }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Update -->
                    <div class="dash-card p-4">
                        <h5 class="dash-title text-base text-slate-800 mb-3">Statut de la commande</h5>
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-700',
                                'processing' => 'bg-indigo-100 text-indigo-700',
                                'shipped' => 'bg-purple-100 text-purple-700',
                                'delivered' => 'bg-emerald-100 text-emerald-700',
                                'cancelled' => 'bg-rose-100 text-rose-700',
                            ];
                            $statusLabels = [
                                'pending' => 'En attente',
                                'processing' => 'En cours',
                                'shipped' => 'Expédiée',
                                'delivered' => 'Livrée',
                                'cancelled' => 'Annulée',
                            ];
                        @endphp
                        <p class="mb-3">
                            <span class="rounded-full px-3 py-1 text-sm {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>
                        </p>

                        <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}">
                            @csrf
                            @method('PATCH')
                            <label class="block text-sm text-slate-600 mb-2">Changer le statut:</label>
                            <select name="status" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-teal-500 focus:ring-teal-500">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>En cours de préparation</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Expédiée</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Livrée</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                            </select>
                            <button type="submit" class="mt-3 w-full rounded-lg bg-teal-600 px-3 py-2 text-sm text-white hover:bg-teal-700">
                                Mettre à jour
                            </button>
                        </form>
                    </div>

                    <!-- Customer Info -->
                    <div class="dash-card p-4">
                        <h5 class="dash-title text-base text-slate-800 mb-3">Client</h5>
                        <div class="text-sm text-slate-600 space-y-1">
                            <p><span class="font-medium">Nom:</span> {{ $order->user->name ?? 'N/A' }}</p>
                            <p><span class="font-medium">Email:</span> {{ $order->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="dash-card p-4">
                        <h5 class="dash-title text-base text-slate-800 mb-3">Historique</h5>
                        <div class="text-sm text-slate-600 space-y-2">
                            <p><span class="font-medium">Créée:</span> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            @if ($order->shipped_at)
                                <p><span class="font-medium">Expédiée:</span> {{ $order->shipped_at->format('d/m/Y H:i') }}</p>
                            @endif
                            @if ($order->delivered_at)
                                <p><span class="font-medium">Livrée:</span> {{ $order->delivered_at->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
