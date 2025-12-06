@extends('adminlte::page')

@section('title', 'Gestión de Periodos')

@section('content_header')
    <h1 class="text-primary"><i class="fas fa-calendar-alt"></i> Lista de Periodos Académicos</h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-clock"></i> Periodos Registrados</span>
        <a href="{{ route('coordinador.periodos.create') }}" class="btn btn-black btn-sm">
            <i class="fas fa-plus-circle"></i> Crear Nuevo Periodo
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <table class="table table-hover table-striped table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Nombre del Periodo</th>
                    <th>Año del Periodo</th>
                    <th>Descripcion</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($periodos as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->nombre_periodo }}</td>
                        <td>{{ $p->año_periodo }}</td>
                        <td>{{ $p->descripcion }}</td>
                        <td>{{ $p->fecha_inicio }}</td>
                        <td>{{ $p->fecha_fin }}</td>
                        <td>{{ $p->estado }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            <i class="fas fa-exclamation-circle"></i> No hay periodos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
    <style>
        .card {
            border-radius: 1rem;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-light:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }
    </style>
@stop

@section('js')
<script>
    console.log("Vista de periodos cargada correctamente");
</script>
@stop
