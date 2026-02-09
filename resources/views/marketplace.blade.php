<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Marketplace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    {{-- Navigation --}}
    @auth
        <x-buyer-nav />
    @else
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('marketplace') }}" class="text-xl font-bold text-gray-800">
                            E-7anuta
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Register</a>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Marketplace</h2>
                        <p class="text-gray-600">Découvrez nos produits par catégorie</p>
                    </div>

                    <!-- Filtres par catégorie -->
                    <div class="mb-6">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('marketplace') }}" class="px-4 py-2 rounded-full border {{ !request('category_id') ? 'bg-blue-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">Toutes</a>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <a href="{{ route('marketplace', ['category_id' => $category->id]) }}" class="px-4 py-2 rounded-full border {{ request('category_id') == $category->id ? 'bg-blue-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    @if(isset($products) && $products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($products as $product)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                    <div class="p-4">
                                        <div class="h-48 bg-gray-100 rounded-lg mb-4"></div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                                        <p class="text-sm text-gray-600 mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                        <p class="text-gray-700 text-sm mb-4">{{ Str::limit($product->description, 100) }}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-xl font-bold text-gray-900">€{{ number_format($product->price, 2) }}</span>
                                            <div class="flex space-x-2">
                                                @auth
                                                    <form action="{{ route('marketplace.addToCart', $product->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                                            Panier
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('marketplace.toggleLike', $product->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="bg-red-100 text-red-600 px-3 py-1 rounded text-sm hover:bg-red-200">
                                                            ♥
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                                        Panier
                                                    </a>
                                                @endauth
                                                <a href="{{ route('marketplace.show', $product->id) }}" class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300">
                                                    Voir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 mb-4">
                                <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun produit disponible</h3>
                            <p class="text-gray-500">Revenez plus tard pour de nouveaux produits.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>