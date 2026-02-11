<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold font-display text-shop-gray-900">Moderation Utilisateurs</h2>
                    <p class="mt-1 text-shop-gray-500">Gerez les comptes utilisateurs.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="rounded-xl bg-green-50 border border-green-200 p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 overflow-hidden">
                <div class="flex items-center justify-between border-b border-shop-gray-100 px-6 py-4 bg-shop-gray-50/50">
                    <div>
                        <h5 class="text-lg font-bold text-shop-gray-900 font-display">Tous les Utilisateurs</h5>
                        <p class="text-sm text-shop-gray-500">{{ $users->total() }} utilisateurs enregistrés</p>
                    </div>
                </div>
                 
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-shop-gray-100">
                        <thead class="bg-shop-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Utilisateur</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Role</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-shop-gray-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-shop-gray-50/50 transition-colors {{ $user->deleted_at ? 'bg-red-50/30' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-shop-gray-100 flex items-center justify-center text-sm font-bold text-shop-gray-500 mr-3">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div class="font-medium text-shop-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-shop-gray-500">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                            {{ $user->roles->pluck('name')->join(', ') ?: 'Buyer' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->deleted_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Suspendu
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Actif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($user->deleted_at)
                                            <form action="{{ route('moderator.users.unsuspend', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-800 font-medium">Réactiver</button>
                                            </form>
                                        @else
                                            <form action="{{ route('moderator.users.suspend', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Suspendre cet utilisateur ?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Suspendre</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-shop-gray-500">
                                        Aucun utilisateur trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-shop-gray-100 bg-shop-gray-50/50">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
