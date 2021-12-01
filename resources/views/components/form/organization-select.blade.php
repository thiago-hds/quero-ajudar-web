@section('plugins.Select2', true)
<x-adminlte-select2 id="organization_id" name="organization_id"
    label="Instituição" :config="$config"
    fgroup-class="{{ $attributes->get('fgroup-class') }}">
    <x-slot name="prependSlot">
        <span class="input-group-text">
            <i class="fas fa-fw fa-building "></i>
        </span>
    </x-slot>
    <option></option>
    @foreach ($organizations as $organization)
        <option value="{{ $organization->id }}"
            {{ $organization->id == $selected ? 'selected' : '' }}>
            {{ $organization->name }}
        </option>
    @endforeach
</x-adminlte-select2>
