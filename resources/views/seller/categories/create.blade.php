<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 animate-fade-in-up">

            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold font-display text-shop-gray-900">Nouvelle Catégorie</h2>
                    <p class="mt-1 text-shop-gray-500">Ajoutez une section à votre catalogue.</p>
                </div>
                <a href="{{ route('seller.categories.index') }}" class="px-4 py-2 bg-white border border-shop-gray-200 text-shop-gray-700 font-bold rounded-xl hover:bg-shop-gray-50 transition-colors shadow-sm">
                    Retour
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 p-8">
                <form method="POST" action="{{ route('seller.categories.store') }}" class="space-y-6">
                    @csrf

                    <div class="flex items-center gap-4 mb-6 border-b border-shop-gray-100 pb-6">
                        <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-shop-gray-900 font-display">Détails de la catégorie</h3>
                            <p class="text-sm text-shop-gray-500">Informations générales et visibilité.</p>
                        </div>
                    </div>

                    <div class="space-y-6">

                        <div>
                            <x-input-label for="name" value="Nom de la catégorie" class="text-shop-gray-700 font-bold" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm" value="{{ old('name') }}" placeholder="Ex: Électronique" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" value="Description (Optionnel)" class="text-shop-gray-700 font-bold" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm" placeholder="Brève description de cette catégorie...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="image" value="Image de couverture (URL)" class="text-shop-gray-700 font-bold" />
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-shop-gray-200 bg-shop-gray-50 text-shop-gray-500 text-sm">
                                    https://
                                </span>
                                <x-text-input id="image" name="image" type="text" class="flex-1 block w-full rounded-none rounded-r-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500" value="{{ old('image') }}" placeholder="exemple.com/image.jpg" />
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between p-4 bg-shop-gray-50 rounded-xl border border-shop-gray-100">
                             <div>
                                <label for="is_active" class="font-bold text-shop-gray-900">Catégorie Active</label>
                                <p class="text-shop-gray-500 text-xs">Visible par les clients sur la boutique.</p>
                            </div>
                            <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-shop-gray-300 checked:right-0 checked:border-brand-600 transition-all duration-300" @checked(old('is_active', true))/>
                                <label for="is_active" class="toggle-label block overflow-hidden h-6 rounded-full bg-shop-gray-300 cursor-pointer peer-checked:bg-brand-600"></label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-shop-gray-100 flex items-center justify-end gap-3" x-data="{ submitting: false }">
                        <a href="{{ route('seller.categories.index') }}" class="px-6 py-3 bg-white border border-shop-gray-200 text-shop-gray-700 font-bold rounded-xl hover:bg-shop-gray-50 transition-colors shadow-sm">
                            Annuler
                        </a>
                        <button type="submit" @click="submitting = true" class="px-6 py-3 bg-brand-600 text-white font-bold rounded-xl hover:bg-brand-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2" :disabled="submitting">
                             <svg x-show="submitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Créer la catégorie</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
.toggle-checkbox:checked {
            right: 0;
            border-color: #0d9488;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #0d9488;
        }
        .toggle-checkbox {
            right: auto;
            left: 0;
            transition: all 0.3s;
        }
        .toggle-label {
            width: 3rem;
        }
    </style>
</x-app-layout>
