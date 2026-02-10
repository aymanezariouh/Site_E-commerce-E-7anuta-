<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Moderate Reviews</title>
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
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Moderate Reviews</h2>

                    @if($reviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($reviews as $review)
                                <div class="border border-gray-200 rounded-lg p-4 {{ !$review->is_approved ? 'bg-red-50' : 'bg-white' }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <span class="font-semibold text-gray-900">{{ $review->user->name }}</span>
                                                <span class="mx-2 text-gray-400">•</span>
                                                <span class="text-sm text-gray-600">{{ $review->created_at->format('M d, Y H:i') }}</span>
                                                @if(!$review->is_approved)
                                                    <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Hidden</span>
                                                @else
                                                    <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Visible</span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex items-center mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="text-lg {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                                @endfor
                                                <span class="ml-2 text-sm text-gray-600">({{ $review->rating }}/5)</span>
                                            </div>

                                            @if($review->comment)
                                                <p class="text-gray-700 mb-2">{{ $review->comment }}</p>
                                            @endif

                                            <div class="text-sm text-gray-500">
                                                <span class="font-medium">Product:</span> 
                                                <a href="{{ route('marketplace.show', $review->product_id) }}" class="text-blue-600 hover:underline">
                                                    {{ $review->product->name }}
                                                </a>
                                            </div>
                                        </div>

                                        <div class="flex space-x-2 ml-4">
                                            @if($review->is_approved)
                                                <form action="{{ route('moderator.reviews.hide', $review->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                                        Hide
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('moderator.reviews.show', $review->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                                                        Show
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('moderator.reviews.delete', $review->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $reviews->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No reviews found.</p>
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
            <p class="text-gray-600 mb-4">You must be logged in as a moderator.</p>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</a>
        </div>
    </div>
    @endauth
</body>
</html>
