@php
$sizeClasses = 'text-lg tracking-tight';
$weightClasses = $weight->toTailwind();
$style = $color ? "color: {$color};" : '';
@endphp

<h3 {{ $attributes->merge([
    'class' => "$sizeClasses $weightClasses",
    'style' => $style
]) }}>
    {{ $slot }}
</h3>