@props([
    'label' => 'Perfil',
    'name' => 'profile',
    'selectedValue' => null,
])
<x-adminlte-select
    name="{{ $name }}"
    label="{{ $label }}"
    fgroup-class="{{ $attributes->get('fgroup-class') }}">
    <option></option>
    <option
        value="{{ \App\Enums\ProfileType::ADMIN }}"
        {{ ($selectedValue ?? '') === \App\Enums\ProfileType::ADMIN ? 'selected' : '' }}>
        Administrador
    </option>
    <option
        value="{{ \App\Enums\ProfileType::ORGANIZATION }}"
        {{ ($selectedValue ?? '') === \App\Enums\ProfileType::ORGANIZATION ? 'selected' : '' }}>
        Instituição
    </option>
</x-adminlte-select>
