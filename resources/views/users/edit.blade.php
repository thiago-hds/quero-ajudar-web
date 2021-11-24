@extends('layout.edit', [
'model' => $user ?? null,
'action' => isset($user->id) ? route('users.update', $user->id) :
route('users.store'),
'cancelUrl' => route('users.index')
])

@php
$selectedProfile = old('profile', $user->profile ?? '');
$isAdminSelected = $selectedProfile === \App\Enums\ProfileType::ADMIN || !isset($user);
@endphp

@section('fields')
    <div class="row">

        {{-- first name --}}
        <x-adminlte-input type="text" name="first_name" label="Nome"
            fgroup-class="col-md-4"
            value="{{ old('first_name', $user->first_name ?? '') }}" />

        {{-- last name --}}
        <x-adminlte-input type="text" name="last_name" label="Sobrenome"
            fgroup-class="col-md-4"
            value="{{ old('last_name', $user->last_name ?? '') }}" />

        {{-- date of birth --}}
        <x-adminlte-input type="text" name="date_of_birth"
            label="Data de Nascimento" placeholder="dd/mm/aaaa"
            fgroup-class="col-md-4"
            value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}">

            <x-slot name="prependSlot">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </x-slot>
        </x-adminlte-input>
    </div>

    <div class="row">

        {{-- profile --}}
        <x-form-group label="Perfil">

            <x-radio name="profile" label="Adminstrador"
                value="{{ \App\Enums\ProfileType::ADMIN }}"
                checked="{{ $isAdminSelected }}">
            </x-radio>

            <x-radio name="profile" label="Organização"
                value="{{ \App\Enums\ProfileType::ORGANIZATION }}"
                checked="{{ !$isAdminSelected }}">
            </x-radio>

            @error('profile')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </x-form-group>
    </div>



    <div class="organization-container"
        style="display:{{ !$isAdminSelected ? 'block' : 'none' }}">

        <x-organization-select fgroup-class="col-md-12"
            :selected="old('organization_id', $user->organization_id ?? null)" />
    </div>

    <div class="row">

        {{-- email --}}
        <x-email-input fgroup-class="col-md-4"
            value="{{ old('email', $user->email ?? '') }}" />

        {{-- password --}}
        <x-adminlte-input type="password" name="password" label="Senha"
            fgroup-class="col-md-4" value="{{ $user->password ?? '' }}">

            <x-slot name="prependSlot">
                <span class="input-group-text">
                    <i class="fa fa-key"></i>
                </span>
            </x-slot>

        </x-adminlte-input>

        <x-adminlte-input type="password" name="password_confirm"
            label="Confirmação de Senha" fgroup-class="col-md-4"
            placeholder="Repita a senha" value="{{ $user->password ?? '' }}">

            <x-slot name="prependSlot">
                <span class="input-group-text">
                    <i class="fa fa-key"></i>
                </span>
            </x-slot>

        </x-adminlte-input>

    </div>

    <div class="row">

        {{-- profile --}}
        <x-form-group label="Status">
            @php

                $isActive = old('status', $user->status ?? \App\Enums\StatusType::ACTIVE) == \App\Enums\StatusType::ACTIVE;
            @endphp

            <x-radio name="status" label="Ativo"
                value="{{ \App\Enums\StatusType::ACTIVE }}"
                checked="{{ $isActive }}">
            </x-radio>

            <x-radio name="status" label="Inativo"
                value="{{ \App\Enums\StatusType::INACTIVE }}"
                checked="{{ !$isActive }}">
            </x-radio>

            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </x-form-group>
    </div>

@endsection
