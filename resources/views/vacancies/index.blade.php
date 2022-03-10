@php
use App\Enums\RecurrenceType;
use App\Enums\StatusType;
@endphp

@extends('layout.index', [
'title' => "Vagas",
'cols' => ['Nome', 'Instituição', 'Causas','Habilidades','Local', 'Tipo', 'Status', 'Ações'],
'collection' => $vacancies
])

@section('fields')
    <div class="row">
        {{-- name --}}
        <x-adminlte-input
            type="text"
            name="name"
            label="Nome"
            fgroup-class="col-sm-6"
            value="{{ request('name') ?? '' }}" />

        {{-- organization --}}
        <x-form.organization-select
            fgroup-class="col-md-6"
            :selected="request('organization_id')" />
    </div>

    <div class="row">
        {{-- cause --}}
        <x-form.causes-select
            fgroup-class="col-sm-6"
            name="cause_id"
            :selectedValues="[request('cause_id')]"
            :multiple="false" />

        {{-- skills --}}
        <x-form.skills-select
            fgroup-class="col-sm-6"
            name="skill_id"
            :selectedValues="[request('skill_id')]"
            :multiple="false" />
    </div>

    <div class="row">
        {{-- state --}}
        <x-adminlte-select
            name="address_state"
            label="Estado"
            fgroup-class="col-sm-4">
            <option></option>
            @foreach ($states as $state)
                <option value="{{ $state->abbr }}"
                    {{ $state->abbr == request('address_state') ? 'selected' : '' }}>
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
            @isset($selectedState)
                @foreach ($selectedState->cities as $city)
                    <option value="{{ $city->id }}"
                        {{ $city->id == request('address_city') ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            @endisset
        </x-adminlte-select>

        {{-- type --}}
        <x-adminlte-select
            name="type"
            label="Tipo"
            fgroup-class="col-sm-2">
            <option></option>
            <option
                value="{{ RecurrenceType::RECURRENT }}"
                {{ request('type') == RecurrenceType::RECURRENT ? 'selected' : '' }}>
                Recorrente
            </option>
            <option
                value="{{ RecurrenceType::UNIQUE_EVENT }}"
                {{ request('type') == RecurrenceType::UNIQUE_EVENT ? 'selected' : '' }}>
                Evento Único
            </option>
        </x-adminlte-select>

        {{-- status --}}
        <x-form.status-select fgroup-class="col-md-2"
            :selectedValue="request('status')" />
    </div>
@endsection
{{-- ['Nome', 'Instituição', 'Causas', 'Habilidades',
    'Local', 'Tipo', 'Status', 'Ações'] --}}
@section('table-rows')
    @foreach ($vacancies as $vacancy)
        <tr>
            <td>
                {{ $vacancy->name }}
            </td>
            <td>{{ $vacancy->organization->name }}</td>
            <td>
                @foreach ($vacancy->causes as $cause)
                    <x-category-badge :category="$cause" />
                @endforeach
            </td>
            <td>
                @foreach ($vacancy->skills as $skill)
                    <x-category-badge :category="$skill" />
                @endforeach
            </td>
            <td>
                {{ $vacancy->getFormattedLocation(false) }}
            </td>
            <td>
                {{ $vacancy->type == RecurrenceType::RECURRENT ? 'Recorrente' : 'Evento Único' }}
            </td>
            <td>
                <x-status-badge :status="$vacancy->status" />
            </td>
            <td>
                @can('update', $vacancy)
                    <a
                        class="btn btn-info btn-sm"
                        href="{{ route('vacancies.edit', $vacancy->id) }}">
                        <i class="fas fa-pencil-alt"></i>
                        Editar
                    </a>
                @endcan
                @can('delete', $vacancy)
                    <button
                        class="btn btn-danger btn-sm btn-delete"
                        data-toggle="modal"
                        data-target="#modal-delete"
                        data-url={{ route('vacancies.destroy', $vacancy->id) }}>
                        <i class="fas fa-trash"></i>
                        Excluir
                    </button>
                @endcan
            </td>
        </tr>
    @endforeach
@endsection
