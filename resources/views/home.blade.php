@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Início</h1>
@stop

@section('content')

<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats->organization_count }}</h3>

                <p>{{ $stats->organization_count == 1? 'Instituição' : 'Instituições' }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-fw fa-building"></i>
            </div>
            <a href="#" class="small-box-footer">Mais Informações <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats->vacancy_count }}</h3>

                <p>{{ $stats->vacancy_count == 1? 'Vaga' : 'Vagas' }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-fw fa-suitcase"></i>
            </div>
            <a href="#" class="small-box-footer">Mais Informações <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats->volunteer_count }}</h3>

                <p>{{ $stats->volunteer_count == 1? 'Voluntário' : 'Voluntários' }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-fw fa-hands-helping"></i>
            </div>
            <a href="#" class="small-box-footer">Mais Informações <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-orange">
            <div class="inner">
                <h3> {{ $stats->application_count }}</h3>

                <p> {{ $stats->application_count == 1? 'Inscrição' : 'Inscrições' }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-fw fa-edit"></i>
            </div>
            <a href="#" class="small-box-footer">Mais Informações <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
</div>

@stop
