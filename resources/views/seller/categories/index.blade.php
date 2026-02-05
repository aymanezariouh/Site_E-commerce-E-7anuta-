<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <h2 class="dash-title text-2xl text-slate-800">Categories</h2>
                <p class="text-sm text-slate-600 mt-1">Gerez les categories de produits.</p>
            </section>

            <div class="dash-card px-6 py-6 sm:px-8">
                <div class="flex items-center justify-between">
                    <h3 class="dash-title text-lg text-slate-800">Liste des categories</h3>
                    <a class="rounded-lg bg-teal-600 px-3 py-1.5 text-sm text-white hover:bg-teal-700" href="{{ route('seller.categories.create') }}">Creer</a>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="text-left px-3 py-2 font-semibold">Nom</th>
                                <th class="text-left px-3 py-2 font-semibold">Statut</th>
                                <th class="text-left px-3 py-2 font-semibold">Cree</th>
                                <th class="text-left px-3 py-2 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-600">
                            @forelse ($categories as $category)
                                <tr class="border-t border-slate-200">
                                    <td class="px-3 py-3 font-medium text-slate-800">{{ $category->name }}</td>
                                    <td class="px-3 py-3">
                                        <span class="rounded-full px-2 py-1 text-xs {{ $category->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3">{{ $category->created_at?->format('d/m/Y') }}</td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <a class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-xs text-slate-600 hover:bg-slate-50" href="{{ route('seller.categories.edit', $category) }}">Modifier</a>
                                            <form method="POST" action="{{ route('seller.categories.destroy', $category) }}" onsubmit="return confirm('Supprimer cette categorie ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-xs text-slate-600 hover:bg-slate-50" type="submit">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t border-slate-200">
                                    <td class="px-3 py-3" colspan="4">Aucune categorie pour le moment.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
