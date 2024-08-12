
@props([
'selected'=>false,'name','value','options'
])

<select name="{{ $name }}"

{{-- {{ $attributes->class([
    'form-control',
    'is-invalid'=>$errors->has($name)
    ]) }} --}}
>
@foreach ($options as $value => $text)
<option value="{{ $value }}" @selected($value==$selected)>{{ $text }}</option>
@endforeach
</select>

{{-- <x-forms.validation-feedback :name="$name"/> --}}
