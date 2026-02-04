<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produits') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($produits as $produit)
                    <div class="border p-4 rounded-lg shadow">
                        <h3 class="font-semibold text-lg">{{ $produit->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $produit->description }}</p>
                        <p class="mt-2 font-medium">Prix: {{ $produit->prix }} MAD</p>
                        
                        <form action="{{ route('buyer.addToCart', $produit->id) }}" method="POST" class="mt-3">
                            @csrf
                            <input type="number" name="quantite" value="1" min="1" class="border p-1 w-16">
                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                                Ajouter au panier
                            </button>
                        </form>

                        <a href="{{ route('buyer.produits.show', $produit->id) }}" class="text-blue-600 mt-2 inline-block">
                            Voir détails
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
