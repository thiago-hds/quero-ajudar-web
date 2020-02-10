@extends('adminlte::page')

@section('title', (isset($enrollment)? 'Editar' : 'Nova') . ' Inscrição')

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
    <h1 class="m-0 text-dark">{{ (isset($enrollment)? 'Editar' : 'Nova') . ' Inscrição' }}</h1>
@stop

@section('content')    
    <div class="row">
        <div class="col-12">
        
            <div class="card">
                <!-- form start -->
                <form role="form" method="post" enctype="multipart/form-data" action="{{ isset($enrollment->id)? route('enrollments.update', $enrollment->id) : route('enrollments.store') }}">
                    @if(isset($enrollment))
                        @method('PATCH') 
                    @endif
                    @csrf
                    <div class="card-body">

                        <!-- vacancy_id -->
                        <div  class="form-group">
                            <label for="vacancy">Vaga</label>
                            <select class="form-control select2  @error('vacancy_id') is-invalid @enderror" data-placeholder="Selecione uma vaga" style="width: 100%;" name="vacancy_id">
                                <option></option>
                                @foreach($vacancies as $vacancy)
                                    <option value="{{ $vacancy->id }}" {{ (old('vacancy_id', isset($enrollment->vacancy_id)? $enrollment->vacancy_id : null) == $vacancy->id)? 'selected' : '' }}>
                                        {{ $vacancy->name . ' - ' . $vacancy->organization->name}}
                                    </option>
                                @endforeach
                            </select>

                            @error('vacancy_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- volunteer_user_id -->
                        <div  class="form-group">
                            <label for="volunteer">Voluntário</label>
                            <select class="form-control select2  @error('volunteer_user_id') is-invalid @enderror" data-placeholder="Selecione um voluntário" style="width: 100%;" name="volunteer_user_id">
                                <option></option>
                                @foreach($volunteers as $volunteer)
                                    <option value="{{ $volunteer->user_id }}" {{ (old('volunteer_user_id', isset($enrollment->volunteer_user_id)? $enrollment->volunteer_user_id : null) == $volunteer->user_id)? 'selected' : '' }}>
                                        {{ $volunteer->user->name}}
                                    </option>
                                @endforeach
                            </select>

                            @error('volunteer_user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

