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
        {{-- @dd($selectedValue); --}}
        <option></option>
        <option value="{{ $cause->id }}" {{ in_array($cause->id, $selectedValues) ? 'selected' : '' }}>
            {{ $cause->name }}
        </option>
    @endforeach
</x-adminlte-select2>
