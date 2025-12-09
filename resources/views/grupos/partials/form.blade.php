@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
    <h1>Grupos</h1>
    <a href="{{ route('grupos.create') }}" class="btn btn-primary">Nuevo Grupo</a>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table id="grupos-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Nombre</th>
                        <th>Tutor</th>
                        <th>Periodo</th>
                        <th>Carrera</th>
                        <th>Semestre</th>
                        <th>Modalidad</th>
                        <th>Turno</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupos as $grupo)
                        <tr>
                            <td>{{ $grupo->clave_grupo }}</td>
                            <td>{{ $grupo->nombre_grupo }}</td>
                            <td>{{ $grupo->tutor->nombre ?? '' }} {{ $grupo->tutor->apellido ?? '' }}</td>
                            <td>{{ $grupo->periodo->nombre_periodo ?? '' }} - {{ $grupo->periodo->año_periodo ?? '' }}</td>
                            <td>{{ $grupo->carrera }}</td>
                            <td>{{ $grupo->semestre }}</td>
                            <td>{{ ucfirst($grupo->modalidad) }}</td>
                            <td>{{ ucfirst($grupo->turno) }}</td>
                            <td>
                                <a href="{{ route('grupos.edit', $grupo->id) }}" class="btn btn-sm btn-warning">Editar</a>

                                <form action="{{ route('grupos.destroy', $grupo->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Está seguro de eliminar este grupo?')">Eliminar</button>
                                </form>

                                <a href="{{ route('tutorados.create', ['grupo_id' => $grupo->id]) }}" 
                                   class="btn btn-sm btn-info">Agregar Tutorado</a>

                                <!-- Formulario para subir Excel -->
                                <form action="{{ route('grupos.import', $grupo->id) }}" method="POST" 
                                      enctype="multipart/form-data" style="margin-top:5px;">
                                    @csrf
                                    <input type="file" name="file" accept=".xlsx,.xls" style="display:inline-block;" required>
                                    <button type="submit" class="btn btn-sm btn-success">Importar Excel</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#grupos-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json"
                }
            });
        });
    </script>
@stop
