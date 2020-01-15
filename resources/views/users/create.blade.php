@extends('adminlte::page')

@section('title', 'Novo Usuário')

@section('content_header')
    <h1 class="m-0 text-dark">Novo Usuário</h1>
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
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
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
                                        <input type="text" class="form-control @error('birth_date') is-invalid @enderror" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask name="birth_date">
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
                                <input class="form-check-input" type="radio" name="profile" value="organization" checked>
                                <label class="form-check-label">Representante de organização</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="profile" value="admin">
                                <label class="form-check-label">Administrador</label>
                            </div>

                            @error('profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="organization_div" class="form-group">
                            <label for="organization">Organização</label>
                            <select class="form-control select2  @error('organization') is-invalid @enderror" style="width: 100%;" name="organization">
                                <option></option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                @endforeach
                            </select>

                            @error('organization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" >
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

@section('js')
    <script src="{{ asset('/js/panel.js') }}"></script><s></s>
@stop

