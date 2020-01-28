@extends('adminlte::page')

@section('title', (isset($organization)? 'Editar' : 'Nova') . ' Instituição')

@section('content_header')
    <!-- s
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif -->
    <h1 class="m-0 text-dark">{{ (isset($organization)? 'Editar' : 'Nova') . ' Instituição' }}</h1>
@stop

@section('content')    
    <div class="row">
        <div class="col-12">
        
            <div class="card">
                <!-- form start -->
                <form role="form" method="post" enctype="multipart/form-data" action="{{ isset($organization->id)? route('organizations.update', $organization->id) : route('organizations.store') }}">
                    @if(isset($organization))
                        @method('PATCH') 
                    @endif
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <!-- name -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($organization->name) ? $organization->name : null) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- logo -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" name="logo" accept=".jpg,.gif,.png" class="form-control-file @error('logo') is-invalid @enderror" id="logo">
                                    <!-- <div class="dropzone"> </div> -->
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                </div>  
                            </div> 
                        </div>

                        <div class="row">
                            <!-- organzation_type_id -->
                            <div class="col-sm-6">
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
                            </div>

                            <!-- causes --->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="causes">Causas</label>
                                    <select class="form-control select2  @error('causes') is-invalid @enderror" multiple="multiple" data-placeholder="Selecione uma ou mais causas" style="width: 100%;" name="causes[]">
                                        <option></option>
                                        @foreach($causes as $cause)
                                            <option value="{{ $cause->id }}" {{ (in_array($cause->id, old('causes', isset($organization->causes)? $organization->causes : array())))? 'selected' : '' }} >
                                                {{ $cause->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('causes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- description -->
                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', isset($organization->description) ? $organization->description : null) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <!-- email -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', isset($organization->email) ? $organization->email : null) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                            </div>

                            <!-- website -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website', isset($organization->website) ? $organization->website : null) }}">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <!-- phones -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone">Telefones</label>
                                    <div class="phone-list">
                                        
                                        <div class="input-group phone-input-group">
                                            <input type="text" name="phones[1]" class="form-control phone-input @error('phones.1') is-invalid @enderror" placeholder="(99) 999999999" />
                                        </div>
                                        @error('phones.1')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <button type="button" class="btn btn-success btn-sm float-right btn-add-phone"><i class="fas fa-plus"></i>  Adicionar Telefone </button>
                                </div>
                            </div>
                            <div class="col-sm-6">

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

