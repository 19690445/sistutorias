@extends('adminlte::page')

@section('title', 'Importar Estudiantes')

@section('content_header')
<h1>Importar Estudiantes al Grupo</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('grupos.importar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="grupo_id" value="{{ $grupo_id }}">
    <div class="form-group">
        <label for="file">Archivo Excel:</label>
        <input type="file" name="file" required class="form-control">
    </div>
    <button type="submit" class="btn btn-primary mt-2">Importar</button>
</form>
@stop
