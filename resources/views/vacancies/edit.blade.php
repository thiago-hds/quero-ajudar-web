{{-- @extends('adminlte::page') --}}

@php
use App\Enums\StatusType;
use App\Enums\LocationType;
use App\Enums\RecurrenceType;

$title = sprintf('%s %s', isset($vacancy) ? 'Editar' : 'Nova', 'Vaga');
$action = isset($vacancy) ? route('vacancies.update', $vacancy->id) : route('vacancies.store');

/*
$selectedProfile = old('profile', $user->profile ?? '');
$isAdminSelected = $selectedProfile === ProfileType::ADMIN || !isset($user); */

@endphp

@extends('layout.edit', [
'title' => $title,
'model' => $vacancy ?? null,
'action' => $action,
'cancelUrl' => route('vacancies.index')
])

{{-- <div class="loading">
    <div class="spinner-border text-light" role="status">
        <span class="sr-only"></span>
    </div>
</div> --}}
@section('plugins.BsCustomFileInput', true)
@section('fields')

    <div class="row">
        {{-- name --}}
        <x-adminlte-input
            type="text"
            name="name"
            label="Nome"
            fgroup-class="col-md-6"
            value="{{ old('name', $vacancy->name ?? '') }}" />

        {{-- image --}}

        @if (isset($vacancy) && $vacancy->image)
            <div class="col-md-2">
                <img class="img-fluid" src="{{ $vacancy->image }}" alt="" />
            </div>
        @endisset


        <x-adminlte-input-file
            name="image"
            label="Imagem"
            fgroup-class="col-sm-4"

            placeholder="Escolha uma imagem..."
            accept=".jpg,.jpeg,.gif,.png">

            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>

        </x-adminlte-input-file>
</div>
<div class="row">
    {{-- organization --}}
    <x-form.organization-select fgroup-class="col-md-12"
        :selected="old('organization_id', $vacancy->organization_id ?? null)" />
</div>

<div class="row">
    @php
        $selectedCauses = old('causes[]', isset($vacancy) ? $vacancy->causes->modelKeys() : []);
        $selectedSkills = old('skills[]', isset($vacancy) ? $vacancy->skills->modelKeys() : []);
    @endphp

    <x-form.causes-select name="causes[]" fgroup-class="col-sm-6" :multiple="true"
        :selectedValues="$selectedCauses" />

    <x-form.skills-select name="skills[]" fgroup-class="col-sm-6" :multiple="true"
        :selectedValues="$selectedSkills" />
</div>

<div class="row">
    <x-adminlte-textarea
        name="description"
        label="Descrição"
        rows="3"
        fgroup-class="col-sm-6">
        {{ old('description', $vacancy->description ?? '') }}
    </x-adminlte-textarea>

    <x-adminlte-textarea
        name="tasks"
        label="Tarefas"
        rows="3"
        fgroup-class="col-sm-6">
        {{ old('tasks', $vacancy->tasks ?? '') }}
    </x-adminlte-textarea>
</div>

<div class="row">
    {{-- status --}}
    @php
        $isActive = old('status', $vacancy->status ?? StatusType::ACTIVE) == StatusType::ACTIVE;
    @endphp
    <x-form.status-radio-group :isActive="$isActive" />
</div>

<div class="row">
    {{-- type --}}
    @php
        $selectedRecurrenceType = old('type', $vacancy->type ?? RecurrenceType::RECURRENT);
    @endphp
    <x-form.form-group label="Tipo de Vaga">

        <x-form.radio name="type"
            label="Recorrente"
            value="{{ RecurrenceType::RECURRENT }}"
            checked="{{ $selectedRecurrenceType == RecurrenceType::RECURRENT }}">
        </x-form.radio>

        <x-form.radio name="type"
            label="Evento Único"
            value="{{ RecurrenceType::UNIQUE_EVENT }}"
            checked="{{ $selectedRecurrenceType == RecurrenceType::UNIQUE_EVENT }}">
        </x-form.radio>

        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </x-form.form-group>
</div>

<div class="h5">Horário</div>
<div class="row">

    {{-- date --}}
    <x-adminlte-input type="text"
        name="date"
        label="Data"
        fgroup-class="col-sm-4"
        placeholder='dd/mm/aaaa'
        value="{{ old('date', $vacancy->date ?? '') }}"
        class="date-input" />

    {{-- start_time --}}
    <x-adminlte-input type="text"
        class="hour-input"
        name="start_time"
        label="Horário de Início"
        fgroup-class="col-sm-4"
        placeholder='hh:mm'
        value="{{ old('start_time', $vacancy->start_time ?? '') }}" />

    {{-- end_time --}}
    <x-adminlte-input type="text"
        class="hour-input"
        name="end_time"
        label="Horário de Fim"
        fgroup-class="col-sm-4"
        placeholder='hh:mm'
        value="{{ old('end_time', $vacancy->end_time ?? '') }}" />
</div>

<div class="h5">Local</div>

{{-- location type --}}
@php
$selectedLocationType = old('location_type', $vacancy->location_type ?? LocationType::ORGANIZATION_ADDRESS);
@endphp

<x-form.form-group label="Tipo de Local">

    <x-form.radio name="location_type"
        label="Endereço da Instituição"
        value="{{ LocationType::ORGANIZATION_ADDRESS }}"
        checked="{{ $selectedLocationType == LocationType::ORGANIZATION_ADDRESS }}">
    </x-form.radio>

    <x-form.radio name="location_type"
        label="Endereço Específico"
        value="{{ LocationType::SPECIFIC_ADDRESS }}"
        checked="{{ $selectedLocationType == LocationType::SPECIFIC_ADDRESS }}">
    </x-form.radio>

    <x-form.radio name="location_type"
        label="Remoto"
        value="{{ LocationType::REMOTE }}"
        checked="{{ $selectedLocationType == LocationType::REMOTE }}">
    </x-form.radio>

    <x-form.radio name="location_type"
        label="À combinar"
        value="{{ LocationType::NEGOTIABLE }}"
        checked="{{ $selectedLocationType == LocationType::NEGOTIABLE }}">
    </x-form.radio>

    @error('location_type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</x-form.form-group>


<div id="address-panel" class="{{ $selectedLocationType != LocationType::SPECIFIC_ADDRESS ? 'd-none' : '' }}">
    <x-form.address-panel :address="$vacancy->address ?? null" />
</div>
@endsection
