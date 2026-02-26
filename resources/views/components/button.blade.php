@php
    $classes = $classes();
@endphp

@if($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => $classes]) }}>
        
        @if($icon)
            <x-icon name="{{ $icon }}" class="w-5 h-5" />
        @endif

        <span>{{ $slot }}</span>
    </a>
@else
    <button
        type="{{ $type ?? 'button' }}"
        @if(!empty($form)) form="{{ $form }}" @endif
        {{ $attributes->merge(['class' => $classes]) }}>
        
        @if($icon)
            <x-icon name="{{ $icon }}" class="w-5 h-5" />
        @endif

        <span>{{ $slot }}</span>
    </button>
@endif