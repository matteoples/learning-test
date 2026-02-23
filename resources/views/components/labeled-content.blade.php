@php
    use App\Enums\FontWeight as FW;
    $containerClasses = $containerClasses();
@endphp

<div class="{{ $containerClasses }}">
    @if(!empty($label))
        <x-label color="var(--secondary-text)" :weight="FW::Normal"> 
            {{ $label }} 
        </x-label>
    @endif

    <x-text color="var(--primary-text)" :weight="FW::Medium"> 
        {{ $value !== '' ? $value : '-' }}
    </x-text>
</div>