<x-adminlte-input type="email" name="email" label="E-mail"
    fgroup-class="{{ $attributes->get('fgroup-class') }}"
    {{ $attributes->except('fgroup-class') }}>
    <x-slot name="prependSlot">
        <span class="input-group-text">
            <i class="fa fa-envelope"></i>
        </span>
    </x-slot>
</x-adminlte-input>
