@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1 class="m-0 text-dark">
        {{ $title }}
    </h1>
@stop

@section('content')
    <x-edit-form
        :model="$model"
        :action="$action"
        :cancelUrl="$cancelUrl"
    >
        @yield('fields')
    </x-edit-form>
@endsection

@section('css')
    <link
        rel="stylesheet"
        href="{{ asset('/css/panel.css') }}"
    >
@endsection

@section('js')
    <script src="{{ asset('/js/panel.js') }}"></script>
@endsection
