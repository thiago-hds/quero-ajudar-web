<div class="row">
    <!-- zipcode -->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="address.zipcode">CEP</label>
            <input type="text" class="form-control @error('address.zipcode') is-invalid @enderror" name="address_zipcode" value="{{ old('address.zipcode', isset($address->zipcode) ? $address->zipcode : null) }}">
            @error('address.zip_entry_compressedsize')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- street -->
    <div class="col-sm-6">
        <div class="form-group">
            <label for="address.street">Rua</label>
            <input type="text" class="form-control @error('address.street') is-invalid @enderror" name="address_street" value="{{ old('address.street', isset($address->street) ? $address->street : null) }}">
            @error('address.street')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- number -->
    <div class="col-sm-2">
        <div class="form-group">
            <label for="address.number">Número</label>
            <input type="text" class="form-control @error('address.number') is-invalid @enderror" name="address_number" value="{{ old('address.number', isset($address->number) ? $address->number : null) }}">
            @error('address.number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

</div>

<div class="row">
    <!-- neighborhood -->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="address.neighborhood">Bairro</label>
            <input type="text" class="form-control @error('address.neighborhood') is-invalid @enderror" name="address_neighborhood" value="{{ old('address.neighborhood', isset($address->neighborhood) ? $address->neighborhood : null) }}">
            @error('address.neighborhood')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- state -->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="address_state">Estado</label>
            <select class="form-control select2  @error('address.state') is-invalid @enderror" data-placeholder="Selecione um estado" style="width: 100%;" name="address_state">
                <option></option>
                @foreach($states as $state)
                    <option value="{{ $state->abbr }}"  >
                        {{ $state->name }}
                    </option>
                @endforeach
            </select>

            @error('address.state')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- city -->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="address_city">Cidade</label>
            <select class="form-control select2  @error('address.city') is-invalid @enderror" data-placeholder="Selecione uma cidade" style="width: 100%;" name="address_city">
            </select>

            @error('address.city')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>