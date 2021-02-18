<div class="form-group row">
    <label for="{{ $fieldName }}" class="col-form-label">{{ __($fieldLabel) }}</label>
    <input id="{{ $fieldName }}" type="{{ $fieldType }}" class=" @error($fieldName) is-invalid @enderror"
           name="{{ $fieldName }}"
           value="{{ $fieldValue ?? old($fieldName) }}" autocomplete="{{ $fieldName }}">
</div>
