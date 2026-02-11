<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="rounded-xl bg-green-50 border border-green-200 p-4 mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                <div class="space-y-4">
                    <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 overflow-hidden relative group">
                        @if($product->primary_image)
                            <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="w-full h-auto object-cover transform group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-96 bg-shop-gray-100 flex items-center justify-center text-shop-gray-400">
                                <svg class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        @auth
                            <div class="absolute top-4 right-4">
                                <form action="{{ route('marketplace.toggleLike', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-white rounded-full p-3 shadow-lg hover:bg-shop-gray-50 transition-colors {{ $product->isLikedByUser(Auth::id()) ? 'text-red-500' : 'text-shop-gray-400 hover:text-red-500' }}">
                                        <svg class="w-6 h-6" fill="{{ $product->isLikedByUser(Auth::id()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>

                <div class="space-y-8">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-50 text-brand-700">
                                {{ $product->category->name ?? 'Collection' }}
                            </span>
                            <div class="flex items-center text-sm text-shop-gray-500">
                                <svg class="w-4 h-4 text-amber-400 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-medium text-shop-gray-900">{{ number_format($product->average_rating, 1) }}</span>
                                <span class="mx-1">·</span>
                                <span>{{ $product->total_reviews }} avis</span>
                            </div>
                        </div>

                        <h1 class="text-4xl font-bold font-display text-shop-gray-900 mb-4">{{ $product->name }}</h1>
                        <p class="text-shop-gray-600 text-lg leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <div class="flex items-end gap-4">
                        <span class="text-4xl font-bold text-shop-gray-900 font-display">{{ number_format($product->price, 2) }} MAD</span>
                        @if($product->compare_at_price)
                            <span class="text-xl text-shop-gray-400 line-through mb-1">{{ number_format($product->compare_at_price, 2) }} MAD</span>
                        @endif
                    </div>

                    <div class="border-t border-b border-shop-gray-100 py-6 space-y-4">
                        <form action="{{ route('marketplace.addToCart', $product->id) }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                            @csrf
                            <div class="w-32">
                                <label for="quantity" class="sr-only">Quantité</label>
                                <div class="relative rounded-xl border border-shop-gray-200 bg-white">
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="block w-full border-0 py-3 pl-4 pr-10 text-shop-gray-900 focus:ring-0 sm:text-sm rounded-xl" placeholder="1">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-shop-gray-400 text-xs">/ {{ $product->stock_quantity }}</span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="flex-1 bg-brand-600 border border-transparent rounded-xl py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-0.5" {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                                {{ $product->stock_quantity < 1 ? 'Rupture de stock' : 'Ajouter au panier' }}
                            </button>
                        </form>
                    </div>

                    <div>
                        <h3 class="text-2xl font-bold font-display text-shop-gray-900 mb-6">Avis Clients</h3>

                        @if(!$userReview && Auth::check())
                            <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 mb-8">
                                <h4 class="text-lg font-bold text-shop-gray-900 mb-4">Donnez votre avis</h4>
                                <form action="{{ route('marketplace.addReview', $product->id) }}" method="POST" id="review">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-shop-gray-700 mb-2">Note</label>
                                        <div class="flex items-center space-x-1" id="star-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" class="star-btn text-2xl text-gray-300 hover:text-amber-400 focus:outline-none transition-colors" data-rating="{{ $i }}">★</button>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="rating-input" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-shop-gray-700 mb-2">Commentaire</label>
                                        <textarea name="comment" rows="3" class="w-full rounded-xl border-shop-gray-200 shadow-sm focus:border-brand-500 focus:ring-brand-500" placeholder="Partagez votre expérience..."></textarea>
                                    </div>
                                    <button type="submit" class="bg-shop-gray-900 text-white rounded-xl py-2 px-6 font-medium hover:bg-black transition-colors">
                                        Publier l'avis
                                    </button>
                                </form>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const stars = document.querySelectorAll('.star-btn');
                                    const ratingInput = document.getElementById('rating-input');

                                    stars.forEach((star, index) => {
                                        star.addEventListener('click', function() {
                                            const rating = parseInt(this.dataset.rating);
                                            ratingInput.value = rating;
                                            updateStars(rating);
                                        });

                                        star.addEventListener('mouseover', function() {
                                            updateStars(parseInt(this.dataset.rating), true);
                                        });

                                        star.addEventListener('mouseleave', function() {
                                            const currentRating = ratingInput.value ? parseInt(ratingInput.value) : 0;
                                            updateStars(currentRating);
                                        });
                                    });

                                    function updateStars(rating, hover = false) {
                                        stars.forEach((s, i) => {
                                             if (i < rating) {
                                                s.classList.remove('text-gray-300');
                                                s.classList.add(hover ? 'text-amber-300' : 'text-amber-400');
                                            } else {
                                                s.classList.remove('text-amber-400', 'text-amber-300');
                                                s.classList.add('text-gray-300');
                                            }
                                        });
                                    }
                                });
                            </script>
                        @endif

                        <div class="space-y-4">
                             @forelse($product->reviews->where('moderation_status', 'approved') as $review)
                                <div class="bg-white rounded-xl p-6 border border-shop-gray-100 shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-shop-gray-100 flex items-center justify-center text-xs font-bold text-shop-gray-500">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                            <span class="font-semibold text-shop-gray-900">{{ $review->user->name }}</span>
                                        </div>
                                        <div class="flex text-amber-400 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating) <span>★</span> @else <span class="text-gray-200">★</span> @endif
                                            @endfor
                                        </div>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-shop-gray-600 text-sm">{{ $review->comment }}</p>
                                    @endif
                                    <p class="text-xs text-shop-gray-400 mt-3">{{ $review->created_at->format('d/m/Y') }}</p>
                                </div>
                             @empty
                                <div class="text-center py-8 bg-shop-gray-50 rounded-2xl border border-shop-gray-100 border-dashed">
                                    <p class="text-shop-gray-500">Aucun avis pour le moment.</p>
                                </div>
                             @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
