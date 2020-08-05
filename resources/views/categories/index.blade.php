@extends('adminlte::page')

@section('title', 'Causas')

@section('content_header')
    <div class="col-sm-12">
        @if(session()->get('success'))
            <div class="alert alert-success">
            {{ session()->get('success') }}  
            </div>
        @endif
    </div>
    <h1 class="m-0 text-dark">Causas</h1>
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
                        {{ $causes->links() }}
                    </div>
                    <div class="row">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Ícone</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            @foreach($causes as $cause)
                                <tbody>
                                    <tr>
                                        <td> {{ $cause->name}} </td>
                                        <td> <i class="fa"> &#x{{ $cause->fontawesome_icon_unicode }}; </i></td>
                                        <td>
                                            @can('update', $cause)
                                            <a class="btn btn-info btn-sm" href="{{ route('causes.edit',$cause->id)}}">
                                                <i class="fas fa-pencil-alt"></i>  Editar
                                            </a>
                                            @endcan
                                            @can('delete', $cause)
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" onclick="deleteData('causes',{{$cause->id}})" >
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
                                    <th>Ícone</th>
                                    <th>Ações</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        {{ $causes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete">
        @include('confirm_delete', ['model_name' => 'causa'])
    </div>
    <!-- /.modal -->


@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/panel.css') }}">
@stop

@section('js')
    <script src="{{ asset('/js/panel.js') }}"></script>
@stop