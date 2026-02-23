@php
$sizeClasses = 'text-2xl tracking-tight';
$weightClasses = $weight->toTailwind();
$style = $color ? "color: {$color};" : '';
@endphp

<h1 {{ $attributes->merge([
    'class' => "$sizeClasses $weightClasses",
    'style' => $style
]) }}>
    {{ $slot }}
</h1>