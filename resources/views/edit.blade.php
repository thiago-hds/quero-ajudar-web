@extends('adminlte::page')

@section('title', (isset($user) ? 'Editar' : 'Novo') . ' Usuário')

@section('content_header')
    <h1 class="m-0 text-dark">
        {{ (isset($user) ? 'Editar' : 'Novo') . ' Usuário' }}</h1>
@stop

@section('content')



    <form method="post" class="card"
        action="{{ isset($user->id) ? route('users.update', $user->id) : route('users.store') }}">
        <div class="card-body">
            @if (isset($user))
                @method('PATCH')
            @endif
            @csrf

            <div class="row">

                {{-- first name --}}
                <x-adminlte-input type="text" name="first_name" label="Nome"
                    fgroup-class="col-md-4"
                    value="{{ old('first_name', $user->first_name ?? '') }}" />

                {{-- last name --}}
                <x-adminlte-input type="text" name="last_name" label="Sobrenome"
                    fgroup-class="col-md-4"
                    value="{{ old('last_name', $user->first_name ?? '') }}" />

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


                    @php
                        $isAdminSelected = old('profile', $user->profile ?? '') === \App\Enums\ProfileType::ADMIN || !isset($user);
                        // $isAdminSelected = false;
                    @endphp


                    {{-- TODO: determinar se o campo deve estar checado ou não --}}
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


            @php
                $config = [
                    'placeholder' => 'Selecione uma instituição...',
                    'allowClear' => true,
                ];

            @endphp
            <div class="organization-container"
                style="display:{{ !$isAdminSelected ? 'block' : 'none' }}">

                <x-adminlte-select2 id="organization_id" name="organization_id"
                    label="Instituição" :config="$config">
                    <x-slot name="prependSlot">
                        <span class="input-group-text">
                            <i class="fas fa-fw fa-building "></i>
                        </span>
                    </x-slot>

                    <option></option>
                    @foreach ($organizations as $organization)
                        <option value="{{ $organization->id }}"
                            {{ old('organization_id', isset($user->organization_id) ? $user->organization_id : null) == $organization->id ? 'selected' : '' }}>
                            {{ $organization->name }}
                        </option>
                    @endforeach
                </x-adminlte-select2>
            </div>

            {{-- <div class="form-group organization-container"
                style="display:{{ old('profile', $user->profile ?? '') == \App\Enums\ProfileType::ORGANIZATION ? 'block' : 'none' }}">
                <label for="organization">Instituição</label>
                <select
                    class="form-control select2  @error('organization') is-invalid @enderror"
                    data-placeholder="Selecione uma instituição"
                    style="width: 100%;" name="organization_id">
                    <option></option>
                    @foreach ($organizations as $organization)
                        <option value="{{ $organization->id }}"
                            {{ old('organization_id', isset($user->organization_id) ? $user->organization_id : null) == $organization->id ? 'selected' : '' }}>
                            {{ $organization->name }}
                        </option>
                    @endforeach
                </select>
                @error('organization')
                    <div class="invalid-feedback">{{ $message }}
                    </div>
                @enderror
            </div> --}}

            <div class="row">

                {{-- email --}}
                <x-adminlte-input type="email" name="email" label="E-mail"
                    fgroup-class="col-md-4"
                    value="{{ old('email', $user->email ?? '') }}">

                    <x-slot name="prependSlot">
                        <span class="input-group-text">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </x-slot>

                </x-adminlte-input>

                {{-- password --}}
                <x-adminlte-input type="password" name="password" label="Senha"
                    fgroup-class="col-md-4"
                    value="{{ $user->password ?? '' }}">

                    <x-slot name="prependSlot">
                        <span class="input-group-text">
                            <i class="fa fa-key"></i>
                        </span>
                    </x-slot>

                </x-adminlte-input>

                <x-adminlte-input type="password" name="password_confirm"
                    label="Confirmação de Senha" fgroup-class="col-md-4"
                    placeholder="Repita a senha"
                    value="{{ $user->password_confirm ?? '' }}">

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

                    {{-- TODO: determinar se o campo deve estar checado ou não --}}
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

            {{-- <div class="form-group">
                <label for="status">Status</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status"
                        value="{{ \App\Enums\StatusType::ACTIVE }}"
                        {{ old('status', isset($user->status) ? $user->status : \App\Enums\StatusType::ACTIVE) == \App\Enums\StatusType::INACTIVE ? '' : 'checked' }}>
                    <label class="form-check-label">Ativo</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status"
                        value="{{ \App\Enums\StatusType::INACTIVE }}"
                        {{ old('status', isset($user->status) ? $user->status : \App\Enums\StatusType::ACTIVE) == \App\Enums\StatusType::INACTIVE ? 'checked' : '' }}>
                    <label class="form-check-label">Inativo</label>
                </div>
                @error('status')
                    {{ $message }}
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}
            <!-- /.card-body -->
        </div>

        <div class="card-footer">
            <x-adminlte-button class="float-right" type="submit" label="Enviar"
                theme="success" icon="fas fa-save" />

            <a class="btn btn-danger" href="{{ route('users.index') }}">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </form>


@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/panel.css') }}">
@stop

@section('js')
    <script src="{{ asset('/js/panel.js') }}"></script>
@stop