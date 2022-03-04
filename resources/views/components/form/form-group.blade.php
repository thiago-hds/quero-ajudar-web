@props(['label'])
<div class="form-group">
    <label class="d-block" for="profile">{{ $label }}</label>
    {{ $slot }}
</div>
