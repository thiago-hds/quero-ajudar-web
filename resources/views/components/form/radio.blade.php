<div class="form-check">
    <input class="form-check-input" type="radio"
        {{ $attributes->get('checked') ? 'checked=true' : '' }}
        {{ $attributes->except(['label', 'checked']) }} />
    <label class="form-check-label">{{ $attributes->get('label') }}</label>
</div>
