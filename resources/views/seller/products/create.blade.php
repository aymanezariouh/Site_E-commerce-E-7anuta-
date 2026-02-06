<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <h2 class="dash-title text-2xl text-slate-800">Ajouter un produit</h2>
                <p class="text-sm text-slate-600 mt-1">Remplissez les informations du produit.</p>
            </section>

            <div class="dash-card px-6 py-6 sm:px-8">
                <form method="POST" action="{{ route('seller.products.store') }}" class="space-y-4" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <x-input-label for="name" value="Nom" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" rows="4" required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="price" value="Prix (€)" />
                            <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full" value="{{ old('price') }}" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="compare_at_price" value="Prix barré (optionnel)" />
                            <x-text-input id="compare_at_price" name="compare_at_price" type="number" step="0.01" min="0" class="mt-1 block w-full" value="{{ old('compare_at_price') }}" />
                            <x-input-error :messages="$errors->get('compare_at_price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="stock_quantity" value="Stock" />
                            <x-text-input id="stock_quantity" name="stock_quantity" type="number" min="0" class="mt-1 block w-full" value="{{ old('stock_quantity', 0) }}" required />
                            <x-input-error :messages="$errors->get('stock_quantity')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="sku" value="SKU" />
                            <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full" value="{{ old('sku') }}" required />
                            <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="category_id" value="Catégorie" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                                <option value="">Sélectionner</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            <p class="text-xs text-slate-500 mt-1">Besoin d'une catégorie ? <a class="text-teal-600 hover:text-teal-700" href="{{ route('seller.categories.create') }}">Créer une catégorie</a>.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="weight" value="Poids (kg)" />
                            <x-text-input id="weight" name="weight" type="number" step="0.01" min="0" class="mt-1 block w-full" value="{{ old('weight') }}" />
                            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="dimensions" value="Dimensions" />
                            <x-text-input id="dimensions" name="dimensions" type="text" class="mt-1 block w-full" value="{{ old('dimensions') }}" />
                            <x-input-error :messages="$errors->get('dimensions')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="images" value="Images (URLs séparées par virgule)" />
                        <x-text-input id="images" name="images" type="text" class="mt-1 block w-full" value="{{ old('images') }}" />
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="images_upload" value="Images (upload)" />
                        <input id="images_upload" name="images_upload[]" type="file" accept="image/*" multiple class="mt-1 block w-full text-sm text-slate-700">
                        <x-input-error :messages="$errors->get('images_upload')" class="mt-2" />
                        <x-input-error :messages="$errors->get('images_upload.*')" class="mt-2" />
                        <p class="mt-1 text-xs text-slate-500">Jusqu'à 2 Mo par image.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="status" value="Statut" />
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                                <option value="draft" @selected(old('status') === 'draft')>Brouillon</option>
                                <option value="published" @selected(old('status', 'published') === 'published')>Publié</option>
                                <option value="archived" @selected(old('status') === 'archived')>Archivé</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        <div class="flex items-center gap-2 mt-6">
                            <input id="is_active" name="is_active" type="checkbox" value="1" class="rounded border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500" @checked(old('is_active', true))>
                            <label for="is_active" class="text-sm text-slate-600">Produit actif</label>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button class="rounded-lg bg-teal-600 px-4 py-2 text-sm text-white hover:bg-teal-700" type="submit">Enregistrer</button>
                        <a class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 hover:bg-slate-50" href="{{ route('seller.stock') }}">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
