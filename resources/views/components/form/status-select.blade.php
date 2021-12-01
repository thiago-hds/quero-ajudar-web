@props([
    'name' => 'status',
    'label' => 'Status',
    'selectedValue' => null,
])

<x-adminlte-select
    name="{{ $name }}"
    label="{{ $label }}"
    fgroup-class="{{ $attributes->get('fgroup-class') }}">
    <option></option>

    <option

        value="{{ \App\Enums\StatusType::ACTIVE }}"
        {{ ($selectedValue ?? '') == \App\Enums\StatusType::ACTIVE ? 'selected' : '' }}>
        Ativo
    </option>
    <option
        value="{{ \App\Enums\StatusType::INACTIVE }}"
        {{ ($selectedValue ?? '') == \App\Enums\StatusType::INACTIVE ? 'selected' : '' }}>
        Inativo
    </option>
</x-adminlte-select>
