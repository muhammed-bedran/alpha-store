@props([
    'id',
    'name',
    'type'=> 'text',
    'value' => '',
    'label' => '',
    'placeholder' => '',

])
<label for="{{ $id }}">{{ $label }}</label>
<input type="{{ $type}}" class="

form-control
@error($name) is-invalid @enderror

" placeholder="{{ $placeholder }}" name="{{ $name }}" value="{{ old($name, $value) }}" >
@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror
