@extends('adminlte::page')

<div class="loading"> 
    <div class="spinner-border text-light" role="status">
    <span class="sr-only"></span>
    </div>
</div>

@section('title', (isset($vacancy)? 'Editar' : 'Nova') . ' Vaga')

@section('content_header')
    
    @if (config('app.debug') && $errors->any())
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
                <form role="form" method="post" enctype="multipart/form-data" action="{{ isset($vacancy->id)? route('vacancies.update', $vacancy->id) : route('vacancies.store') }}">
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
                                    <input type="file" name="image" accept=".jpg,.jpeg,.gif,.png" class="form-control-file @error('image') is-invalid @enderror" id="image">
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
                                    <label for="skills">Habilidades Requeridas</label>
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
                                    name="status" value="{{\App\Enums\StatusType::ACTIVE}}" {{ old('status', isset($vacancy->status)? $vacancy->status : null) == \App\Enums\StatusType::INACTIVE? '' : 'checked' }}>
                                <label class="form-check-label">Ativo</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="status" value="{{\App\Enums\StatusType::INACTIVE}}" {{ old('status', isset($vacancy->status)? $vacancy->status : null) == \App\Enums\StatusType::INACTIVE? 'checked' : '' }}>
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
                                    name="type" value="{{\App\Enums\RecurrenceType::RECURRENT}}" {{ old('type', isset($vacancy->type)? $vacancy->type : null) == \App\Enums\RecurrenceType::UNIQUE_EVENT? '' : 'checked' }}>
                                <label class="form-check-label">Recorrente</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="type" value="{{\App\Enums\RecurrenceType::UNIQUE_EVENT}}" {{ old('type', isset($vacancy->type)? $vacancy->type : null) == \App\Enums\RecurrenceType::UNIQUE_EVENT? 'checked' : '' }}>
                                <label class="form-check-label">Evento Único</label>
                            </div>

                            @error('type')
                                {{ $message }} 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="frequency_div" style="display:{{(isset($vacancy) && $vacancy->type == \App\Enums\RecurrenceType::UNIQUE_EVENT)? 'none' : 'block'}};">
                            <hr>

                            <h5>Frequência</h5> <br/>
                            
                            <!-- frequency_negotiable -->
                            <div class="form-group">
                                <label for="frequency_negotiable">À combinar</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="frequency_negotiable" value="no" {{ old('frequency_negotiable', (isset($vacancy) && !isset($vacancy->periodicity))? 'yes' : 'no') == 'no'? 'checked' : '' }}>
                                    <label class="form-check-label">Não</label>
                                </div> 

                                <div class="form-check">
                                
                                    <input class="form-check-input" type="radio"
                                        name="frequency_negotiable" value="yes" {{ old('frequency_negotiable', (isset($vacancy) && !isset($vacancy->periodicity))? 'yes' : 'no') == 'yes'? 'checked' : '' }}>
                                    <label class="form-check-label">Sim</label>
                                </div>
                        
                                @error('frequency_negotiable')
                                    {{ $message }} 
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="periodicity_div"  class="row" style="display:{{ old('frequency_negotiable', (isset($vacancy) && !isset($vacancy->periodicity))? 'yes' : 'no') == 'yes'? 'none' : 'block' }}">
                                <!-- periodicity -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="periodicity">Periodicidade</label>
                                        <select class="form-control @error('periodicity') is-invalid @enderror" style="width: 100%;" name="periodicity">
                                            <option></option>
                                            <option value="{{\App\Enums\PeriodicityType::DAILY}}" {{ (old('periodicity', isset($vacancy->periodicity)? $vacancy->periodicity : null) == \App\Enums\PeriodicityType::DAILY)? 'selected' : '' }}>Diária</option>
                                            <option value="\App\Enums\PeriodicityType::WEEKLY" {{ (old('periodicity', isset($vacancy->periodicity)? $vacancy->periodicity : null) == \App\Enums\PeriodicityType::WEEKLY)? 'selected' : '' }}>Semanal</option>
                                            <option value="\App\Enums\PeriodicityType::MONTHLY" {{ (old('periodicity', isset($vacancy->periodicity)? $vacancy->periodicity : null) == \App\Enums\PeriodicityType::MONTHLY )? 'selected' : '' }}>Mensal</option>
                                        </select>
                                        @error('periodicity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- unit_per_period -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="unit_per_period">Unidade de tempo/período</label>
                                        <select class="form-control @error('unit_per_period') is-invalid @enderror" style="width: 100%;" name="unit_per_period">
                                            <option></option>
                                            <option value="{{\App\Enums\UnitPerPeriodType::HOURS}}" {{ (old('unit_per_period', isset($vacancy->unit_per_period)? $vacancy->unit_per_period : null) == \App\Enums\UnitPerPeriodType::HOURS)? 'selected' : '' }}>Horas</option>
                                            <option value="{{\App\Enums\UnitPerPeriodType::DAYS}}" {{ (old('unit_per_period', isset($vacancy->unit_per_period)? $vacancy->unit_per_period : null) == \App\Enums\UnitPerPeriodType::DAYS)? 'selected' : '' }}>Dias</option>
                                        </select>
                                        @error('unit_per_period')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            
                        
                                <!-- amount_per_period -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="amount_per_period">Quantidade de tempo/período</label>
                                        <input type="text" class="form-control @error('amount_per_period') is-invalid @enderror" name="amount_per_period" value="{{ old('amount_per_period', isset($vacancy->amount_per_period) ? $vacancy->amount_per_period : null) }}">
                                        @error('amount_per_period')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <h5>Horário</h5> <br/>
                        <!-- hours_negotiable -->
                        <div class="form-group">
                            <label for="hours_negotiable">À combinar</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="hours_negotiable" value="no" {{ old('hours_negotiable', (isset($vacancy) && !isset($vacancy->time))? 'yes' : 'no') == 'no'? 'checked' : '' }}>
                                <label class="form-check-label">Não</label>
                            </div> 

                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="hours_negotiable" value="yes" {{ old('hours_negotiable', (isset($vacancy) && !isset($vacancy->time))? 'yes' : 'no') == 'yes'? 'checked' : '' }}>
                                <label class="form-check-label">Sim</label>
                            </div>
                    

                            @error('hours_negotiable')
                                {{ $message }} 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="hours_div" class="row" style="display:{{ old('hours_negotiable', (isset($vacancy) && !isset($vacancy->time))? 'yes' : 'no') == 'no'? 'block' : 'none' }};">
                            <!-- date -->
                            <div id="date_div" class="col-sm-6" style="display:{{(isset($vacancy) && $vacancy->type == \App\Enums\RecurrenceType::UNIQUE_EVENT)? 'block' : 'none'}};">
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

                            <!-- time -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="time">Hora</label>
                                
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>
                                        <input type="text" class="form-control hour-input @error('time') is-invalid @enderror" placeholder="hh:mm" name="time" value="{{ old('time', isset($vacancy->time) ? $vacancy->time : null) }}">
                                        @error('time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5>Local</h5> <br/>
                        
                        <!-- location_type -->
                        <div class="form-group">
                            <label for="location_type">Tipo de Local</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="location_type" value="{{\App\Enums\LocationType::ORGANIZATION_ADDRESS}}" {{ old('location_type', isset($vacancy->location_type)? $vacancy->location_type : \App\Enums\LocationType::ORGANIZATION_ADDRESS) == \App\Enums\LocationType::ORGANIZATION_ADDRESS? 'checked' : '' }}>
                                <label class="form-check-label">Endereço da Instituição</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="location_type" value="{{\App\Enums\LocationType::SPECIFIC_ADDRESS}}" {{ old('location_type', isset($vacancy->location_type)? $vacancy->location_type : null) == \App\Enums\LocationType::SPECIFIC_ADDRESS? 'checked' : '' }}>
                                <label class="form-check-label">Endereço Específico</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="location_type" value="{{\App\Enums\LocationType::REMOTE}}" {{ old('location_type', isset($vacancy->location_type)? $vacancy->location_type : null) == \App\Enums\LocationType::REMOTE? 'checked' : '' }}>
                                <label class="form-check-label">Remoto</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="location_type" value="{{\App\Enums\LocationType::NEGOTIABLE}}" {{ old('location_type', isset($vacancy->location_type)? $vacancy->location_type : null) == \App\Enums\LocationType::NEGOTIABLE? 'checked' : '' }}>
                                <label class="form-check-label">À combinar</label>
                            </div>

                            @error('location_type')
                                {{ $message }} 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="address_div" style="display:{{(isset($vacancy->location_type) && ($vacancy->location_type == \App\Enums\LocationType::REMOTE || $vacancy->location_type == \App\Enums\LocationType::NEGOTIABLE))? 'none' : 'block' }}">
                            @include('address', ['address' => isset($vacancy->address)? $vacancy->address : null])
                        </div>
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

                            <!-- application_limit -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="name">Número máximo de inscrições</label>
                                    <input type="text" class="form-control @error('application_limit') is-invalid @enderror" name="application_limit" value="{{ old('application_limit', isset($vacancy->application_limit) ? $vacancy->application_limit : null) }}">
                                    @error('application_limit')
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
    <script src="{{ asset('/js/panel.js') }}"></script>
    <script src="{{ asset('/js/vacancy_edit.js') }}"></script>
@stop

