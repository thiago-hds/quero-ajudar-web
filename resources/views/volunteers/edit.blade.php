@extends('adminlte::page')

@section('title', (isset($volunteer)? 'Editar' : 'Novo') . ' Voluntário')

@section('content_header')
    <h1 class="m-0 text-dark">{{ (isset($volunteer)? 'Editar' : 'Novo') . ' Voluntário' }}</h1>
@stop

@section('content')    
    <div class="row">
        <div class="col-12">
        
            <div class="card">
                <!-- form start -->
                <form role="form" method="post" action="{{ isset($volunteer->user_id)? route('volunteers.update', $volunteer->user_id) : route('volunteers.store') }}">
                    @if(isset($volunteer))
                        @method('PATCH') 
                    @endif
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <!-- first_name -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="first_name">Nome</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', isset($volunteer->user->first_name) ? $volunteer->user->first_name : null) }}">
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>  
                            </div>
                            
                            <!-- last_name -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="last_name">Sobrenome</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', isset($volunteer->user->last_name) ? $volunteer->user->last_name : null) }}">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>  
                            </div>

                            <!-- date_of_birth -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="date_of_birth">Data de Nascimento</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control date-input @error('date_of_birth') is-invalid @enderror" placeholder="dd/mm/aaaa" name="date_of_birth" value="{{ old('date_of_birth', isset($volunteer->user->date_of_birth) ? $volunteer->user->date_of_birth : null) }}">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                            <!-- causes -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="causes">Causas</label>
                                    <select class="form-control select2  @error('causes') is-invalid @enderror" multiple="multiple" data-placeholder="Selecione uma ou mais causas" style="width: 100%;" name="causes[]">
                                        <option></option>
                                        @foreach($causes as $cause)
                                            <option value="{{ $cause->id }}" {{ (in_array($cause->id, old('causes', isset($volunteer->causes)? $volunteer->causes->pluck('id')->all() : array())))? 'selected' : '' }} >
                                                {{ $cause->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('causes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- skills -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="skills">Habilidades</label>
                                    <select class="form-control select2  @error('skills') is-invalid @enderror" multiple="multiple" data-placeholder="Selecione uma ou mais habilidades" style="width: 100%;" name="skills[]">
                                        <option></option>
                                        @foreach($skills as $skill)
                                            <option value="{{ $skill->id }}" {{ (in_array($skill->id, old('skills', isset($volunteer->skills)? $volunteer->skills->pluck('id')->all() : array())))? 'selected' : '' }} >
                                                {{ $skill->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('skills')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- email -->
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', isset($volunteer->user->email) ? $volunteer->user->email : null) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- password -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Senha</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password', isset($volunteer->user->password) ? $volunteer->user->password : null) }}">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- passwordconfirm -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password_confirm">Confirmação de Senha</label>
                                    <input type="password" class="form-control @error('password_confirm') is-invalid @enderror" name="password_confirm" value="{{ old('password_confirm', isset($volunteer->user->password) ? $volunteer->user->password : null) }}">
                                    @error('password_confirm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="status" value="1" {{ old('status', isset($volunteer->user->status)? $volunteer->user->status : null) == \App\Enums\StatusType::INACTIVE? '' : 'checked' }}>
                                <label class="form-check-label">Ativo</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="status" value="0" {{ old('status', isset($volunteer->user->status)? $volunteer->user->status : null) == \App\Enums\StatusType::INACTIVE? 'checked' : '' }}>
                                <label class="form-check-label">Inativo</label>
                            </div>
                            

                            @error('status')
                                {{ $message }} 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-success float-right">
                        <i class="fas fa-save"></i>  Salvar
                    </button>
                    <a class="btn btn-danger" href="{{ route('volunteers.index')}}">
                        <i class="fas fa-arrow-left"></i>  Cancelar
                    </a>    
                    </div>
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

