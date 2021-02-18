@props(['value' => ''])
<div class="form-group row">
    <textarea {!! $attributes->merge(['class' => 'form-control']) !!}>{{$value}}</textarea>
</div>
