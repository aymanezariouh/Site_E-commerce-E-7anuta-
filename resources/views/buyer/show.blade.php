<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium">{{ $product->name }}</h3>
                            <p class="text-gray-600 mt-2">{{ $product->description }}</p>
                            <p class="text-sm text-gray-500">Category: {{ $product->category->name ?? 'N/A' }}</p>
                            <p class="text-2xl font-bold text-green-600 mt-4">${{ $product->price }}</p>
                            <p class="text-sm text-gray-500">Stock: {{ $product->stock_quantity }}</p>
                            <p class="text-sm">Rating: {{ number_format($product->average_rating, 1) }}/5 ({{ $product->total_reviews }} reviews)</p>
                            <p class="text-sm">Likes: {{ $product->total_likes }}</p>
                            
                            <!-- Like Button -->
                            <form action="{{ route('buyer.toggleLike', $product->id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="flex items-center space-x-1 {{ $product->isLikedByUser(Auth::id()) ? 'text-red-500' : 'text-gray-500' }} hover:text-red-600">
                                    <svg class="w-5 h-5" fill="{{ $product->isLikedByUser(Auth::id()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span>{{ $product->isLikedByUser(Auth::id()) ? 'Unlike' : 'Like' }}</span>
                                </button>
                            </form>
                        </div>
                        <div>
                            <form action="{{ route('buyer.addToCart', $product->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="mt-8">
                        <h4 class="text-lg font-medium mb-4">Reviews</h4>
                        
                        <!-- Add Review Form -->
                        @if(!$userReview)
                            <form action="{{ route('buyer.addReview', $product->id) }}" method="POST" class="mb-6 p-4 border rounded">
                                @csrf
                                <h5 class="font-medium mb-2">Add Your Review</h5>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Rating</label>
                                    <select name="rating" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Select Rating</option>
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Star</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Comment</label>
                                    <textarea name="comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                </div>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Submit Review
                                </button>
                            </form>
                        @else
                            <div class="mb-6 p-4 border rounded bg-gray-50">
                                <h5 class="font-medium mb-2">Your Review</h5>
                                <p class="text-sm">Rating: {{ $userReview->rating }}/5</p>
                                <p class="text-sm">{{ $userReview->comment }}</p>
                            </div>
                        @endif

                        <!-- Display Reviews -->
                        <div class="space-y-4">
                            @foreach($product->reviews as $review)
                                <div class="border-b pb-4">
                                    <div class="flex justify-between">
                                        <strong>{{ $review->user->name }}</strong>
                                        <span class="text-sm text-gray-500">{{ $review->rating }}/5 stars</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ $review->comment }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $review->created_at->format('M d, Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>