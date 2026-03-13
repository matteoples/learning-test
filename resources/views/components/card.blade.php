<div 
    {{ 
        $attributes->merge([
            'class' => $classes . ' ' . ($clickable && !$active ? 'card-hover' : '')
        ])
    }}
    style="border-color: var(--box-border);"
>
    {{ $slot }}
</div>
