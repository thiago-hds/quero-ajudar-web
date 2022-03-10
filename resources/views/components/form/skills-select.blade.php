@section('plugins.Select2', true)
<x-adminlte-select2
    id="skills"
    name="{{ $attributes->get('name') }}"
    label="Habilidades"
    :config="$config"
    fgroup-class="{{ $attributes->get('fgroup-class') }}">

    <x-slot name="prependSlot">
        <span class="input-group-text">
            <i class="fas fa-fw fa-wrench "></i>
        </span>
    </x-slot>

    @foreach ($skills as $skill)
        {{-- if select2 does't allow multiple it has to have an empty option --}}
        @unless($multiple)
            <option></option>
        @endunless
        <option value="{{ $skill->id }}"
            {{ !$multiple && in_array($skill->id, $selectedValues) ? 'selected' : '' }}>
            {{ $skill->name }}
        </option>
    @endforeach
</x-adminlte-select2>
@if ($multiple)
    @push('scripts')
        <script>
            const selectedSkills = {{ \Illuminate\Support\Js::from($selectedValues) }};
            initSelect2('skills', selectedSkills);
        </script>
    @endpush
@endif
