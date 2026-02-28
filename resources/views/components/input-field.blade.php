@if($isReadonly)
    <div {{ $attributes->merge(['class' => 'input-field bg-gray-100']) }}>
        {{ $value }}
    </div>
@else
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $attributes->merge(['class' => 'input-field']) }}
    />
@endif