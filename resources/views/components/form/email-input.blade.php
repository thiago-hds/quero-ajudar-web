@props([
    'label' => 'Email',
    'name' => 'email',
    'value' => '',
])
<x-adminlte-input
    type="email"
    :name="$name"
    fgroup-class="{{ $attributes->get('fgroup-class') }}"
    :value="$value"
    :label="$label">
    <x-slot name="prependSlot">
        <span class="input-group-text">
            <i class="fa fa-envelope"></i>
        </span>
    </x-slot>
</x-adminlte-input>
