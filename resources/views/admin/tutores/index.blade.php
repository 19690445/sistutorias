@extends('adminlte::page')

@section('title', 'Tutores')

@section('content_header')
    <h1>Tutores</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('tutores.create') }}" class="btn btn-primary mb-3">Agregar Tutor</a>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Foto</th>
                    <th>Nombre completo</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Departamento</th>
                    <th>Nivel de estudios</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tutores as $tutor)
                <tr>
           
                    <td>
                        @if($tutor->foto_perfil && file_exists(public_path('storage/'.$tutor->foto_perfil)))
                            <img src="{{ asset('storage/'.$tutor->foto_perfil) }}" alt="Foto" class="rounded-circle" width="70" height="70">
                        @else
                            <img src="{{ asset('img/default.png') }}" alt="Foto" class="rounded-circle" width="70" height="70">
                        @endif
                    </td>

                    <td>{{ $tutor->nombre }} {{ $tutor->apellidos }}</td>
                    <td>{{ $tutor->correo_electronico }}</td>
                    <td>{{ $tutor->telefono ?? '---' }}</td>
                    <td>{{ $tutor->departamento ?? '---' }}</td>
                    <td>{{ $tutor->nivel_estudios ?? '---' }}</td>
                    <td>
                        @if($tutor->estado == 'activo')
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('tutores.show', $tutor) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('tutores.edit', $tutor) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('tutores.destroy', $tutor) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar este docente?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
