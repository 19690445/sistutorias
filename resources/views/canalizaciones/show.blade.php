@extends('adminlte::page')

@section('title', 'Detalle de Canalización')

@section('content_header')
<h1>Detalle de Canalización</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Estudiante</th>
                <td>{{ $canalizacion->individuale->estudiante->nombre ?? '' }} {{ $canalizacion->individuale->estudiante->apellidos ?? '' }}</td>
            </tr>
            <tr>
                <th>Tipo de Atención</th>
                <td>{{ $canalizacion->tipo_atencion }}</td>
            </tr>
            <tr>
                <th>Causa del Problema</th>
                <td>{{ $canalizacion->causa_problema }}</td>
            </tr>
            <tr>
                <th>Acciones Sugeridas</th>
                <td>{{ $canalizacion->acciones_sugeridas }}</td>
            </tr>
            <tr>
                <th>Primera Sesión Propuesta</th>
                <td>{{ $canalizacion->primera_sesion_propuesta }}</td>
            </tr>
            <tr>
                <th>Primera Sesión Real</th>
                <td>{{ $canalizacion->primera_sesion_real }}</td>
            </tr>
            <tr>
                <th>Seguimiento Tutor</th>
                <td>{{ $canalizacion->seguimiento_tutor }}</td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>{{ $canalizacion->estado }}</td>
            </tr>
            <tr>
                <th>Observaciones</th>
                <td>{{ $canalizacion->observaciones }}</td>
            </tr>
        </table>

        <div class="mt-3">
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('coordinador'))
                <a href="{{ route('canalizaciones.edit', $canalizacion->id) }}" class="btn btn-warning">Editar</a>
            @endif
            <a href="{{ route('canalizaciones.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@stop
