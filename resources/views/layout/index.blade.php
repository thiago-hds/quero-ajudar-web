@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <x-flash />
    <h1 class="m-0 text-dark">{{ $title }}</h1>
@endsection

@section('content')
    <div class="card">
        <form
            action=""
            method="GET"
        >
            <div class="card-body">
                @yield('fields')
            </div>
            <div class="card-footer">
                <button
                    type="submit"
                    class="btn btn-primary float-right"
                >
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                {{ $collection->links() }}
            </div>
            <div class="row">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            @foreach ($cols as $col)
                                <th>{{ $col }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @yield('table-rows')
                    </tbody>
                    <tfoot>
                        <tr>
                            @foreach ($cols as $col)
                                <th>{{ $col }}</th>
                            @endforeach
                        </tr>
                    </tfoot>

                </table>
            </div>
            <div class="row">
                {{ $collection->links() }}
            </div>
        </div>
    </div>


@endsection

@section('css')
    <link
        rel="stylesheet"
        href="{{ asset('/css/panel.css') }}"
    />
@endsection

@section('js')
    <script src="{{ asset('/js/panel.js') }}"></script>
@endsection
