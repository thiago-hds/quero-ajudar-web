@extends('adminlte::page')

@section('title', 'Vagas')

@section('content_header')
    <div class="col-sm-12">
        @if(session()->get('success'))
            <div class="alert alert-success">
            {{ session()->get('success') }}  
            </div>
        @endif
    </div>
    <h1 class="m-0 text-dark">Vagas</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="" method="GET">
                    <div class="card-body">

                        <div class="row">
                            <!-- name -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" name="name" value="{{ isset($inputs->name)? $inputs->name : '' }}">
                                </div>
                            </div>

                            <!-- organization_id -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="organization_id">Instituição</label>
                                    <select class="form-control select2" data-placeholder="Selecione uma instituição" style="width: 100%;" name="organization_id" @if(!Auth::user()->isAdmin()) disabled @endif >
                                        <option></option>
                                        @foreach($organizations as $organization)
                                            <option value="{{ $organization->id }}" {{ (isset($inputs->organization_id) && $inputs->organization_id == $organization->id)? 'selected' : '' }}>
                                                {{ $organization->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- cause_id -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cause_id">Causa</label>
                                    <select class="form-control select2" data-placeholder="Selecione uma causa" style="width: 100%;" name="cause_id" >
                                        <option></option>
                                        @foreach($causes as $cause)
                                            <option value="{{ $cause->id }}" {{ (isset($inputs->cause_id) && $inputs->cause_id == $cause->id)? 'selected' : '' }}>                                            
                                                {{ $cause->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- skill_id -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="skill_id">Habilidade</label>
                                    <select class="form-control select2" data-placeholder="Selecione uma habilidade" style="width: 100%;" name="skill_id" >
                                        <option></option>
                                        @foreach($skills as $skill)
                                            <option value="{{ $skill->id }}" {{ (isset($inputs->skill_id) && $inputs->skill_id == $skill->id)? 'selected' : '' }}>
                                                {{ $skill->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- state -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="address_state">Estado</label>
                                    <select class="form-control select2" data-placeholder="Selecione um estado" style="width: 100%;" name="address_state">
                                        <option></option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->abbr }}" {{ (isset($inputs->address_state) && $inputs->address_state == $state->abbr)? 'selected' : '' }}>
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- city -->
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="address_city">Cidade</label>
                                    <select class="form-control select2" data-placeholder="Selecione uma cidade" style="width: 100%;" name="address_city">
                                        <option></option>
                                        @if(isset($inputs->address_state) && $inputs->address_state !== null)
                                            @php
                                            $state = App\State::where('abbr', $inputs->address_state)->first()
                                            @endphp
                                            @foreach($state->cities as $city) 
                                            <option value="{{ $city->id }}" {{ (isset($inputs->address_city) && $inputs->address_city == $city->id)? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>

                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <!-- type -->
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="status">Tipo</label>
                                    <select class="form-control" name="type">
                                        <option></option>
                                        <option value="recurrent" {{ (isset($inputs->type) && $inputs->type == \App\Enums\RecurrenceType::RECURRENT)? 'selected' : '' }}>Recorrente</option>
                                        <option value="unique_event" {{ (isset($inputs->type) && $inputs->type == \App\Enums\RecurrenceType::UNIQUE_EVENT)? 'selected' : '' }}>Evento Único</option>
                                    </select>
                                </div>
                            </div>

                            <!-- status -->
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status">
                                        <option></option>
                                        <option value="active" {{ (isset($inputs->status) && $inputs->status == \App\Enums\StatusType::ACTIVE)? 'selected' : '' }}>Ativo</option>
                                        <option value="inactive" {{ (isset($inputs->status) && $inputs->status == \App\Enums\StatusType::INACTIVE)? 'selected' : '' }}>Inativo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fas fa-search"></i>  Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        {{ $vacancies->links() }}
                    </div>
                    <div class="row">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Instituição</th>
                                    <th>Causas</th>
                                    <th>Habilidades</th>
                                    <th>Estado</th>
                                    <th>Cidade</th>
                                    <th>Tipo</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            @foreach($vacancies as $vacancy)
                                <tbody>
                                    <tr>
                                        <!-- name -->
                                        <td> {{ $vacancy->name }} </td>

                                        <!-- organization -->
                                        <td> {{$vacancy->organization->name}} </td>

                                        <!-- causes -->
                                        <td> 
                                            @foreach($vacancy->causes as $key => $cause)
                                                <span class="fa-stack fa-1x" title="{{ $cause->name }}">
                                                    <i class="fa fa-circle fa-stack-2x category-icon-background"></i>
                                                    <i class="fa fa-stack-1x category-icon"> &#x{{ $cause->fontawesome_icon_unicode }}; </i>
                                                </span>
                                            @endforeach     
                                        </td>

                                        <!-- skills -->
                                        <td> 
                                            @foreach($vacancy->skills as $skill)
                                                <span class="fa-stack fa-1x" title="{{ $skill->name }}">
                                                    <i class="fa fa-circle fa-stack-2x category-icon-background"></i>
                                                    <i class="fa fa-stack-1x category-icon"> &#x{{ $skill->fontawesome_icon_unicode }}; </i>
                                                </span>
                                            @endforeach     
                                        </td>

                                        <!-- state -->
                                        <td> 
                                            {{ isset($vacancy->address)? $vacancy->address->city->state->abbr : ''}}
                                        </td>

                                        <!-- city -->
                                        <td> 
                                            {{ isset($vacancy->address)? $vacancy->address->city->name : ''}}
                                        </td>

                                        <!-- type -->
                                        <td> 
                                            {{ $vacancy->type == \App\Enums\RecurrenceType::RECURRENT? 'Recorrente' : 'Evento Único' }}
                                        </td>

                                        <!-- status -->
                                        <td> 
                                            <span class="badge badge-{{$vacancy->status == \App\Enums\StatusType::ACTIVE? 'success' : 'danger'}}">
                                                {{ $vacancy->status == \App\Enums\StatusType::ACTIVE? 'ativo' : 'inativo'}}
                                            </span>
                                        </td>

                                        <!-- actions -->
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{ route('vacancies.edit',$vacancy->id)}}">
                                                <i class="fas fa-pencil-alt"></i>  Editar
                                            </a>

                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" onclick="deleteData('vacancies',{{$vacancy->id}})" >
                                                <i class="fas fa-trash"></i> Excluir
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                                
                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>Instituição</th>
                                    <th>Causas</th>
                                    <th>Habilidades</th>
                                    <th>Estado</th>
                                    <th>Cidade</th>
                                    <th>Tipo</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        {{ $vacancies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmação de Exclusão</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza que deseja excluir a vaga?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <form id="form-delete" action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Excluir</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/panel.css') }}">
@stop

@section('js')
    <script src="{{ asset('/js/panel.js') }}"></script><s></s>
@stop