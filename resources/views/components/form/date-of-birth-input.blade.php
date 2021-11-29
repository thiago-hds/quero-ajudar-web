@props([
    'label' => 'Data de Nascimento',
    'name' => 'date_of_birth',
    'value' => '',
])
<x-adminlte-input type="text"
    :name="$name"
    :label="$label"
    fgroup-class="{{ $attributes->get('fgroup-class') }}"
    placeholder='dd/mm/aaaa'
    :value="$value">

    <x-slot name="prependSlot">
        <span class="input-group-text">
            <i class="far fa-calendar-alt"></i>
        </span>
    </x-slot>
</x-adminlte-input>
