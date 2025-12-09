@extends('adminlte::page')

@section('title', 'Editar Semana')

@section('content')
<div class="container">
    <h1>Editar Semana</h1>
    <form action="{{ route('semanas.update', $semana->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Semana</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $semana->nombre }}" required>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('semanas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@stop
