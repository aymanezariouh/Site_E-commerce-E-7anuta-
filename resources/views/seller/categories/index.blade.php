<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 animate-fade-in-up">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                     <h2 class="text-3xl font-bold font-display text-shop-gray-900 tracking-tight">Catégories</h2>
                    <p class="mt-1 text-shop-gray-500 text-lg">Organisez votre catalogue pour une meilleure navigation.</p>
                </div>
                <a href="{{ route('seller.categories.create') }}" class="px-5 py-3 bg-brand-600 text-white rounded-xl font-bold shadow-lg hover:shadow-xl hover:bg-brand-700 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nouvelle Catégorie
                </a>
            </div>

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="rounded-xl bg-emerald-50 border border-emerald-100 p-4 flex items-center gap-3 animate-fade-in-up">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-emerald-800 text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Categories List -->
            <div class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-shop-gray-100 bg-shop-gray-50/30 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-shop-gray-900 font-display">Toutes les catégories</h3>
                        <p class="text-sm text-shop-gray-500">{{ $categories->count() }} éléments</p>
                    </div>
                    <!-- Optional: Search (could be added here later) -->
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-shop-gray-100">
                        <thead class="bg-shop-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Nom</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Slug</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Statut</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Créé le</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-shop-gray-100">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-shop-gray-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-brand-50 to-brand-100 text-brand-600 flex items-center justify-center font-bold text-lg shadow-sm border border-brand-100 group-hover:scale-110 transition-transform duration-300">
                                                {{ strtoupper(substr($category->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-shop-gray-900 group-hover:text-brand-600 transition-colors">{{ $category->name }}</div>
                                                <div class="text-xs text-shop-gray-500">{{ $category->products_count ?? 0 }} produits associés</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-shop-gray-500 font-mono bg-shop-gray-50 px-2 py-1 rounded inline-block">/{{ $category->slug }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $category->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-shop-gray-100 text-shop-gray-600' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $category->is_active ? 'bg-emerald-500' : 'bg-shop-gray-500' }} mr-1.5"></span>
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-shop-gray-500">
                                        {{ $category->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('seller.categories.edit', $category) }}" class="p-2 text-shop-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all" title="Modifier">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            <form method="POST" action="{{ route('seller.categories.destroy', $category) }}" onsubmit="return confirm('Supprimer cette catégorie ? Cela pourrait impacter les produits associés.');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-shop-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Supprimer">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-shop-gray-500 bg-shop-gray-50/20">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-shop-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-shop-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                            </div>
                                            <p class="text-lg font-bold text-shop-gray-900">Aucune catégorie trouvée</p>
                                            <p class="text-sm text-shop-gray-500 mt-1 max-w-xs">Créez votre première catégorie pour organiser vos produits.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
