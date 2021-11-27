<x-form.form-group label="Status">

    <x-form.radio name="status"
        label="Ativo"
        value="{{ \App\Enums\StatusType::ACTIVE }}"
        checked="{{ $isActive }}">
    </x-form.radio>

    <x-form.radio name="status"
        label="Inativo"
        value="{{ \App\Enums\StatusType::INACTIVE }}"
        checked="{{ !$isActive }}">
    </x-form.radio>

    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</x-form.form-group>
