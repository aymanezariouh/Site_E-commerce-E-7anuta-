@props(['headers' => [], 'rows' => [], 'actions' => true, 'pagination' => null])

@php
    $colors = [
        'blue' => 'text-blue-600 hover:text-blue-900',
        'red' => 'text-red-600 hover:text-red-900',
        'green' => 'text-green-600 hover:text-green-900',
        'gray' => 'text-gray-600 hover:text-gray-900',
    ];
@endphp

<div class="bg-white shadow-sm rounded-lg border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            @if(count($headers) > 0)
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($headers as $header)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach

                        @if($actions)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        @endif
                    </tr>
                </thead>
            @endif

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($rows as $row)
                    <tr class="hover:bg-gray-50">
                        @foreach($row['data'] as $cell)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if(is_array($cell) && ($cell['html'] ?? false))
                                    {!! $cell['value'] !!}
                                @else
                                    {{ is_array($cell) ? $cell['value'] : $cell }}
                                @endif
                            </td>
                        @endforeach

                        @if($actions && isset($row['actions']))
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                @foreach($row['actions'] as $action)
                                    @php
                                        $actionColor = $action['color'] ?? 'blue';
                                        $colorClass = $colors[$actionColor] ?? $colors['blue'];
                                    @endphp

                                    @if($action['type'] === 'link')
                                        <a href="{{ $action['url'] }}" class="{{ $colorClass }}">
                                            {{ $action['label'] }}
                                        </a>

                                    @elseif($action['type'] === 'button')
                                        <button type="button" class="{{ $colorClass }}" 
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
                                            <button type="submit" class="{{ $colorClass }}">
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
                            class="px-6 py-4 text-center text-sm text-gray-500">
                            Aucune donnée disponible
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pagination)
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $pagination->links() }}
        </div>
    @endif
</div>