@section('plugins.Select2', true)
<x-adminlte-select2
    id="causes"
    name="{{ $attributes->get('name') }}"
    label="Causas"
    :config="$config"
    enable-old-support="true"
    fgroup-class="{{ $attributes->get('fgroup-class') }}">

    <x-slot name="prependSlot">
        <span class="input-group-text">
            <i class="fas fa-fw fa-bullhorn "></i>
        </span>
    </x-slot>


    @foreach ($causes as $cause)

        {{-- if select2 is does't allow multiple it has to have an empty option --}}
        @unless($config['multiple'])
            <option></option>
        @endunless ()

        <option
            value="{{ $cause->id }}"
            {{ in_array($cause->id, $selectedValues) ? 'selected=selected' : '' }}>
            {{ $cause->name }}
        </option>
    @endforeach
</x-adminlte-select2>
