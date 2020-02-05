<h5>Endereço</h5><br/>
<div class="row">
    <!-- zipcode -->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="address_zipcode">CEP</label>
            <input type="text" class="form-control @error('address_zipcode') is-invalid @enderror" name="address_zipcode" value="{{ old('address_zipcode', isset($address->zipcode) ? $address->zipcode : null) }}">
            @error('address_zipcode')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- street -->
    <div class="col-sm-6">
        <div class="form-group">
            <label for="address_street">Rua</label>
            <input type="text" class="form-control @error('address_street') is-invalid @enderror" name="address_street" value="{{ old('address_street', isset($address->street) ? $address->street : null) }}">
            @error('address_street')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- number -->
    <div class="col-sm-2">
        <div class="form-group">
            <label for="address_number">Número</label>
            <input type="text" class="form-control @error('address_number') is-invalid @enderror" name="address_number" value="{{ old('address_number', isset($address->number) ? $address->number : null) }}">
            @error('address_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

</div>

<div class="row">
    <!-- neighborhood -->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="address_neighborhood">Bairro</label>
            <input type="text" class="form-control @error('address_neighborhood') is-invalid @enderror" name="address_neighborhood" value="{{ old('address_neighborhood', isset($address->neighborhood) ? $address->neighborhood : null) }}">
            @error('address_neighborhood')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- state -->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="address_state">Estado</label>
            <select class="form-control select2  @error('address_state') is-invalid @enderror" data-placeholder="Selecione um estado" style="width: 100%;" name="address_state">
                <option></option>
                @foreach($states as $state)
                    <option value="{{ $state->abbr }}" {{ (old('address_state', isset($address->city)? $address->city->state->abbr : null) == $state->abbr)? 'selected' : '' }}>
                        {{ $state->name }}
                    </option>
                @endforeach
            </select>

            @error('address_state')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- city -->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="address_city">Cidade</label>
            <select class="form-control select2  @error('address_city') is-invalid @enderror" data-placeholder="Selecione uma cidade" style="width: 100%;" name="address_city">

            @php
            $stateAbbr = old('address_state', isset($address->city)? $address->city->state->abbr : null)
            @endphp

            @if($stateAbbr !== null)
                @php
                $state = App\State::where('abbr', $stateAbbr)->first()
                @endphp
                @foreach($state->cities as $city) 
                <option value="{{ $city->id }}" {{ (old('address_city', isset($address->city)? $address->city_id : null) == $city->id)? 'selected' : '' }}>
                    {{ $city->name }}
                </option>

                @endforeach
            @endif

            </select>

            @error('address_city')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>