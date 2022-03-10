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
            value="{{ request('name') ?? '' }}" />

        {{-- email --}}
        <x-form.email-input
            fgroup-class="col-sm-4"
            value="{{ request('email') ?? '' }}" />

        {{-- profile --}}
        <x-form.profile-select
            fgroup-class="col-sm-4"
            selectedValue="{{ request()->user()->isOrganization()
                ? ProfileType::ORGANIZATION
                : request('profile') }}" />

    </div>
    <div class="row">

        {{-- organization --}}
        <x-form.organization-select
            fgroup-class="col-md-6"
            :selected="request()->user()->isOrganization() ? request()->user()->organization_id : request('organization_id')" />

        {{-- status --}}
        <x-form.status-select fgroup-class="col-md-6"
            :selectedValue="request('status')" />
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
                <x-profile-badge :profile="$user->profile" />
            </td>
            <td>
                {{ $user->organization->name ?? 'N/A' }}
            </td>
            <td>
                <x-status-badge :status="$user->status" />
            </td>
            <td>
                @can('update', $user)
                    <a
                        class="btn btn-info btn-sm"
                        href="{{ route('users.edit', $user->id) }}">
                        <i class="fas fa-pencil-alt"></i>
                        Editar
                    </a>
                @endcan
                @can('delete', $user)
                    <button
                        class="btn btn-danger btn-sm btn-delete"
                        data-toggle="modal"
                        data-target="#modal-delete"
                        data-url={{ route('users.destroy', $user->id) }}>
                        <i class="fas fa-trash"></i>
                        Excluir
                    </button>
                @endcan
            </td>
        </tr>
    @endforeach
@endsection
