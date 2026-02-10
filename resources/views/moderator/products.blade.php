<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Moderate Products</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    @auth
    <x-moderator-nav />

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Moderate Products</h2>

                    @if($products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($products as $product)
                                        <tr class="{{ !$product->is_active ? 'bg-red-50' : '' }}">
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->category->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                ${{ number_format($product->price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->stock_quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($product->is_active)
                                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Suspended</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route('marketplace.show', $product->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                @if($product->is_active)
                                                    <form action="{{ route('moderator.products.suspend', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Suspend this product?')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Suspend</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('moderator.products.unsuspend', $product->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:text-green-900">Unsuspend</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No products found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endauth
</body>
</html>
