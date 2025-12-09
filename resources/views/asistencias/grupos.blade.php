@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
    <h1>Grupos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Grupo</th>
                    <th>Estudiantes</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grupos as $grupo)
                    <tr>
                        <td>{{ $grupo->nombre }}</td>
                        <td>{{ $grupo->estudiantes->count() }}</td>
                        <td>
                            <a href="{{ route('asistencias.malla', $grupo->id) }}" class="btn btn-sm btn-success">Tomar Asistencia</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
