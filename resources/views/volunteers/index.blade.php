@php
use App\Enums\StatusType;
@endphp

@extends('layout.index', [
'title' => "Voluntários",
'cols' => ['Nome', 'E-mail','Causas','Habilidades', 'Status','Ações'],
'collection' => $volunteers
])

@section('fields')
    <div class="row">
        {{-- name --}}
        <x-adminlte-input
            type="text"
            name="name"
            label="Nome"
            fgroup-class="col-sm-4"
            value="{{ request('name') }}" />

        {{-- email --}}
        <x-form.email-input
            fgroup-class="col-sm-4"
            value="{{ request('email') }}" />

        {{-- status --}}
        <x-form.status-select fgroup-class="col-md-4"
            :selectedValue="request('status')" />
    </div>

    <div class="row">
        {{-- cause --}}
        <x-form.causes-select fgroup-class="col-sm-6" />

        {{-- skill --}}
        <x-form.skills-select fgroup-class="col-sm-6" />
    </div>
@endsection

@section('table-rows')
    @foreach ($volunteers as $volunteer)

        <tr>
            <!-- name -->
            <td>
                {{ $volunteer->user->first_name }} {{ $volunteer->user->last_name }}
            </td>

            <!-- email -->
            <td> {{ $volunteer->user->email }} </td>

            <!-- causes -->
            <td>
                @foreach ($volunteer->causes as $cause)
                    <x-category-badge :category="$cause" />
                @endforeach
            </td>
            <!-- skils -->
            <td>
                @foreach ($volunteer->skills as $skill)
                    <x-category-badge :category="$skill" />
                @endforeach
            </td>

            <!-- status -->
            <td>
                <span
                    class="badge badge-{{ $volunteer->user->status == \App\Enums\StatusType::ACTIVE ? 'success' : 'danger' }}">
                    {{ $volunteer->user->status == \App\Enums\StatusType::ACTIVE ? 'ativo' : 'inativo' }}
                </span>
            </td>

            <!-- actions -->
            <td>
                @can('update', $volunteer)
                    <a
                        class="btn btn-info btn-sm"
                        href="{{ route('users.edit', $volunteer->user_id) }}">
                        <i class="fas fa-pencil-alt"></i>
                        Editar
                    </a>
                @endcan
                @can('delete', $volunteer)
                    <button
                        class="btn btn-danger btn-sm btn-delete"
                        data-toggle="modal"
                        data-target="#modal-delete"
                        data-resource="volunteers"
                        data-id="{{ $volunteer->user_id }}">
                        <i class="fas fa-trash"></i>
                        Excluir
                    </button>
                @endcan
            </td>
        </tr>
        </tbody>
    @endforeach
@endsection
