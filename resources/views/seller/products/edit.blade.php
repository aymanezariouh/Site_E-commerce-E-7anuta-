<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <h2 class="dash-title text-2xl text-slate-800">Modifier le produit</h2>
                <p class="text-sm text-slate-600 mt-1">Mettez a jour les informations.</p>
            </section>

            <div class="dash-card px-6 py-6 sm:px-8">
                <form method="POST" action="{{ route('seller.products.update', $product) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="name" value="Nom" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $product->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="price" value="Prix (€)" />
                            <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full" value="{{ old('price', $product->price) }}" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="stock_quantity" value="Stock" />
                            <x-text-input id="stock_quantity" name="stock_quantity" type="number" min="0" class="mt-1 block w-full" value="{{ old('stock_quantity', $product->stock_quantity) }}" required />
                            <x-input-error :messages="$errors->get('stock_quantity')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="sku" value="SKU" />
                            <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full" value="{{ old('sku', $product->sku) }}" required />
                            <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="category_id" value="Categorie" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                                <option value="">Selectionner</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="weight" value="Poids (kg)" />
                            <x-text-input id="weight" name="weight" type="number" step="0.01" min="0" class="mt-1 block w-full" value="{{ old('weight', $product->weight) }}" />
                            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="dimensions" value="Dimensions" />
                            <x-text-input id="dimensions" name="dimensions" type="text" class="mt-1 block w-full" value="{{ old('dimensions', $product->dimensions) }}" />
                            <x-input-error :messages="$errors->get('dimensions')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="images" value="Images (URLs separees par virgule)" />
                        <x-text-input id="images" name="images" type="text" class="mt-1 block w-full" value="{{ old('images', is_array($product->images) ? implode(', ', $product->images) : '') }}" />
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-2">
                        <input id="is_active" name="is_active" type="checkbox" value="1" class="rounded border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500" @checked(old('is_active', $product->is_active))>
                        <label for="is_active" class="text-sm text-slate-600">Produit actif</label>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button class="rounded-lg bg-teal-600 px-4 py-2 text-sm text-white hover:bg-teal-700" type="submit">Mettre a jour</button>
                        <a class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 hover:bg-slate-50" href="{{ route('seller.stock') }}">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
