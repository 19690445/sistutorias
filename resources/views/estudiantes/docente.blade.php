@extends('adminlte::page')
@section('title','Vista Docente')

@section('content_header')
<h1>Estudiantes (Vista Docente)</h1>
@stop

@section('content')
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Matrícula</th>
            <th>Nombre</th>
            <th>Carrera</th>
            <th>Semestre</th>
        </tr>
    </thead>
    <tbody>
        @foreach($estudiantes as $e)
        <tr>
            <td>{{ $e->matricula }}</td>
            <td>{{ $e->nombre }} {{ $e->apellidos }}</td>
            <td>{{ $e->carrera }}</td>
            <td>{{ $e->semestre }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
