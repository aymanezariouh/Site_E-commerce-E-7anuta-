<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold font-display text-shop-gray-900 mb-8 text-center">Checkout</h1>

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1 lg:order-last">
                    <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-shop-gray-900 font-display mb-6">Recapitulatif</h2>
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
                                            <p class="text-xs text-shop-gray-500">Qty: {{ $item->quantity }}</p>
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

                <div class="lg:col-span-2">
                    <form
                        action="{{ route('buyer.placeOrder') }}"
                        method="POST"
                        x-data="{ paymentMethod: @js($stripeConfigured ? old('payment_method', 'cod') : 'cod') }"
                    >
                        @csrf

                        <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 overflow-hidden mb-6">
                            <div class="p-6 sm:p-8">
                                <h2 class="text-xl font-bold text-shop-gray-900 font-display mb-6">Shipping information</h2>

                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-6">
                                        <label for="full_name" class="block text-sm font-medium text-shop-gray-700">Full name</label>
                                        <div class="mt-1">
                                            <input type="text" id="full_name" name="full_name" autocomplete="name" class="block w-full rounded-xl border-shop-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-3" required value="{{ old('full_name', Auth::user()->name) }}">
                                        </div>
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="email" class="block text-sm font-medium text-shop-gray-700">Email</label>
                                        <div class="mt-1">
                                            <input type="email" id="email" name="email" autocomplete="email" class="block w-full rounded-xl border-shop-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-3" required value="{{ old('email', Auth::user()->email) }}">
                                        </div>
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="address" class="block text-sm font-medium text-shop-gray-700">Address</label>
                                        <div class="mt-1">
                                            <textarea id="address" name="address" rows="3" class="block w-full rounded-xl border-shop-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" required>{{ old('address') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="city" class="block text-sm font-medium text-shop-gray-700">City</label>
                                        <div class="mt-1">
                                            <input type="text" id="city" name="city" class="block w-full rounded-xl border-shop-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-3" required value="{{ old('city') }}">
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="phone" class="block text-sm font-medium text-shop-gray-700">Phone</label>
                                        <div class="mt-1">
                                            <input type="text" id="phone" name="phone" autocomplete="tel" class="block w-full rounded-xl border-shop-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-3" required value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 overflow-hidden mb-6">
                            <div class="p-6 sm:p-8">
                                <h2 class="text-xl font-bold text-shop-gray-900 font-display mb-6">Payment method</h2>
                                <input type="hidden" name="payment_method" :value="paymentMethod">

                                <div class="space-y-4">

                                    <label @click="paymentMethod = 'cod'"
                                           class="relative flex items-start p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                                           :class="paymentMethod === 'cod' ? 'border-brand-500 bg-brand-50/50 shadow-sm' : 'border-shop-gray-200 hover:border-shop-gray-300'">
                                        <div class="flex items-center h-5 mt-0.5">
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors"
                                                 :class="paymentMethod === 'cod' ? 'border-brand-600' : 'border-shop-gray-300'">
                                                <div class="w-2.5 h-2.5 rounded-full bg-brand-600 transition-opacity"
                                                     :class="paymentMethod === 'cod' ? 'opacity-100' : 'opacity-0'"></div>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center gap-3">
                                                <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                </div>
                                                <div>
                                                    <span class="text-sm font-bold text-shop-gray-900">Cash on delivery</span>
                                                    <p class="text-xs text-shop-gray-500 mt-0.5">Pay when your order arrives</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <label @click="paymentMethod = 'bank_transfer'"
                                           class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                                           :class="paymentMethod === 'bank_transfer' ? 'border-brand-500 bg-brand-50/50 shadow-sm' : 'border-shop-gray-200 hover:border-shop-gray-300'">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5 mt-0.5">
                                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors"
                                                     :class="paymentMethod === 'bank_transfer' ? 'border-brand-600' : 'border-shop-gray-300'">
                                                    <div class="w-2.5 h-2.5 rounded-full bg-brand-600 transition-opacity"
                                                         :class="paymentMethod === 'bank_transfer' ? 'opacity-100' : 'opacity-0'"></div>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <div class="flex items-center gap-3">
                                                    <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                    </div>
                                                    <div>
                                                        <span class="text-sm font-bold text-shop-gray-900">Bank transfer</span>
                                                        <p class="text-xs text-shop-gray-500 mt-0.5">Transfer to our bank account</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div x-show="paymentMethod === 'bank_transfer'" x-transition class="mt-4 ml-9 p-4 rounded-lg bg-blue-50 border border-blue-100">
                                            <p class="text-xs font-bold text-blue-900 mb-2">Bank details:</p>
                                            <div class="space-y-1 text-xs text-blue-800">
                                                <p><span class="font-medium">Bank:</span> Attijariwafa Bank</p>
                                                <p><span class="font-medium">RIB:</span> 007 780 0001234567890 12</p>
                                                <p><span class="font-medium">Account Name:</span> E-7anuta SARL</p>
                                            </div>
                                            <p class="mt-2 text-xs text-blue-600">Order will be confirmed after transfer reception.</p>
                                        </div>
                                    </label>

                                    @if ($stripeConfigured)
                                        <label @click="paymentMethod = 'card'"
                                               class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                                               :class="paymentMethod === 'card' ? 'border-brand-500 bg-brand-50/50 shadow-sm' : 'border-shop-gray-200 hover:border-shop-gray-300'">
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5 mt-0.5">
                                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors"
                                                         :class="paymentMethod === 'card' ? 'border-brand-600' : 'border-shop-gray-300'">
                                                        <div class="w-2.5 h-2.5 rounded-full bg-brand-600 transition-opacity"
                                                             :class="paymentMethod === 'card' ? 'opacity-100' : 'opacity-0'"></div>
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex-1">
                                                    <div class="flex items-center gap-3">
                                                        <div class="p-2 rounded-lg bg-purple-100 text-purple-600">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                                        </div>
                                                        <div>
                                                            <span class="text-sm font-bold text-shop-gray-900">Card payment (Stripe)</span>
                                                            <p class="text-xs text-shop-gray-500 mt-0.5">You will pay securely on Stripe checkout</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div x-show="paymentMethod === 'card'" x-transition class="mt-4 ml-9 rounded-lg border border-purple-100 bg-purple-50 p-4">
                                                <p class="text-xs font-medium text-purple-900">
                                                    After clicking confirm, you will be redirected to Stripe to complete your payment.
                                                </p>
                                            </div>
                                        </label>
                                    @else
                                        <div class="relative flex flex-col rounded-xl border-2 border-shop-gray-200 bg-shop-gray-50 p-4 opacity-70">
                                            <div class="flex items-center gap-3">
                                                <div class="p-2 rounded-lg bg-purple-100 text-purple-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                                </div>
                                                <div>
                                                    <span class="text-sm font-bold text-shop-gray-700">Card payment (Stripe)</span>
                                                    <p class="text-xs text-red-600 mt-0.5">Unavailable: configure STRIPE_KEY and STRIPE_SECRET in .env</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 overflow-hidden">
                            <div class="p-6 sm:p-8">
                                <button type="submit" class="w-full bg-brand-600 border border-transparent rounded-xl py-3 px-4 flex items-center justify-center text-lg font-bold text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    <span x-text="paymentMethod === 'card' ? 'Pay with Stripe' : 'Confirmer la commande'"></span>
                                </button>
                                <p class="mt-3 text-center text-xs text-shop-gray-500">
                                    By placing your order, you accept our terms and conditions.
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
