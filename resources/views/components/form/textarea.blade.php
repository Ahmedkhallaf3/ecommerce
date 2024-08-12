@props([
'type'=>'','name','value'
])
<textarea type="{{ $type }}" name="{{ $name }}"
{{-- class="form-control
@error($name) is-invalid @enderror" --}}
{{ $attributes->class([
'form-control',
'is-invalid'=>$errors->has($name)
]) }}
>
{{ old($name,$value) }}
</textarea>
@error($name)
<div class="text-danger">{{ $message }}</div>
@enderror


