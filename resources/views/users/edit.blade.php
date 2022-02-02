@php
use App\Enums\StatusType;
use App\Enums\ProfileType;

$title = sprintf('%s %s', isset($user) ? 'Editar' : 'Novo', 'Usuário');
$action = isset($user) ? route('users.update', $user->id) : route('users.store');

$selectedProfile = old('profile', $user->profile ?? '');
$isAdminSelected = $selectedProfile === ProfileType::ADMIN || !isset($user);
@endphp

@extends('layout.edit', [
'model' => $user ?? null,
'title' => $title,
'action' => $action,
'cancelUrl' => route('users.index')
])



@section('fields')
    <div class="row">

        {{-- first name --}}
        <x-adminlte-input
            type="text"
            name="first_name"
            label="Nome"
            fgroup-class="col-md-4"
            value="{{ old('first_name', $user->first_name ?? '') }}" />

        {{-- last name --}}
        <x-adminlte-input type="text"
            name="last_name"
            label="Sobrenome"
            fgroup-class="col-md-4"
            value="{{ old('last_name', $user->last_name ?? '') }}" />

        {{-- date of birth --}}
        <x-form.date-of-birth-input
            fgroup-class="col-md-4"
            value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}" />
    </div>

    <div class="row">
        {{-- profile --}}
        <x-form.profile-radio-group :isAdminSelected="$isAdminSelected" />
    </div>

    <div class="organization-container"
        style="display:{{ !$isAdminSelected ? 'block' : 'none' }}">

        {{-- organization --}}
        <x-form.organization-select fgroup-class="col-md-12"
            :selected="old('organization_id', $user->organization_id ?? null)" />
    </div>

    <div class="row">

        {{-- email --}}
        <x-form.email-input fgroup-class="col-md-4"
            value="{{ old('email', $user->email ?? '') }}" />

        {{-- password --}}
        <x-form.password-input
            fgroup-class="col-md-4"
            value="{{ $user->password ?? '' }}" />

        {{-- password confirmation --}}
        <x-form.password-input name="password_confirm"
            label="Confirmação de Senha"
            fgroup-class="col-md-4"
            placeholder="Repita a senha"
            value="{{ $user->password ?? '' }}" />

    </div>

    <div class="row">

        {{-- status --}}
        @php
            $isActive = old('status', $user->status ?? StatusType::ACTIVE) === StatusType::ACTIVE;
        @endphp
        <x-form.status-radio-group
            :isActive="$isActive" />
    </div>

@endsection
