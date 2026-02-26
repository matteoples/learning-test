<div {{ $attributes->merge(['class' => $classes])->style($style) }}>
    {{ $slot }}
</div>