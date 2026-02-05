@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-400 bg-green-900/50 p-3 rounded-lg border border-green-800']) }}>
        {{ $status }}
    </div>
@endif
