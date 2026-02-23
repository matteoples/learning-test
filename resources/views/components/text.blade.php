@php
$sizeClasses = 'text-md tracking-tight';
$weightClasses = $weight->toTailwind();
$style = $color ? "color: {$color};" : '';
@endphp

<p {{ $attributes->merge([
    'class' => "$sizeClasses $weightClasses",
    'style' => $style
]) }}>
    {{ $slot }}
</p>