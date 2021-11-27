@props([
    'label' => 'Senha',
    'name' => 'password',
    'value' => '',
])
<x-adminlte-input type="password"
    :name="$name"
    fgroup-class="{{ $attributes->get('fgroup-class') }}"
    :value="$value"
    :label="$label">

    <x-slot name="prependSlot">
        <span class="input-group-text">
            <i class="fa fa-key"></i>
        </span>
    </x-slot>

</x-adminlte-input>
