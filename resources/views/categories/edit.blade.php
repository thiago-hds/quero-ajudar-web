@extends('layout.edit', [
'model' => $category ?? null,
'title' => sprintf("%s %s", isset($category) ? 'Editar' : 'Nova', ($type === 'causes'? ' Causa' : ' Habilidade')),
'action' => isset($category->id) ? route($type . '.update', $category->id) : route($type . '.store') ,
'cancelUrl' => route($type . '.index')
])

@section('fields')
    <div class="row">
        {{-- name --}}
        <x-adminlte-input
            type="text"
            name="name"
            label="Nome"
            fgroup-class="col-md-6"
            value="{{ old('name', isset($category->name) ? $category->name : null) }}"
        />

        {{-- icon --}}
        <x-adminlte-input
            type="text"
            name="fontawesome_icon_unicode"
            label="Ícone FontAwesome (unicode)"
            fgroup-class="col-md-4"
            value="{{ old('fontawesome_icon_unicode', isset($category->fontawesome_icon_unicode) ? $category->fontawesome_icon_unicode : null) }}"
        />

        <div class="col-sm-2">
            <div class="form-group">
                <label for="category_icon">Ícone</label>
                <div name="category_icon">
                    <i class="fa">
                        &#x{{ old('fontawesome_icon_unicode', isset($category->fontawesome_icon_unicode) ? $category->fontawesome_icon_unicode : null) }};
                    </i>
                </div>
            </div>
        </div>
    </div>
@endsection
