<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <h2 class="dash-title text-2xl text-slate-800">Ajouter une categorie</h2>
                <p class="text-sm text-slate-600 mt-1">Definissez une nouvelle categorie.</p>
            </section>

            <div class="dash-card px-6 py-6 sm:px-8">
                <form method="POST" action="{{ route('seller.categories.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="name" value="Nom" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" rows="4">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="image" value="Image (URL)" />
                        <x-text-input id="image" name="image" type="text" class="mt-1 block w-full" value="{{ old('image') }}" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-2">
                        <input id="is_active" name="is_active" type="checkbox" value="1" class="rounded border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500" @checked(old('is_active', true))>
                        <label for="is_active" class="text-sm text-slate-600">Categorie active</label>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button class="rounded-lg bg-teal-600 px-4 py-2 text-sm text-white hover:bg-teal-700" type="submit">Enregistrer</button>
                        <a class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 hover:bg-slate-50" href="{{ route('seller.categories.index') }}">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
