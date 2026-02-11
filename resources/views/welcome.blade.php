<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-shop-gray-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-7anuta') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full flex flex-col text-shop-gray-800">

        <header x-data="{ scrolled: false }"
                @scroll.window="scrolled = (window.pageYOffset > 20)"
                :class="{ 'bg-white/80 backdrop-blur-md shadow-soft': scrolled, 'bg-transparent': !scrolled }"
                class="fixed top-0 w-full z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center gap-2">
                             <div class="bg-brand-600 text-white p-1.5 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72l1.189-1.19A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                                </svg>
                            </div>
                            <span class="text-2xl font-bold font-display text-shop-gray-900 tracking-tight">E-7anuta</span>
                        </a>
                    </div>
                    <nav class="hidden md:flex space-x-8">
                        <a href="{{ route('marketplace') }}" class="text-shop-gray-700 hover:text-brand-600 font-medium transition-colors">Shop</a>
                        <a href="#collections" class="text-shop-gray-700 hover:text-brand-600 font-medium transition-colors">Collections</a>
                        <a href="#about" class="text-shop-gray-700 hover:text-brand-600 font-medium transition-colors">About</a>
                    </nav>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-shop-gray-700 hover:text-brand-600 font-medium transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-shop-gray-700 hover:text-brand-600 font-medium transition-colors">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-brand-600 text-white px-5 py-2.5 rounded-full font-medium hover:bg-brand-700 transition-all shadow-md hover:shadow-lg">Start Selling</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow">

            <div class="relative bg-shop-gray-900 overflow-hidden h-screen min-h-[600px] flex items-center">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80" alt="Shop Interior" class="w-full h-full object-cover opacity-40">
                    <div class="absolute inset-0 bg-gradient-to-t from-shop-gray-900 via-shop-gray-900/40 to-transparent"></div>
                </div>

                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="max-w-3xl">
                        <h1 class="text-5xl md:text-7xl font-bold text-white font-display leading-tight mb-6 animate-fade-in-up">
                            Curated Quality for <br>
                            <span class="text-brand-400">Modern Living</span>
                        </h1>
                        <p class="text-xl text-shop-gray-200 mb-10 leading-relaxed max-w-2xl animate-fade-in-up delay-100">
                            Discover a marketplace built on trust and style. From handcrafted goods to premium essentials, find exactly what you're looking for.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up delay-200">
                            <a href="{{ route('marketplace') }}" class="px-8 py-4 bg-white text-shop-gray-900 rounded-full font-bold text-lg hover:bg-shop-gray-100 transition-all shadow-lg transform hover:-translate-y-1 text-center">
                                Shop Now
                            </a>
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-full font-bold text-lg hover:bg-white/10 transition-all text-center">
                                Become a Seller
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <section id="collections" class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-shop-gray-900 font-display mb-4">Curated Collections</h2>
                        <p class="text-lg text-shop-gray-500 max-w-2xl mx-auto">Explore our most popular categories, handpicked for quality and style.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        <div class="group relative rounded-2xl overflow-hidden cursor-pointer shadow-card h-96">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Electronics" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-8">
                                <h3 class="text-2xl font-bold text-white font-display mb-2">Electronics</h3>
                                <p class="text-shop-gray-200 mb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-y-4 group-hover:translate-y-0">Upgrade your tech game with premium gadgets.</p>
                                <a href="{{ route('marketplace') }}" class="inline-flex items-center text-white font-medium hover:underline">
                                    Browse Collection <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </div>
                        </div>

                        <div class="group relative rounded-2xl overflow-hidden cursor-pointer shadow-card h-96">
                            <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Fashion" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-8">
                                <h3 class="text-2xl font-bold text-white font-display mb-2">Fashion</h3>
                                <p class="text-shop-gray-200 mb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-y-4 group-hover:translate-y-0">Timeless pieces for your wardrobe.</p>
                                <a href="{{ route('marketplace') }}" class="inline-flex items-center text-white font-medium hover:underline">
                                    Browse Collection <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </div>
                        </div>

                        <div class="group relative rounded-2xl overflow-hidden cursor-pointer shadow-card h-96">
                            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Home & Living" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-8">
                                <h3 class="text-2xl font-bold text-white font-display mb-2">Home & Living</h3>
                                <p class="text-shop-gray-200 mb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-y-4 group-hover:translate-y-0">Elevate your space with our decor.</p>
                                <a href="{{ route('marketplace') }}" class="inline-flex items-center text-white font-medium hover:underline">
                                    Browse Collection <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

             <section id="about" class="py-24 bg-shop-gray-50 border-y border-shop-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-shop-gray-900 font-display mb-4">Why Shop With E-7anuta?</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                        <div class="p-6">
                            <div class="w-16 h-16 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-shop-gray-900 mb-3">Quality Guaranteed</h3>
                            <p class="text-shop-gray-600">Every item is verified to meet our high standards of quality and authenticity.</p>
                        </div>
                        <div class="p-6">
                            <div class="w-16 h-16 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-shop-gray-900 mb-3">Secure Payments</h3>
                            <p class="text-shop-gray-600">Shop with confidence using our encrypted and secure payment gateways.</p>
                        </div>
                        <div class="p-6">
                            <div class="w-16 h-16 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-shop-gray-900 mb-3">Fast Delivery</h3>
                            <p class="text-shop-gray-600">Get your products delivered to your doorstep quickly and efficiently.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('layouts.footer')
    </body>
</html>
