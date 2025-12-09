@extends('adminlte::page')

@section('title', 'Editar Periodo')

@section('content_header')
    <h1>Editar Periodo</h1>
@stop

@section('content')
    <form action="{{ route('periodos.update', $periodo->id) }}" method="POST">
        @method('PUT')
        @include('periodos.partials.form')
    </form>
@stop
