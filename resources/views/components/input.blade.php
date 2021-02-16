@props(['disabled' => false])
<div class="form-group row">
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control']) !!}>
</div>
