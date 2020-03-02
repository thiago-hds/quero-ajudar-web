@extends('adminlte::page')

@section('title', 'Voluntários')

@section('content_header')
    <div class="col-sm-12">
        @if(session()->get('success'))
            <div class="alert alert-success">
            {{ session()->get('success') }}  
            </div>
        @endif
    </div>
    <h1 class="m-0 text-dark">Voluntários</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="" method="GET">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" name="name" value="{{ isset($inputs->name)? $inputs->name : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" name="email" value="{{ isset($inputs->email)? $inputs->email : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- cause_id -->
                            <div class="col-sm-4">
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
                            <div class="col-sm-4">
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
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status">
                                        <option></option>
                                        <option value="active" {{ (isset($inputs->status) && $inputs->status == 'active')? 'selected' : '' }}>Ativo</option>
                                        <option value="inactive" {{ (isset($inputs->status) && $inputs->status == 'inactive')? 'selected' : '' }}>Inativo</option>
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
                        {{ $volunteers->links() }}
                    </div>
                    <div class="row">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Causas</th>
                                    <th>Habilidades</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            @foreach($volunteers as $volunteer)
                                <tbody>
                                    <tr>
                                        <!-- name -->
                                        <td> {{ $volunteer->user->first_name}}  {{$volunteer->user->last_name }} </td>

                                        <!-- email -->
                                        <td> {{ $volunteer->user->email }} </td>

                                        <!-- causes -->
                                        <td> 
                                            @foreach($volunteer->causes as $cause)
                                                {{ $cause->name}} <br/>
                                            @endforeach
                                        </td>
                                        <!-- skils -->
                                        <td> 
                                            @foreach($volunteer->skills as $skill)
                                                {{ $skill->name}} <br/>
                                            @endforeach
                                        </td>

                                        <!-- status -->
                                        <td> 
                                            <span class="badge badge-{{$volunteer->user->status == 'active'? 'success' : 'danger'}}">
                                                {{ $volunteer->user->status == 'active'? 'ativo' : 'inativo'}}
                                            </span>
                                        </td>

                                        <!-- actions -->
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{ route('volunteers.edit',$volunteer->user->id)}}">
                                                <i class="fas fa-pencil-alt"></i>  Editar
                                            </a>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" onclick="deleteData('volunteers',{{$volunteer->user->id}})" >
                                                <i class="fas fa-trash"></i> Excluir
                                            </button>

                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                                
                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Causas</th>
                                    <th>Habilidades</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        {{ $volunteers->links() }}
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
                    <p>Você tem certeza que deseja excluir o voluntário?</p>
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