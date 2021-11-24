<div class="col-sm-6">
    <div class="form-group">
        <label for="phone">Telefones</label>
        <div class="phone-list">
            @if (old('phones', null) || isset($organization->phones))
                @php
                    $phones = isset($organization->phones) ? $organization->phones->pluck('number')->all() : old('phones');
                @endphp
                @foreach ($phones as $key => $phone)
                    <div class="input-group phone-input-group">
                        <input type="text" name="phones[{{ $key }}]"
                            class="form-control phone-input @error('phones.0') is-invalid @enderror"
                            value="{{ $phone }}" />
                        @if ($key > 0)
                            <div class="input-group-prepend">
                                <button class="btn btn-danger btn-remove-phone"
                                    type="button"><i
                                        class="fas fa-times"></i></button>
                            </div>
                        @endif
                    </div>

                @endforeach
            @else
                <div class="input-group phone-input-group">
                    <input type="text" name="phones[0]"
                        class="form-control phone-input @error('phones.0') is-invalid @enderror"
                        placeholder="(99) 999999999" />
                </div>
                @error('phones.0')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            @endif

        </div>
        <button type="button"
            class="btn btn-success btn-sm float-right btn-add-phone"><i
                class="fas fa-plus"></i> Adicionar Telefone </button>
    </div>
</div>
<div class="col-sm-6">

</div>
