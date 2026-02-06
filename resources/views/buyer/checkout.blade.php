<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('buyer.placeOrder') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Order Summary -->
                            <div>
                                <h3 class="text-lg font-medium mb-4">Order Summary</h3>
                                <div class="space-y-2">
                                    @foreach($cart->items as $item)
                                        <div class="flex justify-between">
                                            <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                            <span>${{ $item->total_price }}</span>
                                        </div>
                                    @endforeach
                                    <div class="border-t pt-2 font-bold">
                                        <div class="flex justify-between">
                                            <span>Total:</span>
                                            <span>${{ $cart->total_amount }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div>
                                <h3 class="text-lg font-medium mb-4">Shipping Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                        <input type="text" name="full_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Address</label>
                                        <textarea name="address" required rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">City</label>
                                        <input type="text" name="city" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                                        <input type="text" name="phone" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>