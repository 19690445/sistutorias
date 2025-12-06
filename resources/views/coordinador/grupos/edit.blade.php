@extends('adminlte::page')

@section('title', 'Editar Grupo')

@section('content_header')
    <h1>Editar Grupo</h1>
@stop

@section('content')
    <form action="{{ route('grupos.update', $grupo) }}" method="POST">
        @csrf
        @method('PUT')

        @include('grupos.partials.form', ['grupo' => $grupo])

        <button type="submit" class="btn btn-warning mt-3">Actualizar</button>
        <a href="{{ route('grupos.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
@stop
