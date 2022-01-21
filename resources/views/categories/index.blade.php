@php
use App\Enums\StatusType;
@endphp

@extends('layout.index', [
'title' => $type ==='causes' ? 'Causas' : 'Habilidades',
'cols' => ['Nome', 'Ícone','Ações'],
'collection' => $categories
])

@section('fields')
    {{-- name --}}
    <x-adminlte-input
        type="text"
        name="name"
        label="Nome"
        fgroup-class="col-sm-12"
        value="{{ request('name') }}" />
@endsection

@section('table-rows')
    @foreach ($categories as $category)
        <tr>
            <td> {{ $category->name }} </td>
            <td>
                @if ($category->fontawesome_icon_unicode != '')
                    <span class="fa-stack fa-1x">
                        <i class="fa fa-circle fa-stack-2x category-icon-background"></i>
                        <i class="fa fa-stack-1x category-icon">
                            &#x{{ $category->fontawesome_icon_unicode }}; </i>
                    </span>
                @endif
            </td>
            <td>
                @can('update', $category)
                    <a
                        class="btn btn-info btn-sm"
                        href="{{ $type == 'causes' ? route('causes.edit', $category->id) : route('skills.edit', $category->id) }}">
                        <i class="fas fa-pencil-alt"></i> Editar
                    </a>
                @endcan
                @can('delete', $category)
                    <button
                        class="btn btn-danger btn-sm btn-delete"
                        data-toggle="modal"
                        data-target="#modal-delete"
                        data-url={{ route('categories.destroy', $category->id) }}>
                        <i class="fas fa-trash"></i>
                        Excluir
                    </button>
                @endcan
            </td>
        </tr>

    @endforeach
@endsection
