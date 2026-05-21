@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-2">
                <span class="text-red-500">●</span>
                {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
