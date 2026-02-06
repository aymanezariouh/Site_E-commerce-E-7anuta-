<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Shopping Cart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    @auth
    <x-buyer-nav />

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Shopping Cart</h2>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($cart && $cart->items->count() > 0)
                        <div class="space-y-4">
                            @foreach($cart->items as $item)
                                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg"></div>
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $item->product->category->name ?? 'Uncategorized' }}</p>
                                            <p class="text-sm text-gray-500">Price: ${{ number_format($item->price, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm text-gray-600">Qty:</span>
                                            <span class="font-medium">{{ $item->quantity }}</span>
                                        </div>
                                        <div class="text-lg font-bold text-gray-900">
                                            ${{ number_format($item->price * $item->quantity, 2) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <div class="flex items-center justify-between text-xl font-bold text-gray-900">
                                <span>Total: ${{ number_format($cart->total_amount, 2) }}</span>
                                <div class="space-x-4">
                                    <a href="{{ route('marketplace') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                                        Continue Shopping
                                    </a>
                                    <a href="{{ route('buyer.checkout') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                        Proceed to Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 mb-4">
                                <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
                            <p class="text-gray-500 mb-4">Add some products to your cart to get started.</p>
                            <a href="{{ route('marketplace') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Access Denied</h1>
            <p class="text-gray-600 mb-4">You must be logged in to access your cart.</p>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</a>
        </div>
    </div>
    @endauth
</body>
</html>