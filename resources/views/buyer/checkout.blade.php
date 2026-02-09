<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Checkout</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    @auth
    <x-buyer-nav />

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
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
    @else
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Access Denied</h1>
            <p class="text-gray-600 mb-4">You must be logged in to checkout.</p>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</a>
        </div>
    </div>
    @endauth
</body>
</html>