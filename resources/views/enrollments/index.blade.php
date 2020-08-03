@extends('adminlte::page')

@section('title', 'Inscrições')

@section('content_header')
    <div class="col-sm-12">
        @if(session()->get('success'))
            <div class="alert alert-success">
            {{ session()->get('success') }}  
            </div>
        @endif
    </div>
    <h1 class="m-0 text-dark">Inscrições</h1>
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
                                    <label for="cause_id">Vaga</label>
                                    <select class="form-control select2" data-placeholder="Selecione uma vaga" style="width: 100%;" name="vacancy_id" >
                                        <option></option>
                                        @foreach($vacancies as $vacancy)
                                            <option value="{{ $vacancy->id }}" {{ (isset($inputs->vacancy_id) && $inputs->vacancy_id == $vacancy->id)? 'selected' : '' }}>
                                                {{ $vacancy->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cause_id">Voluntário</label>
                                    <select class="form-control select2" data-placeholder="Selecione um voluntário" style="width: 100%;" name="volunteer_user_id" >
                                        <option></option>
                                        @foreach($volunteers as $volunteer)
                                            <option value="{{ $volunteer->user_id }}" {{ (isset($inputs->volunteer_user_id) && $inputs->volunteer_user_id == $volunteer->user_id)? 'selected' : '' }}>
                                                {{ $volunteer->user->name }}
                                            </option>
                                        @endforeach
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
                        {{ $enrollments->links() }}
                    </div>
                    <div class="row">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Vaga</th>
                                    <th>Voluntário</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            @foreach($enrollments as $enrollment)
                                <tbody>
                                    <tr>
                                        <!-- vacancy_name -->
                                        <td>
                                            <a href="{{action('Web\VacancyController@edit', ['vacancy' => $enrollment->vacancy])}}" target="_blank">
                                                {{ $enrollment->vacancy->name }} 
                                            </a>
                                        </td>

                                        <!-- volunteer_name -->
                                        <td> 
                                            <a href="{{action('Web\VolunteerController@edit', ['volunteer' => $enrollment->volunteer])}}" target="_blank">
                                            {{ $enrollment->volunteer->user->complete_name  }} 
                                            </a>
                                        </td>

                                        <!-- actions -->
                                        <td>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" onclick="deleteData('enrollments',{{$enrollment->id}})" >
                                                <i class="fas fa-trash"></i> Excluir
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                                
                            <tfoot>
                                <tr>
                                    <th>Vaga</th>
                                    <th>Voluntário</th>
                                    <th>Ações</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        {{ $enrollments->links() }}
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