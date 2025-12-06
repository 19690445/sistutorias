@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
    <h1 class="text-primary"><i class="fas fa-users"></i> Gestión de Grupos</h1>
@stop

@section('content')

<div class="card shadow-lg">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <span><i class="fas fa-list"></i> Lista de Grupos</span>
        <a href="{{ route('grupos.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus-circle"></i> Crear Grupo
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Clave</th>
                    <th>Grupo</th>
                    <th>Tutor</th>
                    <th>Periodo</th>
                    <th>Carrera</th>
                    <th>Semestre</th>
                    <th>Turno</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grupos as $g)
                <tr>
                    <td>{{ $g->id }}</td>
                    <td>{{ $g->clave_grupo }}</td>
                    <td>{{ $g->nombre_grupo }}</td>
                    <td>{{ $g->tutor->nombre ?? '---' }}</td>
                    <td>{{ $g->periodo->nombre_periodo ?? '---' }}</td>
                    <td>{{ $g->carrera }}</td>
                    <td>{{ $g->semestre }}</td>
                    <td>{{ ucfirst($g->turno) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-muted">No hay grupos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@stop
