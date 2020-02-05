@extends('adminlte::page')

<div class="loading"> 
    <div class="spinner-border text-light" role="status">
    <span class="sr-only"></span>
    </div>
</div>

@section('title', (isset($vacancy)? 'Editar' : 'Nova') . ' Vaga')

@section('content_header')
    
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
    
    <h1 class="m-0 text-dark">{{ (isset($vacancy)? 'Editar' : 'Nova') . ' Vaga' }}</h1>
@stop

@section('content')    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- form start -->
                <form role="form" method="post" action="{{ isset($vacancy->id)? route('vacancies.update', $vacancy->id) : route('vacancies.store') }}">
                    @if(isset($vacancy))
                        @method('PATCH') 
                    @endif
                    @csrf
                    <div class="card-body">
                        <!-- organization -->
                        <div class="form-group">
                            <label for="organization_id">Instituição</label>
                            
                            @if(Auth::user()->isAdmin())
                                <select class="form-control select2  @error('organization_id') is-invalid @enderror" data-placeholder="Selecione uma instituição" style="width: 100%;" name="organization_id">
                                    <option></option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}" {{ (old('organization_id', isset($vacancy->organization_id)? $vacancy->organization_id : null) == $organization->id)? 'selected' : '' }}>
                                            {{ $organization->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('organization_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            @else
                                <select class="form-control select2  @error('organization') is-invalid @enderror" data-placeholder="Selecione uma instituição" style="width: 100%;" name="organization_id" disabled>
                                    <option>{{ Auth::user()->organization->name }}</option>
                                </select>
                            @endif
                        </div>

                        <div class="row">
                            <!-- name -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($vacancy->name) ? $vacancy->name : null) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>  
                            
                            <!-- image -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="image">Imagem</label>
                                    <input type="file" name="image" accept=".jpg,.gif,.png" class="form-control-file @error('image') is-invalid @enderror" id="image">
                                    <!-- <div class="dropzone"> </div> -->
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
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
                                            <option value="{{ $cause->id }}" {{ (in_array($cause->id, old('causes', isset($vacancy->causes)? $vacancy->causes->pluck('id')->all() : array())))? 'selected' : '' }} >
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
                                            <option value="{{ $skill->id }}" {{ (in_array($skill->id, old('skills', isset($vacancy->skills)? $vacancy->skills->pluck('id')->all() : array())))? 'selected' : '' }} >
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


                        <div class="row">
                            
                            <div class="col-sm-6">
                                <!-- description -->
                                <div class="form-group">
                                    <label for="description">Descrição</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', isset($vacancy->description) ? $vacancy->description : null) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <!-- tasks -->
                                <div class="form-group">
                                    <label for="tasks">Tarefas</label>
                                    <textarea class="form-control @error('tasks') is-invalid @enderror" data-toggle="tooltip" data-placement="bottom" title="Insira detalhes das atividades que o voluntário realizará" name="tasks" rows="3">{{ old('tasks', isset($vacancy->tasks) ? $vacancy->tasks : null) }}</textarea>
                                    @error('tasks')
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
                                    name="status" value="active" {{ old('status', isset($vacancy->status)? $vacancy->status : null) == 'inactive'? '' : 'checked' }}>
                                <label class="form-check-label">Ativo</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="status" value="inactive" {{ old('status', isset($vacancy->status)? $vacancy->status : null) == 'inactive'? 'checked' : '' }}>
                                <label class="form-check-label">Inativo</label>
                            </div>
                            

                            @error('status')
                                {{ $message }} 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- type -->
                        <div class="form-group">
                            <label for="status">Tipo</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="type" value="recurrent" {{ old('type', isset($vacancy->type)? $vacancy->type : null) == 'unique_event'? '' : 'checked' }}>
                                <label class="form-check-label">Recorrente</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="type" value="unique_event" {{ old('type', isset($vacancy->type)? $vacancy->type : null) == 'unique_event'? 'checked' : '' }}>
                                <label class="form-check-label">Evento Único</label>
                            </div>

                            @error('type')
                                {{ $message }} 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="row">
                            <!-- date -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="date">Data</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control date-input @error('date') is-invalid @enderror" placeholder="dd/mm/aaaa" name="date" value="{{ old('date', isset($vacancy->date) ? $vacancy->date : null) }}">
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- hour -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="hour">Hora</label>
                                
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>
                                        <input type="text" class="form-control hour-input @error('hour') is-invalid @enderror" placeholder="hh:mm" name="hour" value="{{ old('hour', isset($vacancy->hour) ? $vacancy->hour : null) }}">
                                        @error('hour')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    @error('hour')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        @include('address', ['address' => isset($vacancy->address)? $vacancy->address : null])
                        <hr>
                        <div class="callout callout-info">
                            Os campos abaixo não são obrigatórios.</br> Eles podem ser usados para definir
                            o período em que a vaga será exibida no aplicativo e quantos voluntários podem se inscrever nela.
                        </div>
                        <h5>Divulgação</h5> <br/>
                        <div class="row">
                            <!-- promotion_start_date -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="promotion_start_date">Data de Início de Divulgação</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control date-input @error('promotion_start_date') is-invalid @enderror" placeholder="dd/mm/aaaa" name="promotion_start_date" value="{{ old('promotion_start_date', isset($vacancy->promotion_start_date) ? $vacancy->promotion_start_date : null) }}">
                                        @error('promotion_start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                            </div>
                            <!-- promotion_end_date -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="promotion_end_date">Data de Fim de Divulgação</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control date-input @error('promotion_end_date') is-invalid @enderror" placeholder="dd/mm/aaaa" name="promotion_end_date" value="{{ old('promotion_end_date', isset($vacancy->promotion_end_date) ? $vacancy->promotion_end_date : null) }}">
                                        @error('promotion_end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                            </div>

                            <!-- enrollment_limit -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="name">Número máximo de inscrições</label>
                                    <input type="text" class="form-control @error('enrollment_limit') is-invalid @enderror" name="enrollment_limit" value="{{ old('enrollment_limit', isset($vacancy->enrollment_limit) ? $vacancy->enrollment_limit : null) }}">
                                    @error('enrollment_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>  
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-success float-right">
                        <i class="fas fa-save"></i>  Salvar
                    </button>
                    <a class="btn btn-danger" href="{{ route('vacancies.index')}}">
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

