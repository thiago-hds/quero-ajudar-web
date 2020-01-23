@extends('adminlte::page')

@section('title', (isset($organization)? 'Editar' : 'Nova') . ' Instituição')

@section('content_header')
    <h1 class="m-0 text-dark">{{ (isset($organization)? 'Editar' : 'Nova') . ' Instituição' }}</h1>
@stop

@section('content')    
    <div class="row">
        <div class="col-12">
        
            <div class="card">
                <!-- form start -->
                <form role="form" method="post" action="{{ isset($organization->id)? route('organizations.update', $organization->id) : route('organizations.store') }}">
                    @if(isset($organization))
                        @method('PATCH') 
                    @endif
                    @csrf
                    <div class="card-body">
                        <!-- name -->
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($organization->name) ? $organization->name : null) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- organization_type -->
                        <div class="form-group">
                            <label for="organization_type_id">Tipo de Instituição</label>
                            <select class="form-control select2  @error('organization_type_id') is-invalid @enderror" data-placeholder="Selecione um tipo de instituição" style="width: 100%;" name="organization_type_id">
                                <option></option>
                                @foreach($organizationTypes as $organizationType)
                                    <option value="{{ $organizationType->id }}" {{ (old('organization_type_id', isset($organization->organization_type_id)? $organization->organization_type_id : null) == $organizationType->id)? 'selected' : '' }}>
                                        {{ $organizationType->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('organization_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                        </div>
                        
                        <!-- description -->
                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3" value="{{ old('description', isset($organization->description) ? $organization->description : null) }}"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- logo -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="text" class="form-control @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo', isset($organization->logo) ? $organization->logo : null) }}">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>  
                            </div>

                            <!-- website -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('date_of_birth') is-invalid @enderror" name="website" value="{{ old('website', isset($organization->website) ? $organization->website : null) }}">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <!-- status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="status" value="active" {{ old('status', isset($organization->status)? $organization->status : null) == 'inactive'? '' : 'checked' }}>
                                <label class="form-check-label">Ativo</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="status" value="inactive" {{ old('status', isset($organization->status)? $organization->status : null) == 'inactive'? 'checked' : '' }}>
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
                    <a class="btn btn-danger" href="{{ route('organizations.index')}}">
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

