@section('plugins.Select2', true)

<x-adminlte-select2
    id="causes"
    name="{{ $attributes->get('name') }}"
    label="Causas"
    :config="$config"
    fgroup-class="{{ $attributes->get('fgroup-class') }}">

    <x-slot name="prependSlot">
        <span class="input-group-text">
            <i class="fas fa-fw fa-bullhorn "></i>
        </span>
    </x-slot>

    @foreach ($causes as $cause)
        {{-- if select2 does't allow multiple it has to have an empty option --}}
        @unless($config['multiple'])
            <option></option>
        @endunless

        <option value="{{ $cause->id }}">
            {{ $cause->name }}
        </option>
    @endforeach
</x-adminlte-select2>
@push('scripts')
    <script>
        const selectedCauses = {{ \Illuminate\Support\Js::from($selectedValues) }};
        initSelect2('causes', selectedCauses);
    </script>
@endpush
