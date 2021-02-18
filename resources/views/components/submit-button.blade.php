<div class="form-group row">
    <div {{ $attributes->merge(['class' => 'text-center']) }}>
        <button type="submit" class="btn btn-primary">
            {{ __($buttonLabel) }}
        </button>
        {{ $link ?? '' }}
    </div>
</div>
