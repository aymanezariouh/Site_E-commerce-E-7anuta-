<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Utilisateur - E-7anuta Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">

    <x-admin.sidebar />

    <x-admin.navbar title="Détails Utilisateur" />

    <main class="lg:ml-64 pt-16 min-h-screen">
        <div class="p-6">

            <div class="mb-6">
                <a href="{{ route('admin.users') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Retour à la liste
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm border mb-6">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-3xl font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-gray-600">{{ $user->email }}</p>
                                <div class="mt-2 flex items-center space-x-2">
                                    @if($user->roles->isNotEmpty())
                                        @foreach($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $role->name === 'admin' ? 'bg-red-100 text-red-800' :
                                                   ($role->name === 'moderator' ? 'bg-yellow-100 text-yellow-800' :
                                                   ($role->name === 'seller' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800')) }}">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    @endif

                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Vérifié
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Non vérifié
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Commandes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $user->orders->count() }}</p>
                        </div>
                    </div>
                </div>

                @if($user->hasRole('seller'))
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Produits</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $user->products->count() }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Avis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $user->reviews->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Inscrit le</p>
                            <p class="text-lg font-bold text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border" x-data="{ tab: 'orders' }">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button @click="tab = 'orders'"
                                :class="tab === 'orders' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 border-b-2 font-medium text-sm">
                            Commandes ({{ $user->orders->count() }})
                        </button>

                        @if($user->hasRole('seller'))
                        <button @click="tab = 'products'"
                                :class="tab === 'products' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 border-b-2 font-medium text-sm">
                            Produits ({{ $user->products->count() }})
                        </button>
                        @endif

                        <button @click="tab = 'reviews'"
                                :class="tab === 'reviews' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 border-b-2 font-medium text-sm">
                            Avis ({{ $user->reviews->count() }})
                        </button>
                    </nav>
                </div>

                <div x-show="tab === 'orders'" class="p-6">
                    @if($user->orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($user->orders->take(10) as $order)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">€{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' :
                                                   ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">Aucune commande</p>
                    @endif
                </div>

                @if($user->hasRole('seller'))
                <div x-show="tab === 'products'" class="p-6" style="display: none;">
                    @if($user->products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($user->products->take(12) as $product)
                            <div class="border rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900">{{ $product->name }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $product->sku }}</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-lg font-bold text-gray-900">€{{ number_format($product->price, 2) }}</span>
                                    <span class="text-sm text-gray-500">Stock: {{ $product->stock_quantity }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">Aucun produit</p>
                    @endif
                </div>
                @endif

                <div x-show="tab === 'reviews'" class="p-6" style="display: none;">
                    @if($user->reviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($user->reviews->take(10) as $review)
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
                                </div>
                                <p class="mt-2 text-sm text-gray-700">{{ $review->comment }}</p>
                                @if($review->product)
                                    <p class="mt-2 text-xs text-gray-500">Produit: {{ $review->product->name }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">Aucun avis</p>
                    @endif
                </div>
            </div>
        </div>
    </main>
</body>
</html>
