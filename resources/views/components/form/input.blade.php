@props([
    'id',
    'name',
    'type'=> 'text',
    'value' => '',
    'label' => '',
    'placeholder' => '',
    'min' => null,
    'step' => null,
])
<label for="{{ $id }}">{{ $label }}</label>
<input
    type="{{ $type }}"
    id="{{ $id }}"
    name="{{ $name }}"
    value="{{ old($name, $value) }}"
    placeholder="{{ $placeholder }}"
    @if($min !== null) min="{{ $min }}" @endif
    @if($step !== null) step="{{ $step }}" @endif
    {{ $attributes->merge([
        'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
    ]) }}
>
@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror
