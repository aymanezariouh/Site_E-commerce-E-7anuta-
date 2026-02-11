<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6">
                <form method="GET" class="flex gap-4">
                    <select name="category_id" class="border rounded px-3 py-2">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="border p-4 rounded-lg shadow">
                        <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $product->description }}</p>
                        <p class="text-sm text-gray-500">Category: {{ $product->category->name ?? 'N/A' }}</p>
                        <p class="mt-2 font-medium text-lg text-green-600">${{ number_format($product->price, 2) }}</p>

                        <div class="mt-2 space-y-1">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-sm {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                @endfor
                                <span class="text-xs text-gray-600 ml-1">
                                    {{ number_format($product->average_rating, 1) }} ({{ $product->total_reviews }})
                                </span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-red-500 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span class="text-xs text-gray-600">{{ $product->total_likes }} likes</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <form action="{{ route('marketplace.addToCart', $product->id) }}" method="POST" class="flex items-center">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="border rounded px-2 py-1 w-16 mr-2">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    Add to Cart
                                </button>
                            </form>

                            <form action="{{ route('marketplace.toggleLike', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 rounded-full transition-colors {{ $product->isLikedByUser(Auth::id()) ? 'text-red-500 bg-red-50' : 'text-gray-400 hover:text-red-500 hover:bg-red-50' }}">
                                    <svg class="w-5 h-5" fill="{{ $product->isLikedByUser(Auth::id()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <a href="{{ route('marketplace.show', $product->id) }}" class="text-blue-600 mt-2 inline-block">
                            View Details
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
