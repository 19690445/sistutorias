@extends('adminlte::page')

@section('title', 'Lista de Tutores')

@section('content_header')
    <h1>Gestión de Tutores</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-user-tie"></i> Lista de Tutores</span>
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                <i class="fas fa-home"></i> Volver al Dashboard
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Departamento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tutores as $tutor)
                        <tr>
                            <td>{{ $tutor->id }}</td>
                            <td>{{ $tutor->nombre }}</td>
                            <td>{{ $tutor->apellidos }}</td>
                            <td>{{ $tutor->correo_electronico }}</td>
                            <td>{{ $tutor->telefono ?? 'N/A' }}</td>
                            <td>{{ $tutor->departamento ?? 'Sin asignar' }}</td>
                            <td>
                                <span class="badge bg-{{ $tutor->estado == 'activo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($tutor->estado) }}
                                </span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    {{-- Estilos personalizados opcionales --}}
@stop

@section('js')
    <script> console.log('Vista de tutores cargada correctamente.'); </script>
@stop
