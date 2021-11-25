@php
use App\Enums\ProfileType;
use App\Enums\StatusType;

$selectedProfile = old('profile', $organization->profile ?? '');
$isAdminSelected = $selectedProfile === ProfileType::ADMIN || !isset($user);
@endphp

@extends('layout.edit', [
'model' => $organization ?? null,
'title' => sprintf("%s %s", isset($organization) ? 'Editar' : 'Nova', "Instituição"),
'action' => isset($organization) ? route('organizations.update', $organization->id) : route('organizations.store'),
'cancelUrl' => route('organizations.index')
])

@section('fields')
    <div class="row">

        {{-- name --}}
        <x-adminlte-input
            type="text"
            name="name"
            label="Nome"
            fgroup-class="col-sm-6"
            value="{{ old('name', $organization->name ?? '') }}"
        />

        {{-- logo --}}
        <x-adminlte-input-file
            name="logo"
            label="Logo"
            fgroup-class="col-sm-6"
            placeholder="Escolha um arquivo..."
            accept=".jpg,.jpeg,.gif,.png"
        >

            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>

        </x-adminlte-input-file>
    </div>

    <div class="row">
        @php
            $selectedOrganizationType = old('organization_type_id', $organization->organization_type_id ?? null);
        @endphp
        <x-adminlte-select
            name="organization_type_id"
            label="Tipo de Instituição"
            fgroup-class="col-sm-6"
        >
            <option></option>
            @foreach ($organizationTypes as $organizationType)
                <option
                    value="{{ $organizationType->id }}"
                    {{ $selectedOrganizationType == $organizationType->id ? 'selected' : '' }}
                >
                    {{ $organizationType->name }}
                </option>
            @endforeach
        </x-adminlte-select>

        <x-causes-select fgroup-class="col-sm-6" />

    </div>

    <div class="row">
        <x-adminlte-textarea
            name="description"
            label="Descrição"
            rows="3"
            fgroup-class="col-sm-12"
        >
            {{ old('description', $organization->description ?? '') }}
        </x-adminlte-textarea>
    </div>

    <div class="row">
        <x-email-input
            fgroup-class="col-md-6"
            value="{{ old('email', $organization->email ?? '') }}"
        />

        <x-adminlte-input
            type="text"
            name="website"
            label="Website"
            fgroup-class="col-sm-6"
            value="{{ old('name', $organization->website ?? '') }}"
        />
    </div>

    @include('address', ['address' => isset($organization->address)?
    $organization->address : null])

    <div class="row">
        {{-- phone --}}
        <x-phone-panel />
    </div>

    <div class="row">

        {{-- profile --}}
        <x-form-group label="Status">
            @php

                $isActive = old('status', $user->status ?? StatusType::ACTIVE) == StatusType::ACTIVE;
            @endphp

            <x-radio
                name="status"
                label="Ativo"
                value="{{ StatusType::ACTIVE }}"
                checked="{{ $isActive }}"
            >
            </x-radio>

            <x-radio
                name="status"
                label="Inativo"
                value="{{ StatusType::INACTIVE }}"
                checked="{{ !$isActive }}"
            >
            </x-radio>

            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </x-form-group>
    </div>

@endsection
