@php
use App\Enums\ProfileType;
use App\Enums\StatusType;

@endphp
@extends('layout.index', [
'title' => "Usuários",
'cols' => ['Nome', 'E-mail', 'Perfil','Instituição','Status', 'Ações'],
'collection' => $users
])

@section('fields')
    <div class="row">
        {{-- name --}}
        <x-adminlte-input
            type="text"
            name="name"
            label="Nome"
            fgroup-class="col-sm-4"
            value="{{ $inputs->name ?? '' }}"
        />

        {{-- email --}}
        <x-email-input
            fgroup-class="col-sm-4"
            value="{{ $inputs->email ?? '' }}"
        />

        {{-- perfil --}}
        <x-adminlte-select
            name="profile"
            label="Perfil"
            fgroup-class="col-sm-4"
        >
            <option></option>
            <option
                value="admin"
                {{ isset($inputs->profile) && $inputs->profile == ProfileType::ADMIN ? 'selected' : '' }}
            >
                Administrador
            </option>
            <option
                value="organization"
                {{ isset($inputs->profile) && $inputs->profile == ProfileType::ORGANIZATION ? 'selected' : '' }}
            >
                Instituição
            </option>
        </x-adminlte-select>


    </div>
    <div class="row">

        {{-- organization --}}
        <x-organization-select
            fgroup-class="col-md-6"
            :selected="old('organization_id', $inputs->organization_id ?? null)"
        />

        {{-- status --}}
        <x-adminlte-select
            name="status"
            label="Status"
            fgroup-class="col-sm-6"
        >
            <option></option>
            <option
                value="active"
                {{ isset($inputs->status) && $inputs->status == StatusType::ACTIVE ? 'selected' : '' }}
            >
                Ativo
            </option>
            <option
                value="inactive"
                {{ isset($inputs->status) && $inputs->status == StatusType::INACTIVE ? 'selected' : '' }}
            >
                Inativo
            </option>
        </x-adminlte-select>
    </div>
@endsection
{{-- ['Nome', 'E-mail', 'Perfil', 'Instituição',
    'Status', 'Ações'] --}}
@section('table-rows')
    @foreach ($users as $user)
        <tr>
            <td>
                {{ $user->first_name }}
                {{ $user->last_name }}
            </td>
            <td>{{ $user->email }}</td>
            <td>
                <span class="badge badge-{{ $user->profile == ProfileType::ORGANIZATION ? 'info' : 'warning' }}">
                    {{ $user->profile == ProfileType::ORGANIZATION ? 'instituição' : 'administrador' }}
                </span>
            </td>
            <td>
                {{ $user->profile == ProfileType::ORGANIZATION && isset($user->organization) ? $user->organization->name : 'N/A' }}
            </td>
            <td>
                <span class="badge badge-{{ $user->status == StatusType::ACTIVE ? 'success' : 'danger' }}">
                    {{ $user->status == StatusType::ACTIVE ? 'ativo' : 'inativo' }}
                </span>
            </td>
            <td>
                @can('update', $user)
                    <a
                        class="btn btn-info btn-sm"
                        href="{{ route('users.edit', $user->id) }}"
                    >
                        <i class="fas fa-pencil-alt"></i>
                        Editar
                    </a>
                @endcan
                @can('delete', $user)
                    <button
                        class="btn btn-danger btn-sm"
                        data-toggle="modal"
                        data-target="#modal-delete"
                        onclick="deleteData('users',{{ $user->id }})"
                    >
                        <i class="fas fa-trash"></i>
                        Excluir
                    </button>
                @endcan
            </td>
        </tr>

    @endforeach
@endsection
