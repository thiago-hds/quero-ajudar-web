@extends('adminlte::page')

@section('title', (isset($category)? 'Editar' : 'Nova') . ($type == 'causes'? ' Causa' : ' Habilidade'))

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
    <h1 class="m-0 text-dark">{{ (isset($category)? 'Editar' : 'Nova') }} {{ $type == 'causes'? ' Causa' : ' Habilidade'}}</h1>
@stop

@section('content')    
    <div class="row">
        <div class="col-12">
        
            <div class="card">
                <!-- form start -->
                <form role="form" method="post" enctype="multipart/form-data" action="{{ isset($category->id)? route( $type.'.update', $category->id) : route($type.'.store') }}">
                    @if(isset($category))
                        @method('PATCH') 
                    @endif
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($category->name) ? $category->name : null) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>  
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="name">Ícone FontAwesome (unicode)</label>
                                    <input type="text" class="form-control @error('fontawesome_icon_unicode') is-invalid @enderror" name="fontawesome_icon_unicode" value="{{ old('fontawesome_icon_unicode', isset($category->fontawesome_icon_unicode) ? $category->fontawesome_icon_unicode : null) }}">
                                    @error('fontawesome_icon_unicode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>  
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="category_icon">Ícone</label>
                                    <div name="category_icon">
                                        <i class="fa">
                                        &#x{{ old('fontawesome_icon_unicode', isset($category->fontawesome_icon_unicode) ? $category->fontawesome_icon_unicode : null) }};
                                        </i> 
                                    </div>
                                </div> 
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-success float-right">
                        <i class="fas fa-save"></i>  Salvar
                    </button>
                    <a class="btn btn-danger" href="{{ route($type.'.index')}}">
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

