<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - E-7anuta Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    {{-- Sidebar --}}
    <x-admin.sidebar />
    
    {{-- Navbar --}}
    <x-admin.navbar title="Gestion des Utilisateurs" />
    
    {{-- Main Content --}}
    <main class="lg:ml-64 pt-16 min-h-screen">
        <div class="p-6">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Gestion des Utilisateurs</h1>
                        <p class="text-gray-600">Gérez les comptes utilisateurs et leurs rôles</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <div class="flex space-x-3">
                            <select class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Tous les rôles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Utilisateurs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->total() }}</p>
                        </div>
                    </div>
                </div>

                @foreach($roles as $role)
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">{{ ucfirst($role->name) }}s</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $role->users->count() }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Users Table --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Liste des Utilisateurs</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inscrit le</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-semibold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->roles->isNotEmpty())
                                        @foreach($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $role->name === 'admin' ? 'bg-red-100 text-red-800' : 
                                                   ($role->name === 'moderator' ? 'bg-yellow-100 text-yellow-800' :
                                                   ($role->name === 'seller' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800')) }}">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-500">Aucun rôle</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->trashed())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Suspendu
                                        </span>
                                    @elseif($user->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Vérifié
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Non vérifié
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2" x-data="{ showRoleModal: false, showDropdown: false }">
                                        {{-- View Button --}}
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 transition-colors duration-200"
                                           title="Voir les détails">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Voir
                                        </a>
                                        
                                        @if(!$user->hasRole('admin'))
                                        {{-- Actions Dropdown --}}
                                        <div class="relative">
                                            <button @click="showDropdown = !showDropdown" 
                                                    class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors duration-200"
                                                    title="Actions">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                </svg>
                                            </button>
                                            
                                            {{-- Dropdown Menu --}}
                                            <div x-show="showDropdown" 
                                                 @click.outside="showDropdown = false"
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95"
                                                 x-transition:enter-end="transform opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="transform opacity-100 scale-100"
                                                 x-transition:leave-end="transform opacity-0 scale-95"
                                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10"
                                                 style="display: none;">
                                                
                                                <div class="py-1">
                                                    <button @click="showRoleModal = true; showDropdown = false" 
                                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 flex items-center">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        Changer le rôle
                                                    </button>
                                                    
                                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="w-full text-left px-4 py-2 text-sm {{ $user->trashed() ? 'text-green-700 hover:bg-green-50' : 'text-yellow-700 hover:bg-yellow-50' }} flex items-center">
                                                            @if($user->trashed())
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                Activer le compte
                                                            @else
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                                </svg>
                                                                Suspendre le compte
                                                            @endif
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Role Change Modal -->
                                        <div x-show="showRoleModal" 
                                             x-cloak
                                             class="fixed inset-0 z-50 overflow-y-auto" 
                                             style="display: none;">
                                            <div class="flex items-center justify-center min-h-screen px-4">
                                                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" 
                                                     @click="showRoleModal = false"></div>
                                                
                                                <div class="relative bg-white rounded-xl shadow-2xl px-6 py-6 max-w-md w-full">
                                                    <div class="flex items-center justify-between mb-4">
                                                        <h3 class="text-xl font-semibold text-gray-900">
                                                            Changer le rôle
                                                        </h3>
                                                        <button @click="showRoleModal = false" class="text-gray-400 hover:text-gray-600">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    
                                                    <p class="text-sm text-gray-600 mb-4">
                                                        Sélectionnez un nouveau rôle pour <strong>{{ $user->name }}</strong>
                                                    </p>
                                                    
                                                    <form method="POST" action="{{ route('admin.users.update-role', $user) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        
                                                        <div class="space-y-2">
                                                            @foreach($roles->where('name', '!=', 'admin') as $role)
                                                            <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all duration-200
                                                                {{ $user->hasRole($role->name) ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 hover:border-indigo-300 hover:bg-gray-50' }}">
                                                                <input type="radio" 
                                                                       name="role" 
                                                                       value="{{ $role->name }}" 
                                                                       {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                                                       class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                                                <div class="ml-3">
                                                                    <span class="text-sm font-semibold text-gray-900">{{ ucfirst($role->name) }}</span>
                                                                    <p class="text-xs text-gray-500">
                                                                        @if($role->name === 'buyer')
                                                                            Peut acheter des produits
                                                                        @elseif($role->name === 'seller')
                                                                            Peut vendre des produits
                                                                        @elseif($role->name === 'moderator')
                                                                            Peut modérer le contenu
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </label>
                                                            @endforeach
                                                        </div>
                                                        
                                                        <div class="mt-6 flex gap-3">
                                                            <button type="submit" 
                                                                    class="flex-1 bg-indigo-600 text-white px-4 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-200">
                                                                Enregistrer
                                                            </button>
                                                            <button type="button" 
                                                                    @click="showRoleModal = false"
                                                                    class="flex-1 bg-gray-100 text-gray-700 px-4 py-2.5 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200">
                                                                Annuler
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    Aucun utilisateur trouvé
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>