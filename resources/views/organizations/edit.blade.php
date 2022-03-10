@php
use App\Enums\ProfileType;
use App\Enums\StatusType;

$selectedProfile = old('profile', $organization->profile ?? '');
$isAdminSelected = $selectedProfile === ProfileType::ADMIN || !isset($user);
$action = isset($organization) ? route('organizations.update', $organization->id) : route('organizations.store');
@endphp


@extends('layout.edit', [
'model' => $organization ?? null,
'title' => sprintf("%s %s", isset($organization) ? 'Editar' : 'Nova', "Instituição"),
'action' => $action,
'cancelUrl' => route('organizations.index')
])
@section('plugins.BsCustomFileInput', true)
@section('fields')
    <div class="row">

        {{-- name --}}
        <x-adminlte-input
            type="text"
            name="name"
            label="Nome"
            fgroup-class="col-sm-6"
            value="{{ old('name', $organization->name ?? '') }}" />

        {{-- logo --}}
        <x-adminlte-input-file
            name="logo"
            label="Logo"
            fgroup-class="col-sm-4"

            placeholder="Escolha uma imagem..."
            accept=".jpg,.jpeg,.gif,.png">

            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>

        </x-adminlte-input-file>

        @if (isset($organization->logo))
            <div class="col-sm-2">
                <img class="img-thumbnail" src="{{ $organization->logo }}" alt="" />
            </div>
        @endif
    </div>

    <div class="row">
        @php
            $selectedOrganizationType = old('organization_type_id', $organization->organization_type_id ?? null);
        @endphp
        <x-adminlte-select
            name="organization_type_id"
            label="Tipo de Instituição"
            fgroup-class="col-sm-6">
            <option></option>
            @foreach ($organizationTypes as $organizationType)
                <option
                    value="{{ $organizationType->id }}"
                    {{ $selectedOrganizationType == $organizationType->id ? 'selected' : '' }}>
                    {{ $organizationType->name }}
                </option>
            @endforeach
        </x-adminlte-select>

        @php
            $selectedValues = old('causes[]', isset($organization) ? $organization->causes->modelKeys() : []);
        @endphp
        <x-form.causes-select name="causes[]" fgroup-class="col-sm-6"
            :selectedValues="$selectedValues" />

    </div>

    <div class="row">
        <x-adminlte-textarea
            name="description"
            label="Descrição"
            rows="3"
            fgroup-class="col-sm-12">
            {{ old('description', $organization->description ?? '') }}
        </x-adminlte-textarea>
    </div>

    <div class="row">
        <x-form.email-input
            fgroup-class="col-md-6"
            value="{{ old('email', $organization->email ?? '') }}" />

        <x-adminlte-input
            type="text"
            name="website"
            label="Website"
            fgroup-class="col-sm-6"
            value="{{ old('name', $organization->website ?? '') }}" />
    </div>

    <x-form.address-panel :address="$organization->address ?? null" />

    <div class="row">
        {{-- phone --}}
        <x-form.phone-panel />
    </div>

    <div class="row">

        {{-- status --}}
        @php
            $isActive = old('status', $user->status ?? StatusType::ACTIVE) == StatusType::ACTIVE;
        @endphp
        <x-form.status-radio-group :isActive="$isActive" />

    </div>

@endsection
