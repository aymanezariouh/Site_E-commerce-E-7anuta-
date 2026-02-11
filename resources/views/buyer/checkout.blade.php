<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold font-display text-shop-gray-900 mb-8 text-center">Checkout</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                 <!-- Order Summary (Left/Top on mobile) -->
                <div class="lg:col-span-1 lg:order-last">
                    <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-shop-gray-900 font-display mb-6">Récapitulatif</h2>
                        <div class="flow-root">
                            <ul class="-my-4 divide-y divide-shop-gray-100">
                                @foreach($cart->items as $item)
                                    <li class="flex items-center py-4 space-x-4">
                                        <div class="flex-shrink-0">
                                            @if($item->product->primary_image)
                                                <img src="{{ $item->product->primary_image }}" alt="{{ $item->product->name }}" class="h-10 w-10 rounded-lg object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-shop-gray-100 flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-shop-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-shop-gray-900 truncate">{{ $item->product->name }}</p>
                                            <p class="text-xs text-shop-gray-500">Qté: {{ $item->quantity }}</p>
                                        </div>
                                        <div class="text-sm font-semibold text-shop-gray-900">
                                            {{ number_format($item->total_price, 2) }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="border-t border-shop-gray-100 mt-6 pt-6 flex items-center justify-between text-base font-bold text-shop-gray-900">
                             <span>Total</span>
                             <span class="text-brand-600">{{ number_format($cart->total_amount, 2) }} MAD</span>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 overflow-hidden">
                        <div class="p-6 sm:p-8">
                            <h2 class="text-xl font-bold text-shop-gray-900 font-display mb-6">Informations de livraison</h2>
                            
                            <form action="{{ route('buyer.placeOrder') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-6">
                                        <label for="full_name" class="block text-sm font-medium text-shop-gray-700">Nom complet</label>
                                        <div class="mt-1">
                                            <input type="text" id="full_name" name="full_name" autocomplete="name" class="block w-full rounded-xl border-shop-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-3" required value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="email" class="block text-sm font-medium text-shop-gray-700">Email</label>
                                        <div class="mt-1">
                                            <input type="email" id="email" name="email" autocomplete="email" class="block w-full rounded-xl border-shop-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-3" required value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="address" class="block text-sm font-medium text-shop-gray-700">Adresse</label>
                                        <div class="mt-1">
                                            <textarea id="address" name="address" rows="3" class="block w-full rounded-xl border-shop-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" required></textarea>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="city" class="block text-sm font-medium text-shop-gray-700">Ville</label>
                                        <div class="mt-1">
                                            <input type="text" id="city" name="city" class="block w-full rounded-xl border-shop-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-3" required>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="phone" class="block text-sm font-medium text-shop-gray-700">Téléphone</label>
                                        <div class="mt-1">
                                            <input type="text" id="phone" name="phone" autocomplete="tel" class="block w-full rounded-xl border-shop-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-3" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-10 pt-6 border-t border-shop-gray-100">
                                    <button type="submit" class="w-full bg-brand-600 border border-transparent rounded-xl py-3 px-4 flex items-center justify-center text-lg font-bold text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-0.5">
                                        Confirmer la commande
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
