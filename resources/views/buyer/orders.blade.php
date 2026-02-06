<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - My Orders</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    @auth
    <x-buyer-nav />

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($orders->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Order History</h3>
                            <p class="text-sm text-gray-600">Track and manage your orders</p>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="text-lg font-medium text-gray-900">Order #{{ $order->order_number }}</h4>
                                            <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('M d, Y \a\t H:i') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium
                                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                                @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                                @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Order Items Summary -->
                                    <div class="mb-4">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($order->items->take(3) as $item)
                                                @if($item->product)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ $item->product->name }} ({{ $item->quantity }})
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Product deleted ({{ $item->quantity }})
                                                    </span>
                                                @endif
                                            @endforeach
                                            @if($order->items->count() > 3)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    +{{ $order->items->count() - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Status Progress -->
                                    <div class="mb-4">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                <div class="h-2 rounded-full transition-all duration-300
                                                    @if($order->status == 'pending') bg-yellow-500 w-1/4
                                                    @elseif($order->status == 'processing') bg-blue-500 w-2/4
                                                    @elseif($order->status == 'shipped') bg-purple-500 w-3/4
                                                    @elseif($order->status == 'delivered') bg-green-500 w-full
                                                    @else bg-red-500 w-1/4
                                                    @endif"></div>
                                            </div>
                                            <span class="text-xs text-gray-500 min-w-max">
                                                @if($order->status == 'pending') 25%
                                                @elseif($order->status == 'processing') 50%
                                                @elseif($order->status == 'shipped') 75%
                                                @elseif($order->status == 'delivered') 100%
                                                @else 0%
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-600">
                                            @if($order->status == 'pending')
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Order received, preparing for processing
                                                </span>
                                            @elseif($order->status == 'processing')
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-blue-500 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Order is being processed
                                                </span>
                                            @elseif($order->status == 'shipped')
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                                                    </svg>
                                                    Order shipped, on the way
                                                </span>
                                            @elseif($order->status == 'delivered')
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Order delivered successfully
                                                </span>
                                            @else
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            <a href="{{ route('buyer.orderDetails', $order->id) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                View Details
                                            </a>
                                            
                                            @if($order->status == 'delivered' && $order->items->first() && $order->items->first()->product)
                                                <a href="{{ route('marketplace.show', $order->items->first()->product->id) }}#review" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Write Review
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 mb-4">
                            <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No orders yet</h3>
                        <p class="text-gray-500 mb-4">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                        <a href="{{ route('marketplace') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5zM10 12a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            Start Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @else
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Access Denied</h1>
            <p class="text-gray-600 mb-4">You must be logged in to view your orders.</p>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</a>
        </div>
    </div>
    @endauth
</body>
</html>
