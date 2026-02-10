<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-shop-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Marketplace</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased h-full flex flex-col text-shop-gray-800">

    @auth
        @include('layouts.navigation')
    @else
        <!-- Guest Nav for Marketplace (reusing similar style to main nav but simpler) -->
        <nav x-data="{ open: false, scrolled: false }"
             @scroll.window="scrolled = (window.pageYOffset > 20)"
             :class="{ 'bg-white/80 backdrop-blur-md shadow-soft': scrolled, 'bg-white border-b border-shop-gray-200': !scrolled }"
             class="sticky top-0 z-50 transition-all duration-300 ease-in-out">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <a href="{{ route('marketplace') }}" class="flex items-center gap-2 group">
                            <div class="bg-brand-600 text-white p-1.5 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                                </svg>
                            </div>
                            <span class="text-2xl font-bold font-display text-shop-gray-900 tracking-tight">E-7anuta</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-shop-gray-600 hover:text-brand-600 transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-transform hover:scale-105">
                            Register
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <div class="flex-grow">
        <!-- Hero Section -->
        <div class="relative bg-shop-gray-900 overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="" class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-gradient-to-t from-shop-gray-900 via-shop-gray-900/40"></div>
            </div>
            <div class="relative max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-white font-display mb-4">
                    Discover Extraordinary Finds
                </h1>
                <p class="mt-4 max-w-2xl text-xl text-shop-gray-300">
                    Explore our curated marketplace for unique products from trusted sellers.
                </p>
                <div class="mt-8 flex justify-center gap-4">
                    <a href="#products" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-brand-900 bg-brand-400 hover:bg-brand-300 focus:outline-none transition-colors">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Filters -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">
                <h2 class="text-2xl font-bold text-shop-gray-900 font-display mb-4 md:mb-0">Latest Collections</h2>
                
                <div class="flex overflow-x-auto pb-4 md:pb-0 gap-2 no-scrollbar">
                    <a href="{{ route('marketplace') }}" 
                       class="whitespace-nowrap px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ !request('category_id') ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-shop-gray-600 border border-shop-gray-200 hover:bg-shop-gray-50 hover:border-shop-gray-300' }}">
                        All Categories
                    </a>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <a href="{{ route('marketplace', ['category_id' => $category->id]) }}" 
                               class="whitespace-nowrap px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request('category_id') == $category->id ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-shop-gray-600 border border-shop-gray-200 hover:bg-shop-gray-50 hover:border-shop-gray-300' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Product Grid -->
            @if(isset($products) && $products->count() > 0)
                <div id="products" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-2xl shadow-soft hover:shadow-card transition-all duration-300 flex flex-col h-full border border-shop-gray-100 overflow-hidden transform hover:-translate-y-1">
                            <!-- Image Area -->
                            <div class="relative aspect-w-4 aspect-h-3 bg-shop-gray-100 overflow-hidden">
                                @if($product->image_path)
                                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-48 bg-shop-gray-100 flex items-center justify-center text-shop-gray-400">
                                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Overlay Actions -->
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                                    <a href="{{ route('marketplace.show', $product->id) }}" class="bg-white text-shop-gray-900 rounded-full p-2 hover:bg-brand-50 hover:text-brand-600 transition-colors" title="View Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @auth
                                        <form action="{{ route('marketplace.toggleLike', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-white text-red-500 rounded-full p-2 hover:bg-red-50 transition-colors" title="Like">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex-grow flex flex-col">
                                <div class="mb-2">
                                    <span class="text-xs font-semibold tracking-wider text-brand-600 uppercase bg-brand-50 px-2 py-1 rounded-md">
                                        {{ $product->category->name ?? 'Collection' }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-bold text-shop-gray-900 mb-1 line-clamp-1">
                                    <a href="{{ route('marketplace.show', $product->id) }}" class="hover:text-brand-600 transition-colors">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-shop-gray-500 mb-4 line-clamp-2 flex-grow">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                                
                                <div class="flex items-center justify-between pt-4 border-t border-shop-gray-100 mt-auto">
                                    <span class="text-xl font-bold text-shop-gray-900 font-display">
                                        €{{ number_format($product->price, 2) }}
                                    </span>
                                    
                                    @auth
                                        <form action="{{ route('marketplace.addToCart', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 bg-shop-gray-900 text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-brand-600 transition-colors shadow-sm">
                                                <span>Add</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1 bg-shop-gray-900 text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-brand-600 transition-colors shadow-sm">
                                            <span>Add</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-2xl shadow-soft border border-shop-gray-100">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-shop-gray-50 mb-6">
                        <svg class="h-8 w-8 text-shop-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-shop-gray-900 mb-2">No products found</h3>
                    <p class="text-shop-gray-500 max-w-sm mx-auto mb-6">We couldn't find any products in this category at the moment. Check back soon!</p>
                    <a href="{{ route('marketplace') }}" class="text-brand-600 font-medium hover:text-brand-700">Clear filters &rarr;</a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Footer moved to App Layout or kept here if needed for guest view, but app layout handles footer -->
    @include('layouts.footer') 

</body>
</html>
