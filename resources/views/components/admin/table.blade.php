@props(['headers' => [], 'rows' => [], 'actions' => true, 'pagination' => null])

@php
    $colors = [
        'blue' => 'text-blue-600 hover:text-blue-900',
        'red' => 'text-red-600 hover:text-red-900',
        'green' => 'text-green-600 hover:text-green-900',
        'gray' => 'text-shop-gray-600 hover:text-shop-gray-900',
        'brand' => 'text-brand-600 hover:text-brand-900',
    ];
@endphp

<div class="bg-white shadow-soft rounded-2xl border border-shop-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-shop-gray-100">
            @if(count($headers) > 0)
                <thead class="bg-shop-gray-50/50">
                    <tr>
                        @foreach($headers as $header)
                            <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">
                                {{ $header }}
                            </th>
                        @endforeach

                        @if($actions)
                            <th class="px-6 py-4 text-right text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">
                                Actions
                            </th>
                        @endif
                    </tr>
                </thead>
            @endif

            <tbody class="bg-white divide-y divide-shop-gray-100">
                @forelse($rows as $row)
                    <tr class="hover:bg-shop-gray-50/50 transition-colors duration-150">
                        @foreach($row['data'] as $cell)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-shop-gray-700">
                                @if(is_array($cell) && ($cell['html'] ?? false))
                                    {!! $cell['value'] !!}
                                @else
                                    {{ is_array($cell) ? $cell['value'] : $cell }}
                                @endif
                            </td>
                        @endforeach

                        @if($actions && isset($row['actions']))
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right space-x-3">
                                @foreach($row['actions'] as $action)
                                    @php
                                        $actionColor = $action['color'] ?? 'blue';
                                        $colorClass = $colors[$actionColor] ?? $colors['blue'];
                                    @endphp

                                    @if($action['type'] === 'link')
                                        <a href="{{ $action['url'] }}" class="{{ $colorClass }} transition-colors">
                                            {{ $action['label'] }}
                                        </a>

                                    @elseif($action['type'] === 'button')
                                        <button type="button" class="{{ $colorClass }} transition-colors"
                                                @if(isset($action['onclick'])) onclick="{{ $action['onclick'] }}" @endif>
                                            {{ $action['label'] }}
                                        </button>

                                    @elseif($action['type'] === 'form')
                                        <form action="{{ $action['url'] }}" method="POST" class="inline-block"
                                            @if(isset($action['confirm'])) onsubmit="return confirm('{{ addslashes($action['confirm']) }}')" @endif>
                                            @csrf
                                            @if(isset($action['method']) && strtoupper($action['method']) !== 'POST')
                                                @method($action['method'])
                                            @endif
                                            <button type="submit" class="{{ $colorClass }} transition-colors">
                                                {{ $action['label'] }}
                                            </button>
                                        </form>
                                    @endif
                                @endforeach
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($headers) + ($actions ? 1 : 0) }}"
                            class="px-6 py-12 text-center text-shop-gray-500 bg-shop-gray-50/30">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-shop-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <span class="text-lg font-medium text-shop-gray-900">Aucune donnée disponible</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pagination)
        <div class="px-6 py-4 border-t border-shop-gray-100 bg-shop-gray-50/30">
            {{ $pagination->links() }}
        </div>
    @endif
</div>