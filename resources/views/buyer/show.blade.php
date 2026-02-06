<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium">{{ $product->name }}</h3>
                            <p class="text-gray-600 mt-2">{{ $product->description }}</p>
                            <p class="text-sm text-gray-500">Category: {{ $product->category->name ?? 'N/A' }}</p>
                            <p class="text-2xl font-bold text-green-600 mt-4">${{ number_format($product->price, 2) }}</p>
                            <p class="text-sm text-gray-500">Stock: {{ $product->stock_quantity }} available</p>
                            
                            <!-- Rating Display -->
                            <div class="flex items-center mt-3">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-lg {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600 ml-2">
                                    {{ number_format($product->average_rating, 1) }}/5 
                                    ({{ $product->total_reviews }} {{ $product->total_reviews == 1 ? 'review' : 'reviews' }})
                                </span>
                            </div>
                            
                            <!-- Likes Display -->
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">{{ $product->total_likes }} {{ $product->total_likes == 1 ? 'like' : 'likes' }}</span>
                            </div>
                            
                            <!-- Like Button -->
                            <form action="{{ route('buyer.toggleLike', $product->id) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="flex items-center space-x-2 px-4 py-2 rounded-lg border transition-colors {{ $product->isLikedByUser(Auth::id()) ? 'bg-red-50 border-red-200 text-red-600' : 'bg-gray-50 border-gray-200 text-gray-600 hover:bg-red-50 hover:border-red-200 hover:text-red-600' }}">
                                    <svg class="w-5 h-5" fill="{{ $product->isLikedByUser(Auth::id()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $product->isLikedByUser(Auth::id()) ? 'Unlike' : 'Like' }}</span>
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
                            <form action="{{ route('buyer.addReview', $product->id) }}" method="POST" class="mb-6 p-4 border rounded" id="review">
                                @csrf
                                <h5 class="font-medium mb-4">Add Your Review</h5>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                    <div class="flex items-center space-x-1" id="star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none" data-rating="{{ $i }}">
                                                ★
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input" required>
                                    <p class="text-sm text-gray-500 mt-1">Click on stars to rate</p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Comment</label>
                                    <textarea name="comment" rows="3" placeholder="Share your experience with this product..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                </div>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Submit Review
                                </button>
                            </form>
                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const stars = document.querySelectorAll('.star-btn');
                                    const ratingInput = document.getElementById('rating-input');
                                    
                                    stars.forEach((star, index) => {
                                        star.addEventListener('click', function() {
                                            const rating = parseInt(this.dataset.rating);
                                            ratingInput.value = rating;
                                            
                                            stars.forEach((s, i) => {
                                                if (i < rating) {
                                                    s.classList.remove('text-gray-300');
                                                    s.classList.add('text-yellow-400');
                                                } else {
                                                    s.classList.remove('text-yellow-400');
                                                    s.classList.add('text-gray-300');
                                                }
                                            });
                                        });
                                        
                                        star.addEventListener('mouseover', function() {
                                            const rating = parseInt(this.dataset.rating);
                                            stars.forEach((s, i) => {
                                                if (i < rating) {
                                                    s.classList.add('text-yellow-300');
                                                } else {
                                                    s.classList.remove('text-yellow-300');
                                                }
                                            });
                                        });
                                        
                                        star.addEventListener('mouseleave', function() {
                                            stars.forEach(s => s.classList.remove('text-yellow-300'));
                                        });
                                    });
                                });
                            </script>
                        @else
                            <div class="mb-6 p-4 border rounded bg-green-50">
                                <h5 class="font-medium mb-2">Your Review</h5>
                                <div class="flex items-center mb-2">
                                    <span class="text-sm mr-2">Your Rating:</span>
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-lg {{ $i <= $userReview->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                    @endfor
                                    <span class="text-sm ml-2">({{ $userReview->rating }}/5)</span>
                                </div>
                                @if($userReview->comment)
                                    <p class="text-sm text-gray-700">{{ $userReview->comment }}</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-2">Reviewed on {{ $userReview->created_at->format('M d, Y') }}</p>
                            </div>
                        @endif

                        <!-- Display Reviews -->
                        @if($product->reviews->count() > 0)
                            <div class="space-y-4">
                                <h5 class="font-medium text-lg">Customer Reviews ({{ $product->total_reviews }})</h5>
                                @foreach($product->reviews->where('is_approved', true) as $review)
                                    <div class="border-b pb-4 last:border-b-0">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <strong class="text-gray-900">{{ $review->user->name }}</strong>
                                                <div class="flex items-center ml-3">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span class="text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                                    @endfor
                                                    <span class="text-sm text-gray-600 ml-1">({{ $review->rating }}/5)</span>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-400">{{ $review->created_at->format('M d, Y') }}</span>
                                        </div>
                                        @if($review->comment)
                                            <p class="text-gray-700 text-sm leading-relaxed">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>No reviews yet. Be the first to review this product!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>