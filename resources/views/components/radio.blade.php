<div class="form-check">
    <input class="form-check-input" type="radio"
        {{ $attributes->except('label') }} />
    <label class="form-check-label">{{ $attributes->get('label') }}</label>
</div>
