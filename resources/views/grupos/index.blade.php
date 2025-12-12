@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
    <h1>Grupos</h1>
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
                                <div class="d-flex gap-1">
                                    <!-- Botón ver siempre visible -->
                                    <a href="{{ route('grupos.show', $grupo->id) }}" class="btn btn-sm btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                                        <!-- Solo admin y coordinador pueden agregar, importar, editar y eliminar -->
                                        <a href="{{ route('tutorados.create', ['grupo_id' => $grupo->id]) }}" class="btn btn-sm btn-success" title="Agregar">
                                            <i class="fas fa-user-plus"></i>
                                        </a>
                                        <a href="{{ route('grupos.import.form', $grupo->id) }}" class="btn btn-sm btn-secondary" title="Importar">
                                            <i class="fas fa-file-excel"></i>
                                        </a>
                                        <a href="{{ route('grupos.edit', $grupo->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('grupos.destroy', $grupo->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                                    onclick="return confirm('¿Eliminar?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
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
