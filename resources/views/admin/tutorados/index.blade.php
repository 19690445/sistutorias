@extends('adminlte::page')

@section('title', 'Tutorados')

@section('content_header')
    <h1 class="text-center">Lista de Tutorados</h1>
@stop

@section('content')
@php
    $user = Auth::user();
    $isAdmin = $user->role->nombre === 'admin';
@endphp

<div class="card shadow">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-users"></i> Tutorados Registrados</h3>
        @if($isAdmin)
            <a href="{{ route('admin.tutorados.create') }}" class="btn btn-red text-primary">
                <i class="fas fa-plus"></i> Nuevo Tutorado
            </a>
        @endif
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="bg-secondary text-white">
                <tr>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Correo Institucional</th>
                    <th>Carrera</th>
                    <th>Semestre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tutorados as $t)
                <tr>
                    <td>{{ $t->matricula }}</td>
                    <td>{{ $t->nombre }} {{ $t->apellidos }}</td>
                    <td>{{ $t->correo_institucional }}</td>
                    <td>{{ $t->carrera }}</td>
                    <td>{{ $t->semestre }}</td>
                    <td>{{ ucfirst($t->estado) }}</td>
                    <td>
                        <!-- Botón Editar (admin o coordinador) -->
                        <a href="{{ route($isAdmin ? 'admin.tutorados.edit' : 'coordinador.tutorados.edit', $t->id) }}" 
                           class="btn btn-warning btn-sm mb-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <!-- Botón Eliminar (solo admin) -->
                        @if($isAdmin)
                            <form action="{{ route('admin.tutorados.destroy', $t->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('¿Seguro que quieres eliminar este tutorado?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
