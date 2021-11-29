@php
use App\Enums\ProfileType;
use App\Enums\StatusType;
@endphp

@extends('layout.edit', [
'model' => $volunteer ?? null,
'title' => sprintf("%s %s", isset($volunteer) ? 'Editar' : 'Novo', "Voluntário"),
'action' => isset($volunteer) ? route('volunteers.update', $volunteer->id) : route('volunteers.store'),
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
        <x-adminlte-input
            type="text"
            name="date_of_birth"
            label="Data de Nascimento"
            placeholder="dd/mm/aaaa"
            fgroup-class="col-md-4"
            value="{{ old('date_of_birth', $volunteer->user->date_of_birth ?? '') }}">

            <x-slot name="prependSlot">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </x-slot>
        </x-adminlte-input>

    </div>

    <div class="row">
        {{-- causes --}}
        <x-form.causes-select fgroup-class="col-sm-6" />

        {{-- skills --}}
        <x-form.skills-select fgroup-class="col-sm-6" />
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
@stop

@section('css')
    <link
        rel="stylesheet"
        href="{{ asset('/css/panel.css') }}">
@stop

@section('js')
    <script src="{{ asset('/js/panel.js') }}"></script><s></s>
@stop
