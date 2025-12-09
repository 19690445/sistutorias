@extends('adminlte::page')

@section('title', 'Nuevo Periodo')

@section('content_header')
    <h1>Nuevo Periodo</h1>
@stop

@section('content')
    <form action="{{ route('periodos.store') }}" method="POST">
        @include('periodos.partials.form')
    </form>
@stop
