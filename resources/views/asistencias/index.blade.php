@extends('adminlte::page')

@section('title', 'Registro de Asistencias')

@section('content_header')
    <h1>Registro de Asistencias</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="card-title">Listado de Asistencias</h3>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('asistencias.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Asistencia
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($asistencias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Tutor</th>
                                <th>Estudiante</th>
                                <th>Grupo</th>
                                <th>Sesión</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asistencia)
                            <tr>
                                <td>{{ $asistencia->id }}</td>
                                <td>{{ $asistencia->fecha->format('d/m/Y') }}</td>
                                <td>{{ $asistencia->tutor->nombre ?? 'N/A' }} {{ $asistencia->tutor->apellido ?? '' }}</td>
                                <td>{{ $asistencia->estudiante->nombre ?? 'N/A' }} {{ $asistencia->estudiante->apellido ?? '' }}</td>
                                <td>{{ $asistencia->grupo->nombre_grupo ?? 'N/A' }}</td>
                                <td>{{ $asistencia->sesion }}</td>
                                <td>
                                    @php
                                        $estados = [
                                            'si' => ['label' => 'Presente', 'class' => 'success'],
                                            'no' => ['label' => 'Ausente', 'class' => 'danger'],
                                            'np' => ['label' => 'No Programado', 'class' => 'warning'],
                                            'justificado' => ['label' => 'Justificado', 'class' => 'info'],
                                        ];
                                        $estado = $estados[$asistencia->estado] ?? $estados['no'];
                                    @endphp
                                    <span class="badge badge-{{ $estado['class'] }}">
                                        {{ $estado['label'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('asistencias.edit', $asistencia->id) }}" 
                                           class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('asistencias.destroy', $asistencia->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('¿Está seguro de eliminar esta asistencia?')"
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @if($asistencia->grupo)
                                        <a href="{{ route('asistencias.malla', $asistencia->grupo_id) }}" 
                                           class="btn btn-sm btn-info" title="Ver Malla del Grupo">
                                            <i class="fas fa-th"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3 d-flex justify-content-center">
                    {{ $asistencias->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h5><i class="icon fas fa-info-circle"></i> No hay asistencias registradas</h5>
                    <p>Comienza registrando una nueva asistencia.</p>
                    <a href="{{ route('asistencias.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Registrar Primera Asistencia
                    </a>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">
                        Mostrando <strong>{{ $asistencias->firstItem() ?? 0 }} - {{ $asistencias->lastItem() ?? 0 }}</strong> 
                        de <strong>{{ $asistencias->total() }}</strong> registros
                    </p>
                </div>
                <div class="col-md-6 text-right">
                    <small class="text-muted">
                        <i class="fas fa-history"></i> Última actualización: {{ now()->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table th {
            background-color: #343a40;
            color: white;
            font-weight: 600;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.02);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,.075);
        }
        .btn-group .btn {
            margin-right: 2px;
        }
        .badge {
            font-size: 0.85em;
            padding: 0.4em 0.8em;
        }
        .alert {
            border-radius: 0.5rem;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
           
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            $('form[method="POST"]').submit(function(e) {
                if ($(this).find('button[type="submit"]').hasClass('btn-danger')) {
                    return confirm('¿Está seguro de eliminar este registro? Esta acción no se puede deshacer.');
                }
            });

            
            $('[title]').tooltip({
                placement: 'top',
                trigger: 'hover'
            });

            $('.pagination').addClass('pagination-sm');
        });
    </script>
@stop