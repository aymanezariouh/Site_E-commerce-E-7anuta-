@props(['products' => null, 'categories' => null])
@php
    $categories = $categories ?? collect();
    $hasPaginator = $products instanceof \Illuminate\Contracts\Pagination\Paginator
        || $products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    $items = $hasPaginator ? $products : collect($products);
@endphp

<section class="dash-card p-5">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h5 class="dash-title text-lg text-slate-800">Marketplace</h5>
            <p class="text-sm text-slate-500">Découvrez des produits tendances et utiles.</p>
        </div>
        
        <!-- Category Filters -->
        <div class="flex flex-wrap gap-2 text-xs">
            <a href="{{ route('marketplace') }}" 
               class="rounded-full border px-3 py-1 {{ !request('category') ? 'bg-teal-600 text-white border-teal-600' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
                Tout
            </a>
            @if(isset($categories))
                @foreach($categories as $category)
                    <a href="{{ route('marketplace', ['category' => $category->id]) }}" 
                       class="rounded-full border px-3 py-1 {{ request('category') == $category->id ? 'bg-teal-600 text-white border-teal-600' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Sort and Search -->
    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form action="{{ route('marketplace') }}" method="GET" class="flex gap-2">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Rechercher un produit..." 
                   class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm focus:border-teal-500 focus:ring-teal-500">
            <button type="submit" class="rounded-lg bg-teal-600 px-3 py-1.5 text-sm text-white hover:bg-teal-700">
                Rechercher
            </button>
        </form>
        
        <div class="flex items-center gap-2 text-sm">
            <span class="text-slate-500">Trier:</span>
            <a href="{{ route('marketplace', array_merge(request()->query(), ['sort' => 'newest'])) }}" 
               class="{{ request('sort', 'newest') === 'newest' ? 'text-teal-600 font-semibold' : 'text-slate-600 hover:text-slate-800' }}">
                Récent
            </a>
            <span class="text-slate-300">|</span>
            <a href="{{ route('marketplace', array_merge(request()->query(), ['sort' => 'price_low'])) }}" 
               class="{{ request('sort') === 'price_low' ? 'text-teal-600 font-semibold' : 'text-slate-600 hover:text-slate-800' }}">
                Prix ↑
            </a>
            <span class="text-slate-300">|</span>
            <a href="{{ route('marketplace', array_merge(request()->query(), ['sort' => 'price_high'])) }}" 
               class="{{ request('sort') === 'price_high' ? 'text-teal-600 font-semibold' : 'text-slate-600 hover:text-slate-800' }}">
                Prix ↓
            </a>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($items as $product)
            <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <h6 class="font-semibold text-slate-800">{{ $product->name }}</h6>
                        <p class="text-xs text-slate-500">{{ $product->category->name ?? 'Non catégorisé' }}</p>
                    </div>
                    @if($product->created_at->diffInDays(now()) < 7)
                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">Nouveau</span>
                    @elseif($product->stock_quantity <= 5)
                        <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">Stock limité</span>
                    @endif
                </div>
                
                <!-- Product Image -->
                <div class="mt-3 h-32 rounded-lg bg-slate-100 overflow-hidden">
                    @php
                        $image = is_array($product->images) && count($product->images) ? $product->images[0] : null;
                    @endphp
                    @if($image)
                        <img src="{{ $image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <p class="mt-3 text-sm text-slate-600 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                
                <!-- Rating -->
                @if($product->reviews->count() > 0)
                    <div class="mt-2 flex items-center gap-1">
                        <span class="text-amber-500 text-sm">
                            @php $avgRating = $product->reviews->where('moderation_status', 'approved')->avg('rating') ?? 0; @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($avgRating))★@else☆@endif
                            @endfor
                        </span>
                        <span class="text-xs text-slate-500">({{ $product->reviews->where('moderation_status', 'approved')->count() }})</span>
                    </div>
                @endif
                
                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <p class="text-base font-bold text-slate-800">{{ number_format($product->price, 2) }} €</p>
                        <p class="text-xs text-slate-500">
                            @if($product->stock_quantity > 10)
                                En stock
                            @elseif($product->stock_quantity > 0)
                                Plus que {{ $product->stock_quantity }}
                            @else
                                Rupture
                            @endif
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <form action="{{ route('buyer.addToCart', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="rounded-lg bg-teal-600 px-3 py-1 text-xs text-white hover:bg-teal-700">
                                Ajouter
                            </button>
                        </form>
                        <a href="{{ route('buyer.produits.show', $product->id) }}" 
                           class="rounded-lg border border-slate-200 bg-white px-3 py-1 text-xs text-slate-600 hover:bg-slate-50">
                            Voir
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <p class="mt-2 text-slate-500">Aucun produit disponible.</p>
                @if(request('search') || request('category'))
                    <a href="{{ route('marketplace') }}" class="mt-2 inline-block text-teal-600 hover:text-teal-700">
                        Voir tous les produits
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($hasPaginator && $products->hasPages())
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @endif

    <div class="mt-5 flex flex-wrap items-center justify-between gap-3 text-sm">
        <p class="text-slate-500">
            {{ $hasPaginator ? $products->total() : $items->count() }} produit(s) trouvé(s)
        </p>
    </div>
</section>
