@php
    $classes = $classes();
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <x-icon name="{{ $icon }}" class="w-5 h-5" />
        @endif
        @if($iconOnly)
            <span class="sr-only">{{ $slot }}</span>
        @else
            {{ $slot }}
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        @if(!empty($form)) form="{{ $form }}" @endif
        {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <x-icon name="{{ $icon }}" class="w-5 h-5" />
        @endif
        @if($iconOnly)
            <span class="sr-only">{{ $slot }}</span>
        @else
            {{ $slot }}
        @endif
    </button>
@endif