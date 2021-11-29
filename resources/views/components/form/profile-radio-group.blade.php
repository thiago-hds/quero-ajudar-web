<x-form.form-group label="Perfil">

    <x-form.radio name="profile"
        label="Adminstrador"
        value="{{ \App\Enums\ProfileType::ADMIN }}"
        checked="{{ $isAdminSelected }}">
    </x-form.radio>

    <x-form.radio name="profile"
        label="Organização"
        value="{{ \App\Enums\ProfileType::ORGANIZATION }}"
        checked="{{ !$isAdminSelected }}">
    </x-form.radio>

    @error('profile')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</x-form.form-group>
