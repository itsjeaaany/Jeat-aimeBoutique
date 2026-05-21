@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl bg-green-50 p-4 border border-green-200 font-semibold text-sm text-green-800']) }}>
        {{ $status }}
    </div>
@endif
