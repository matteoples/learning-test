@php
$baseClasses = 'p-6 rounded-lg border flex flex-col gap-4 transition';
$style = "border-color: var(--box-border);";
@endphp

<div {{ $attributes->merge([
    'class' => $baseClasses
])->style($style) }}>
    {{ $slot }}
</div>