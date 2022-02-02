@php
use App\Enums\ProfileType;
use App\Enums\StatusType;
@endphp

@extends('layout.edit', [
'model' => $volunteer ?? null,
'title' => sprintf("%s %s", isset($volunteer) ? 'Editar' : 'Novo', "Voluntário"),
'action' => isset($volunteer) ? route('volunteers.update', $volunteer->user_id) : route('volunteers.store'),
'cancelUrl' => route('volunteers.index')
])

@section('fields')

    <div class="row">
        {{-- first_name --}}
        <x-adminlte-input
            type="text"
            name="first_name"
            label="Nome"
            fgroup-class="col-sm-4"
            value="{{ old('first_name', $volunteer->user->first_name ?? '') }}" />

        {{-- last_name --}}
        <x-adminlte-input
            type="text"
            name="last_name"
            label="Sobrenome"
            fgroup-class="col-sm-4"
            value="{{ old('last_name', $volunteer->user->last_name ?? '') }}" />

        {{-- date_of_birth --}}
        <x-form.date-of-birth-input
            fgroup-class="col-md-4"
            value="{{ old('date_of_birth', $volunteer->user->date_of_birth ?? '') }}" />

    </div>

    <div class="row">
        {{-- causes --}}
        @php
            $selectedCauses = old('causes[]', isset($volunteer) ? $volunteer->causes->modelKeys() : []);
        @endphp
        <x-form.causes-select name="causes[]" fgroup-class="col-sm-6" :multiple="true"
            :selectedValues="$selectedCauses" />

        {{-- skills --}}
        <x-form.skills-select name="skills[]" fgroup-class="col-sm-6" />
    </div>

    <div class="row">

        {{-- email --}}
        <x-form.email-input
            fgroup-class="col-md-4"
            value="{{ old('email', $volunteer->user->email ?? '') }}" />

        {{-- password --}}
        <x-adminlte-input
            type="password"
            name="password"
            label="Senha"
            fgroup-class="col-md-4"
            value="{{ $volunteer->user->password ?? '' }}">

            <x-slot name="prependSlot">
                <span class="input-group-text">
                    <i class="fa fa-key"></i>
                </span>
            </x-slot>

        </x-adminlte-input>

        {{-- password confirmation --}}
        <x-adminlte-input
            type="password"
            name="password_confirm"
            label="Confirmação de Senha"
            fgroup-class="col-md-4"
            placeholder="Repita a senha"
            value="{{ $volunteer->user->password ?? '' }}">

            <x-slot name="prependSlot">
                <span class="input-group-text">
                    <i class="fa fa-key"></i>
                </span>
            </x-slot>

        </x-adminlte-input>
    </div>

    {{-- status --}}
    @php
    $isActive = old('status', $volunteer->user->status ?? StatusType::ACTIVE) === StatusType::ACTIVE;
    @endphp
    <x-form.status-radio-group :isActive="$isActive" />
@endsection
