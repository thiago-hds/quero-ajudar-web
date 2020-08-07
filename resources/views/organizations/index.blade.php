@extends('adminlte::page')

@section('title', 'Instituições')

@section('content_header')
    <div class="col-sm-12">
        @if(session()->get('success'))
            <div class="alert alert-success">
            {{ session()->get('success') }}  
            </div>
        @endif
    </div>
    <h1 class="m-0 text-dark">Instituições</h1>
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
                            <div class="col-sm-6">
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
                        {{ $organizations->links() }}
                    </div>
                    <div class="row">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Telefones</th>
                                    <th>Causas</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            @foreach($organizations as $organization)
                                <tbody>
                                    <tr>
                                        <!-- name -->
                                        <td> {{ $organization->name }} </td>

                                        <!-- email -->
                                        <td> {{ $organization->email }} </td>

                                        <!-- phones -->
                                        <td> 
                                            @foreach($organization->phones as $phone)
                                            {{ $phone->number }}<br/>
                                            @endforeach   
                                        </td>

                                        <!-- causes -->
                                        <td> 
                                            @foreach($organization->causes as $cause)
                                                <span class="fa-stack fa-1x" title="{{ $cause->name }}">
                                                    <i class="fa fa-circle fa-stack-2x category-icon-background"></i>
                                                    <i class="fa fa-stack-1x category-icon"> &#x{{ $cause->fontawesome_icon_unicode }}; </i>
                                                </span>
                                            @endforeach     
                                        </td>

                                        <!-- status -->
                                        <td> 
                                            <span class="badge badge-{{$organization->status == 'active'? 'success' : 'danger'}}">
                                                {{ $organization->status == 'active'? 'ativo' : 'inativo'}}
                                            </span>
                                        </td>

                                        <!-- actions -->
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{ route('organizations.edit',$organization->id)}}">
                                                <i class="fas fa-pencil-alt"></i>  Editar
                                            </a>

                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" onclick="deleteData('organizations',{{$organization->id}})" >
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
                                    <th>Telefones</th>
                                    <th>Causas</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        {{ $organizations->links() }}
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
                    <p>Você tem certeza que deseja excluir a instituição?</p>
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