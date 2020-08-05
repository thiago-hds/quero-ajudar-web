@extends('adminlte::page')

@section('title', (isset($cause)? 'Editar' : 'Nova') . ' Causa')

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
    <h1 class="m-0 text-dark">{{ (isset($cause)? 'Editar' : 'Nova') . ' Causa' }}</h1>
@stop

@section('content')    
    <div class="row">
        <div class="col-12">
        
            <div class="card">
                <!-- form start -->
                <form role="form" method="post" enctype="multipart/form-data" action="{{ isset($cause->id)? route('causes.update', $cause->id) : route('causes.store') }}">
                    @if(isset($cause))
                        @method('PATCH') 
                    @endif
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($cause->name) ? $cause->name : null) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>  
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="name">Ícone</label>
                                    <input type="text" class="form-control @error('fontawesome_icon_unicode') is-invalid @enderror" name="fontawesome_icon_unicode" value="{{ old('fontawesome_icon_unicode', isset($cause->fontawesome_icon_unicode) ? $cause->fontawesome_icon_unicode : null) }}">
                                    @error('fontawesome_icon_unicode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>  
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                   
                                </div> 
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-success float-right">
                        <i class="fas fa-save"></i>  Salvar
                    </button>
                    <a class="btn btn-danger" href="{{ route('enrollments.index')}}">
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

