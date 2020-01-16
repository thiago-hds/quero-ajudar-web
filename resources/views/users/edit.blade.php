@extends('adminlte::page')

@section('title', (isset($user)? 'Editar' : 'Novo') . ' Usuário')

@section('content_header')
    <h1 class="m-0 text-dark">{{ (isset($user)? 'Editar' : 'Novo') . ' Usuário' }}</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
        
            <div class="card">
                <!-- form start -->
                <form role="form" method="post" action="{{ route('users.store') }}">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($user->name) ? $user->name : null) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="birth_date">Data de Nascimento</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control date-input @error('birth_date') is-invalid @enderror"  name="birth_date" value="{{ old('birth_date', isset($user->birth) ? $user->birth : null) }}">
                                        @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="profile">Perfil</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="profile" value="admin" {{ old('profile', isset($user->profile)? $user->profile : null) == 'admin'? 'checked' : '' }}>
                                <label class="form-check-label">Administrador</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="profile" value="organization" {{ old('profile', isset($user->profile)? $user->profile : null) == 'organization'? 'checked' : '' }}>
                                <label class="form-check-label">Representante de Instituição</label>
                            </div>
                            

                            @error('profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        

                        <div id="organization_div" class="form-group">
                            <label for="organization">Instituição</label>
                            <select class="form-control select2  @error('organization') is-invalid @enderror" data-placeholder="Selecione uma instituição" style="width: 100%;" name="organization">
                                <option></option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ (old('organization', isset($user->organization_id)? $user->organization_id : null) == $organization->id)? 'selected' : '' }}>
                                        {{ $organization->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('organization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', isset($user->email) ? $user->email : null) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Senha</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password_confirm">Confirmação de Senha</label>
                                    <input type="password" class="form-control @error('password_confirm') is-invalid @enderror" name="password_confirm">
                                    @error('password_confirm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-success float-right">Salvar</button>
                    <button type="submit" class="btn btn-danger ">Cancelar</button>
                </form>

            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/panel.css') }}">
@stop

@section('js')
    <script src="{{ asset('/js/panel.js') }}"></script><s></s>
@stop

