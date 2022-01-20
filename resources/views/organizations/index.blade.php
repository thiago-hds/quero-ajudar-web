@php
use App\Enums\StatusType;
@endphp

@extends('layout.index', [
'title' => "Instituições",
'cols' => ['Nome', 'E-mail','Causas','Status', 'Ações'],
'collection' => $organizations
])

@section('fields')
    <div class="row">
        {{-- name --}}
        <x-adminlte-input
            type="text"
            name="name"
            label="Nome"
            fgroup-class="col-sm-6"
            value="{{ request('name') }}" />

        {{-- email --}}
        <x-form.email-input
            fgroup-class="col-sm-6"
            value="{{ request('email') }}" />

    </div>

    <div class="row">

        {{-- cause --}}
        <x-form.causes-select
            fgroup-class="col-sm-6"
            name="cause_id"
            :selectedValues="[request('cause_id')]"
            :multiple="false" />

        {{-- status --}}
        <x-form.status-select fgroup-class="col-md-6"
            :selectedValue="request('status')" />
    </div>
@endsection
{{-- ['Nome', 'E-mail', 'Perfil', 'Instituição',
    'Status', 'Ações'] --}}
@section('table-rows')
    @foreach ($organizations as $organization)

        <tr>
            <td>
                {{ $organization->name }}
            </td>
            <td>{{ $organization->email }}</td>
            <td>
                @foreach ($organization->causes as $cause)
                    <x-category-badge :category="$cause" />
                @endforeach
            </td>
            <!-- status -->
            <td>
                <x-status-badge :status="$organization->status" />
            </td>

            <!-- actions -->
            <td>
                <a
                    class="btn btn-info btn-sm"
                    href="{{ route('organizations.edit', $organization->id) }}">
                    <i class="fas fa-pencil-alt"></i> Editar
                </a>

                <button
                    class="btn btn-danger btn-sm btn-delete"
                    data-toggle="modal"
                    data-target="#modal-delete"
                    data-resource="organizations"
                    data-id="{{ $organization->id }}">
                    <i class="fas fa-trash"></i>
                    Excluir
                </button>
            </td>
        </tr>

    @endforeach
@endsection
