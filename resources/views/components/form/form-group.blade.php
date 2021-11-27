@props(['label'])
<div class="form-group">
    <label for="profile">{{ $label }}</label>
    {{ $slot }}
</div>
