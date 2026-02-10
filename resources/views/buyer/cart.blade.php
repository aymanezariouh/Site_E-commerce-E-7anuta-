<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold font-display text-shop-gray-900 mb-8">Mon Panier</h1>

            @if(session('success'))
                <div class="rounded-xl bg-green-50 border border-green-200 p-4 mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if($cart && $cart->items->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cart->items as $item)
                            <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-4 sm:p-6 flex items-center gap-6">
                                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-xl border border-shop-gray-100 bg-shop-gray-50">
                                    @if(count($item->product->images ?? []) > 0)
                                        <img src="{{ $item->product->images[0] }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-shop-gray-300">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 flex flex-col">
                                    <div>
                                        <div class="flex justify-between font-medium text-shop-gray-900">
                                            <h3 class="text-lg font-bold font-display"><a href="{{ route('marketplace.show', $item->product_id) }}">{{ $item->product->name }}</a></h3>
                                            <p class="ml-4">{{ number_format($item->price * $item->quantity, 2) }} MAD</p>
                                        </div>
                                        <p class="mt-1 text-sm text-shop-gray-500">{{ $item->product->category->name ?? 'Article' }}</p>
                                    </div>
                                    <div class="flex-1 flex items-end justify-between text-sm">
                                        <div class="flex items-center gap-2 text-shop-gray-500">
                                            <span>Qté:</span>
                                            <span class="font-medium text-shop-gray-900 bg-shop-gray-50 px-2 py-1 rounded-lg border border-shop-gray-200">{{ $item->quantity }}</span>
                                        </div>

                                        <form action="{{ route('buyer.cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-brand-600 hover:text-brand-500 transition-colors">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 sticky top-24">
                            <h2 class="text-lg font-bold text-shop-gray-900 font-display mb-6">Résumé de la commande</h2>
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-between border-b border-shop-gray-100 pb-4">
                                    <div class="text-sm text-shop-gray-600">Sous-total</div>
                                    <div class="text-sm font-medium text-shop-gray-900">{{ number_format($cart->total_amount, 2) }} MAD</div>
                                </div>
                                <div class="flex items-center justify-between text-base font-bold text-shop-gray-900 pt-2">
                                    <div>Total (TTC)</div>
                                    <div class="text-brand-600">{{ number_format($cart->total_amount, 2) }} MAD</div>
                                </div>
                            </div>

                            <a href="{{ route('buyer.checkout') }}" class="w-full mt-8 bg-brand-600 border border-transparent rounded-xl py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-0.5">
                                Passer la commande
                            </a>
                             <div class="mt-4 text-center">
                                <a href="{{ route('marketplace') }}" class="text-sm font-medium text-shop-gray-500 hover:text-shop-gray-900 hover:underline">
                                    Ou continuer vos achats
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-24 bg-white rounded-2xl shadow-soft border border-shop-gray-100">
                    <div class="w-20 h-20 bg-shop-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="h-10 w-10 text-shop-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold font-display text-shop-gray-900 mb-2">Votre panier est vide</h3>
                    <p class="text-shop-gray-500 mb-8">Découvrez nos produits uniques et remplissez votre panier !</p>
                    <a href="{{ route('marketplace') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                        Commencer à magasiner
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
