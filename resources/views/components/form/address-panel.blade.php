@php
use App\State;
@endphp

<h5 class="mt-2">Endereço</h5>
<div class="row">

    {{-- zipcode --}}
    <x-adminlte-input
        type="text"
        name="address_zipcode"
        label="CEP"
        fgroup-class="col-sm-4"
        value="{{ old('address_zipcode', $address->zipcode ?? '') }}" />


    {{-- street --}}
    <x-adminlte-input
        type="text"
        name="address_street"
        label="Rua"
        fgroup-class="col-sm-6"
        value="{{ old('address_zipcode', $address->street ?? '') }}" />

    {{-- number --}}
    <x-adminlte-input
        type="text"
        name="address_number"
        label="Número"
        fgroup-class="col-sm-2"
        value="{{ old('address_number', $address->number ?? '') }}" />
</div>

<div class="row">
    {{-- neighborhood --}}
    <x-adminlte-input
        type="text"
        name="address_neighborhood"
        label="Bairro"
        fgroup-class="col-sm-4"
        value="{{ old('address_neighborhood', $address->neighborhood ?? '') }}" />

    {{-- state --}}
    @php
        $selectedStateAbbr = old('address_state', isset($address->city) ? $address->city->state->abbr : null);
    @endphp
    <x-adminlte-select
        name="address_state"
        label="Estado"
        fgroup-class="col-sm-4">
        <option></option>
        @foreach ($states as $state)
            <option value="{{ $state->abbr }}"
                {{ $selectedStateAbbr == $state->abbr ? 'selected' : '' }}>
                {{ $state->name }}
            </option>
        @endforeach
    </x-adminlte-select>

    {{-- city --}}
    <x-adminlte-select
        name="address_city"
        label="Cidade"
        fgroup-class="col-sm-4">
        <option></option>
        @if ($selectedStateAbbr)
            @php
                $state = State::first('abbr', $selectedStateAbbr)
                    ->with('cities')
                    ->first();
                $selectedCity = old('address_city', $address->city->id ?? '');
            @endphp
            @foreach ($state->cities as $city)
                <option value="{{ $city->id }}"
                    {{ $selectedCity == $city->id ? 'selected' : '' }}>
                    {{ $city->name }}
                </option>
            @endforeach
        @endif
    </x-adminlte-select>
</div>
