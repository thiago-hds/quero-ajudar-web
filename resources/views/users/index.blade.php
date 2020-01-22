@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <div class="col-sm-12">
        @if(session()->get('success'))
            <div class="alert alert-success">
            {{ session()->get('success') }}  
            </div>
        @endif
    </div>
    <h1 class="m-0 text-dark">Usuários</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="" method="GET">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" name="name" value="{{ isset($inputs->name)? $inputs->name : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" name="email" value="{{ isset($inputs->email)? $inputs->email : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" >
                                    <label for="profile">Perfil</label>
                                    <select class="form-control" name="profile">
                                        <option></option>
                                        <option value="admin" {{ (isset($inputs->profile) && $inputs->profile == 'admin')? 'selected' : '' }}>Administrador</option>
                                        <option value="organization" {{ (isset($inputs->profile) && $inputs->profile == 'organization')? 'selected' : '' }}>Instituição</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="organization_id">Instituição</label>
                                    <select class="form-control" data-placeholder="Selecione uma instituição" style="width: 100%;" name="organization_id" @if(!Auth::user()->isAdmin()) disabled @endif >
                                        <option></option>
                                        @foreach($organizations as $organization)
                                            <option value="{{ $organization->id }}" {{ (isset($inputs->organization_id) && $inputs->organization_id == $organization->id)? 'selected' : '' }}>
                                                {{ $organization->name }}
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
                        {{ $users->links() }}
                    </div>
                    <div class="row">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Perfil</th>
                                    <th>Instituição</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            @foreach($users as $user)
                                <tbody>
                                    <tr>
                                        <td> {{ $user->name }} </td>
                                        <td> {{ $user->email }} </td>
                                        <td> 
                                            <span class="badge badge-{{$user->profile == 'organization'? 'info' : 'warning'}}">
                                                {{ $user->profile == 'organization'? 'instituição' : 'administrador'}}
                                            </span>
                                        </td>
                                        <td> 
                                            {{ ($user->profile == 'organization' && isset($user->organization))? $user->organization->name : 'N/A'}}
                                        </td>
                                        <td> 
                                            <span class="badge badge-{{$user->status == 'active'? 'success' : 'danger'}}">
                                                {{ $user->status == 'active'? 'ativo' : 'inativo'}}
                                            </span>
                                        </td>
                                        <td>
                                            @can('update', $user)
                                            <a class="btn btn-info btn-sm" href="{{ route('users.edit',$user->id)}}">
                                                <i class="fas fa-pencil-alt"></i>  Editar
                                            </a>
                                            @endcan
                                            @can('delete', $user)
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" onclick="deleteData('users',{{$user->id}})" >
                                                <i class="fas fa-trash"></i> Excluir
                                            </button>
                                            @endcan
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                                
                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Perfil</th>
                                    <th>Instituição</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        {{ $users->links() }}
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
                    <p>Você tem certeza que deseja excluir o usuário?</p>
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