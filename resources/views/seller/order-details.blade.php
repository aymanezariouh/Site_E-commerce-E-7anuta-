<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                     <div class="flex items-center gap-2 text-sm text-shop-gray-500 mb-1">
                        <a href="{{ route('seller.orders') }}" class="hover:text-brand-600 transition-colors">Commandes</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <span class="text-shop-gray-900 font-medium">#{{ $order->order_number }}</span>
                    </div>
                    <h2 class="text-3xl font-bold font-display text-shop-gray-900">Détails Commande</h2>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('seller.orders') }}" class="px-4 py-2 bg-white border border-shop-gray-200 rounded-lg text-sm font-medium text-shop-gray-700 hover:bg-shop-gray-50 transition-colors">
                        Retour
                    </a>
                    <button class="px-4 py-2 bg-brand-600 text-white rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Imprimer
                    </button>
                </div>
            </div>

            @if (session('success'))
                <div class="rounded-xl bg-green-50 border border-green-200 p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif
            
            @if (session('error'))
                 <div class="rounded-xl bg-red-50 border border-red-200 p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-red-700 text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Main Content (Products) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-soft border border-shop-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-shop-gray-100 bg-shop-gray-50/50">
                            <h5 class="text-lg font-bold text-shop-gray-900 font-display">Articles à expédier</h5>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-shop-gray-100">
                                <thead class="bg-shop-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Produit</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Qté</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Prix Unit.</th>
                                        <th class="px-6 py-3 text-right text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-shop-gray-100">
                                    @forelse ($sellerItems as $item)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    @php
                                                        $image = $item->product->primary_image;
                                                    @endphp
                                                    @if ($image)
                                                        <img class="h-12 w-12 rounded-lg object-cover border border-shop-gray-200" src="{{ $image }}" alt="{{ $item->product->name }}">
                                                    @else
                                                        <div class="h-12 w-12 rounded-lg bg-shop-gray-100 flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-shop-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <span class="block text-sm font-medium text-shop-gray-900">{{ $item->product_name ?? $item->product->name }}</span>
                                                        <span class="block text-xs text-shop-gray-500">REF: {{ $item->product->sku ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-shop-gray-600">x{{ $item->quantity }}</td>
                                            <td class="px-6 py-4 text-sm text-shop-gray-600">{{ number_format($item->unit_price, 2) }} MAD</td>
                                            <td class="px-6 py-4 text-sm font-bold text-shop-gray-900 text-right">{{ number_format($item->total_price, 2) }} MAD</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-shop-gray-500">Aucun article trouvé.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-shop-gray-50/50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right text-sm font-semibold text-shop-gray-700">Total Commande:</td>
                                        <td class="px-6 py-4 text-right text-lg font-bold text-brand-600">{{ number_format($sellerTotal, 2) }} MAD</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @if ($order->shipping_address)
                        <div class="bg-white rounded-xl shadow-soft border border-shop-gray-100 p-6">
                            <h5 class="text-lg font-bold text-shop-gray-900 font-display mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Adresse de Livraison
                            </h5>
                            <div class="bg-shop-gray-50 rounded-lg p-4 text-sm text-shop-gray-700 leading-relaxed border border-shop-gray-100">
                                @if (is_array($order->shipping_address))
                                    @foreach ($order->shipping_address as $key => $value)
                                        <div class="flex">
                                            <span class="w-24 font-medium text-shop-gray-500">{{ ucfirst($key) }}:</span>
                                            <span class="text-shop-gray-900">{{ $value }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p>{{ $order->shipping_address }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar (Status & Info) -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white rounded-xl shadow-soft border border-shop-gray-100 p-6">
                        <h5 class="text-lg font-bold text-shop-gray-900 font-display mb-4">Statut Commande</h5>
                        
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'delivered' => 'bg-green-100 text-green-800 border-green-200',
                                'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                'refunded' => 'bg-gray-100 text-gray-800 border-gray-200',
                            ];
                             $statusLabels = [
                                'pending' => 'En attente',
                                'processing' => 'Traitement',
                                'accepted' => 'Acceptée',
                                'shipped' => 'Expédiée',
                                'delivered' => 'Livrée',
                                'cancelled' => 'Annulée',
                                'refunded' => 'Remboursée',
                            ];
                        @endphp
                        
                        <div class="mb-6">
                             <div class="flex items-center justify-center p-3 rounded-lg border {{ $statusColors[$order->status] ?? 'bg-gray-50 border-gray-200 text-gray-500' }}">
                                <span class="text-sm font-bold uppercase tracking-wide">
                                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}">
                            @csrf
                            @method('PATCH')
                            <label class="block text-xs font-semibold text-shop-gray-500 uppercase tracking-wider mb-2">Mettre à jour</label>
                            <div class="space-y-3">
                                <select name="status" class="w-full rounded-lg border-shop-gray-200 text-sm focus:border-brand-500 focus:ring-brand-500">
                                    <option value="{{ $order->status }}" selected disabled>Choisir un statut...</option>
                                    @foreach ($availableStatuses as $status)
                                        <option value="{{ $status }}">{{ $statusLabels[$status] ?? ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-2 text-sm font-medium text-white hover:bg-brand-700 transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" @disabled(count($availableStatuses) === 0)>
                                    Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Payment Status -->
                    @if($order->payments->isNotEmpty())
                        @php $payment = $order->payments->first(); @endphp
                        <div class="bg-white rounded-xl shadow-soft border border-shop-gray-100 p-6">
                            <h5 class="text-lg font-bold text-shop-gray-900 font-display mb-4">Statut Paiement</h5>
                            
                            <div class="flex items-center justify-center p-4 rounded-lg border-2
                                @if($payment->status === 'completed') bg-green-50 border-green-200
                                @elseif($payment->status === 'pending') bg-yellow-50 border-yellow-200
                                @elseif($payment->status === 'failed') bg-red-50 border-red-200
                                @else bg-gray-50 border-gray-200
                                @endif">
                                <div class="text-center">
                                    <div class="mb-2">
                                        @if($payment->status === 'completed')
                                            <svg class="w-8 h-8 mx-auto text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @elseif($payment->status === 'pending')
                                            <svg class="w-8 h-8 mx-auto text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @elseif($payment->status === 'failed')
                                            <svg class="w-8 h-8 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @else
                                            <svg class="w-8 h-8 mx-auto text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </div>
                                    <span class="text-sm font-bold uppercase tracking-wide
                                        @if($payment->status === 'completed') text-green-800
                                        @elseif($payment->status === 'pending') text-yellow-800
                                        @elseif($payment->status === 'failed') text-red-800
                                        @else text-gray-800
                                        @endif">
                                        @if($payment->status === 'completed')
                                            ✓ Payé
                                        @elseif($payment->status === 'pending')
                                            ⏳ En attente
                                        @elseif($payment->status === 'failed')
                                            ✗ Échoué
                                        @else
                                            {{ ucfirst($payment->status) }}
                                        @endif
                                    </span>
                                    <p class="text-xs text-shop-gray-500 mt-2">
                                        @if($payment->payment_method === 'cod')
                                            Paiement à la livraison
                                        @elseif($payment->payment_method === 'bank_transfer')
                                            Virement bancaire
                                        @elseif($payment->payment_method === 'card')
                                            Carte bancaire
                                        @else
                                            {{ ucfirst($payment->payment_method) }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Customer Info -->
                    <div class="bg-white rounded-xl shadow-soft border border-shop-gray-100 p-6">
                        <h5 class="text-lg font-bold text-shop-gray-900 font-display mb-4">Client</h5>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 rounded-full bg-shop-gray-100 flex items-center justify-center text-shop-gray-500 font-bold">
                                {{ substr($order->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-shop-gray-900">{{ $order->user->name ?? 'Utilisateur Inconnu' }}</p>
                                <p class="text-xs text-shop-gray-500">Client depuis {{ $order->user->created_at->format('Y') }}</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center gap-2 text-shop-gray-600">
                                <svg class="w-4 h-4 text-shop-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span class="truncate">{{ $order->user->email ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="bg-white rounded-xl shadow-soft border border-shop-gray-100 p-6">
                        <h5 class="text-lg font-bold text-shop-gray-900 font-display mb-4">Historique</h5>
                        <div class="relative pl-4 border-l-2 border-shop-gray-100 space-y-6">
                            <!-- Created -->
                            <div class="relative">
                                <div class="absolute -left-[21px] top-1 h-3 w-3 rounded-full bg-shop-gray-200 border-2 border-white"></div>
                                <p class="text-xs text-shop-gray-500 mb-0.5">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                <p class="text-sm font-medium text-shop-gray-900">Commande créée</p>
                            </div>

                            @foreach ($order->statusHistories as $history)
                                <div class="relative">
                                    <div class="absolute -left-[21px] top-1 h-3 w-3 rounded-full bg-brand-200 border-2 border-white"></div>
                                    <p class="text-xs text-shop-gray-500 mb-0.5">{{ $history->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="text-sm font-medium text-shop-gray-900">Passée en {{ $statusLabels[$history->new_status] ?? $history->new_status }}</p>
                                    @if ($history->user)
                                        <p class="text-xs text-shop-gray-400">par {{ $history->user->name }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
