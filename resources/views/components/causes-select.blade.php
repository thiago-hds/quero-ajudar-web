@section('plugins.Select2', true)
<x-adminlte-select2 id="causes" name="causes[]" label="Causas" :config="$config"
    enable-old-support fgroup-class="{{ $attributes->get('fgroup-class') }}">
    <x-slot name="prependSlot">
        <span class="input-group-text">
            <i class="fas fa-fw fa-bullhorn "></i>
        </span>
    </x-slot>

    <option></option>
    @foreach ($causes as $cause)
        <option value="{{ $cause->id }}">
            {{ $cause->name }}
        </option>
    @endforeach
</x-adminlte-select2>
