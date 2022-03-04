@section('plugins.Select2', true)
<x-adminlte-select2
    id="skills"
    name="skills[]"
    label="Habilidades"
    :config="$config"
    enable-old-support
    fgroup-class="{{ $attributes->get('fgroup-class') }}">
    <x-slot name="prependSlot">
        <span class="input-group-text">
            <i class="fas fa-fw fa-wrench "></i>
        </span>
    </x-slot>

    @foreach ($skills as $skill)
        <option value="{{ $skill->id }}">
            {{ $skill->name }}
        </option>
    @endforeach
</x-adminlte-select2>
@push('scripts')
    <script>
        const selectedSkills = {{ \Illuminate\Support\Js::from($selectedValues) }};
        initSelect2('skills', selectedSkills);
    </script>
@endpush
