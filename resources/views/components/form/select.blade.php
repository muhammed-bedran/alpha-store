@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'selected'
])
<label for="{{ $name }}">{{ $label }}</label>
<select class="
form-control
@error('{{ $name }}')
    is-invalid
@enderror
" name="{{ $name }}">
    @foreach ($options as $value => $text )
     <option
      value="{{ $value }}"
    @if($value == old($name, $selected)) selected @endif
      > 
        {{ $text }}
     </option>
    @endforeach
</select>
@error('{{ $name }}')
    <p class="text-danger">{{ $message }}</p>
@enderror
