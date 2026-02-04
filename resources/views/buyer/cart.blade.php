<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($cart && $cart->items->count() > 0)
                        <div class="space-y-4">
                            @foreach($cart->items as $item)
                                <div class="flex justify-between items-center border-b pb-4">
                                    <div>
                                        <h4 class="font-medium">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-600">Price: ${{ $item->price }}</p>
                                        <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                    </div>
                                    <div>
                                        <p class="font-medium">${{ $item->total_price }}</p>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="text-right">
                                <p class="text-xl font-bold">Total: ${{ $cart->total_amount }}</p>
                                <a href="{{ route('buyer.checkout') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 inline-block">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">Your cart is empty</p>
                            <a href="{{ route('buyer.produits') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Continue Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>