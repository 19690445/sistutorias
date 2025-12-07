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
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Departamento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tutores as $tutor)
                <tr>
                    <td class="text-center">
                        @php
                            $foto = $tutor->foto_perfil ? asset('storage/'.$tutor->foto_perfil) : asset('img/default.png');
                        @endphp
                        <img src="{{ $foto }}" alt="Foto" width="50" class="img-thumbnail tutor-img" style="cursor:pointer;" title="Click para ver">
                    </td>
                    <td>{{ $tutor->nombre }} {{ $tutor->apellidos }}</td>
                    <td>{{ $tutor->correo_electronico }}</td>
                    <td>{{ $tutor->telefono }}</td>
                    <td>{{ $tutor->departamento }}</td>
                    <td>{{ ucfirst($tutor->estado) }}</td>
                    <td>
                        <a href="{{ route('tutores.show', $tutor) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('tutores.edit', $tutor) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('tutores.destroy', $tutor) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar este tutor?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="fotoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <img id="fotoPreview" src="" alt="Foto Tutor" class="img-fluid">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fotos = document.querySelectorAll('.tutor-img');
        const modal = new bootstrap.Modal(document.getElementById('fotoModal'));
        const preview = document.getElementById('fotoPreview');

        fotos.forEach(foto => {
            foto.addEventListener('click', function () {
                preview.src = this.src;
                modal.show();
            });
        });
    });
</script>
@stop
