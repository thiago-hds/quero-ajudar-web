@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1 class="m-0 text-dark">
        {{ $title }}
    </h1>
@stop

@section('content')

    @if (config('app.debug') === true && $errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-edit-form
        :model="$model"
        :action="$action"
        :cancelUrl="$cancelUrl"
        enctype="multipart/form-data">
        @yield('fields')
    </x-edit-form>
@endsection

@section('css')
    <link
        rel="stylesheet"
        href="{{ asset('/css/style.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/js/script.js') }}"></script>
@endsection
