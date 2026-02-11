<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 animate-fade-in-up">
            
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold font-display text-shop-gray-900">Nouveau Produit</h2>
                    <p class="mt-1 text-shop-gray-500">Ajoutez un nouvel article à votre catalogue.</p>
                </div>
                <a href="{{ route('seller.stock') }}" class="px-4 py-2 bg-white border border-shop-gray-200 text-shop-gray-700 font-bold rounded-xl hover:bg-shop-gray-50 transition-colors shadow-sm">
                    Retour
                </a>
            </div>

            <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 p-8 space-y-8">
                    <!-- Section: Informations de base -->
                    <div>
                        <h3 class="text-lg font-bold text-shop-gray-900 border-b border-shop-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Informations Générales
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Nom -->
                            <div>
                                <x-input-label for="name" value="Nom du produit" class="text-shop-gray-700 font-bold" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm" value="{{ old('name') }}" placeholder="Ex: T-shirt Vintage Coton Bio" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div>
                                <x-input-label for="description" value="Description détaillée" class="text-shop-gray-700 font-bold" />
                                <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm" placeholder="Décrivez les caractéristiques, matériaux et avantages de votre produit..." required>{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Section: Prix et Stock -->
                    <div>
                        <h3 class="text-lg font-bold text-shop-gray-900 border-b border-shop-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Prix & Inventaire
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Prix -->
                            <div>
                                <x-input-label for="price" value="Prix de vente (MAD)" class="text-shop-gray-700 font-bold" />
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">MAD</span>
                                    </div>
                                    <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="block w-full rounded-xl border-shop-gray-200 pl-12 focus:border-brand-500 focus:ring-brand-500" value="{{ old('price') }}" placeholder="0.00" required />
                                </div>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Prix Barré -->
                            <div>
                                <x-input-label for="compare_at_price" value="Prix d'origine (Optionnel)" class="text-shop-gray-700 font-bold" />
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">MAD</span>
                                    </div>
                                    <x-text-input id="compare_at_price" name="compare_at_price" type="number" step="0.01" min="0" class="block w-full rounded-xl border-shop-gray-200 pl-12 focus:border-brand-500 focus:ring-brand-500" value="{{ old('compare_at_price') }}" placeholder="0.00" />
                                </div>
                                <p class="mt-1 text-xs text-shop-gray-500">Laissez vide si pas de promotion.</p>
                                <x-input-error :messages="$errors->get('compare_at_price')" class="mt-2" />
                            </div>

                            <!-- Stock -->
                            <div>
                                <x-input-label for="stock_quantity" value="Quantité en stock" class="text-shop-gray-700 font-bold" />
                                <x-text-input id="stock_quantity" name="stock_quantity" type="number" min="0" class="mt-1 block w-full rounded-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm" value="{{ old('stock_quantity', 0) }}" required />
                                <x-input-error :messages="$errors->get('stock_quantity')" class="mt-2" />
                            </div>

                            <!-- SKU -->
                            <div>
                                <x-input-label for="sku" value="Code SKU (Référence)" class="text-shop-gray-700 font-bold" />
                                <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full rounded-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm" value="{{ old('sku') }}" placeholder="CODE-123" required />
                                <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Section: Organisation -->
                    <div>
                        <h3 class="text-lg font-bold text-shop-gray-900 border-b border-shop-gray-100 pb-4 mb-6 flex items-center gap-2">
                             <span class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </span>
                            Organisation & Livraison
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Catégorie -->
                            <div class="md:col-span-2">
                                <x-input-label for="category_id" value="Catégorie" class="text-shop-gray-700 font-bold" />
                                <div class="flex gap-2">
                                    <select id="category_id" name="category_id" class="mt-1 block w-full rounded-xl border-shop-gray-200 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                                        <option value="">Sélectionner une catégorie...</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('seller.categories.create') }}" class="mt-1 px-4 py-2 bg-shop-gray-100 text-shop-gray-600 rounded-xl hover:bg-shop-gray-200 transition-colors flex items-center gap-2 whitespace-nowrap font-bold text-sm" title="Nouvelle catégorie">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Créer
                                    </a>
                                </div>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <!-- Poids -->
                            <div>
                                <x-input-label for="weight" value="Poids (kg)" class="text-shop-gray-700 font-bold" />
                                <x-text-input id="weight" name="weight" type="number" step="0.01" min="0" class="mt-1 block w-full rounded-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm" value="{{ old('weight') }}" placeholder="0.5" />
                                <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                            </div>

                            <!-- Dimensions -->
                            <div>
                                <x-input-label for="dimensions" value="Dimensions (L x l x h)" class="text-shop-gray-700 font-bold" />
                                <x-text-input id="dimensions" name="dimensions" type="text" class="mt-1 block w-full rounded-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm" value="{{ old('dimensions') }}" placeholder="30x20x10 cm" />
                                <x-input-error :messages="$errors->get('dimensions')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Section: Images -->
                    <div>
                         <h3 class="text-lg font-bold text-shop-gray-900 border-b border-shop-gray-100 pb-4 mb-6 flex items-center gap-2">
                             <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            Médias
                        </h3>

                        <div class="space-y-4">
                            <!-- File Upload -->
                            <div class="border-2 border-dashed border-shop-gray-200 rounded-xl p-6 hover:bg-shop-gray-50 transition-colors text-center cursor-pointer relative">
                                <input id="images_upload" name="images_upload[]" type="file" accept="image/*" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer text-sm text-slate-700">
                                <div class="pointer-events-none">
                                    <svg class="mx-auto h-12 w-12 text-shop-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="mt-2 text-sm font-medium text-shop-gray-900">Cliquez pour ajouter des images</p>
                                    <p class="text-xs text-shop-gray-500">PNG, JPG jusqu'à 2MB</p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('images_upload')" class="mt-2" />

                            <!-- URL Input (Optional) -->
                             <div>
                                <x-input-label for="images" value="Ou via URLs (séparées par virgule)" class="text-shop-gray-700 font-bold" />
                                <x-text-input id="images" name="images" type="text" class="mt-1 block w-full rounded-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm" value="{{ old('images') }}" placeholder="https://..." />
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Section: Publication -->
                    <div>
                         <h3 class="text-lg font-bold text-shop-gray-900 border-b border-shop-gray-100 pb-4 mb-6 flex items-center gap-2">
                             <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            Publication
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <div>
                                <x-input-label for="status" value="Statut de visibilité" class="text-shop-gray-700 font-bold" />
                                <select id="status" name="status" class="mt-1 block w-full rounded-xl border-shop-gray-200 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                                    <option value="draft" @selected(old('status') === 'draft')>Brouillon</option>
                                    <option value="published" @selected(old('status', 'published') === 'published')>Publié</option>
                                    <option value="archived" @selected(old('status') === 'archived')>Archivé</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                            
                            <div class="flex items-center gap-3 p-4 bg-shop-gray-50 rounded-xl border border-shop-gray-100">
                                <div class="flex items-center h-5">
                                    <input id="is_active" name="is_active" type="checkbox" value="1" class="w-5 h-5 rounded border-shop-gray-300 text-brand-600 shadow-sm focus:ring-brand-500" @checked(old('is_active', true))>
                                </div>
                                <div class="text-sm">
                                    <label for="is_active" class="font-bold text-shop-gray-900">Activer le produit</label>
                                    <p class="text-shop-gray-500 text-xs">Si désactivé, le produit ne sera pas visible sur la boutique, peu importe son statut.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Bottom -->
                    <div class="pt-6 border-t border-shop-gray-100 flex items-center justify-end gap-3" x-data="{ submitting: false }">
                        <a href="{{ route('seller.stock') }}" class="px-6 py-3 bg-white border border-shop-gray-200 text-shop-gray-700 font-bold rounded-xl hover:bg-shop-gray-50 transition-colors shadow-sm">
                            Annuler
                        </a>
                        <button type="submit" @click="submitting = true" class="px-6 py-3 bg-brand-600 text-white font-bold rounded-xl hover:bg-brand-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2" :disabled="submitting">
                             <svg x-show="submitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Enregistrer le produit</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
