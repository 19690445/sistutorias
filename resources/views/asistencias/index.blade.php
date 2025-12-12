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

    <!-- Filtros y Búsqueda -->
    <div class="card mb-3">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0"><i class="fas fa-filter"></i> Filtros de Búsqueda</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('asistencias.index') }}" method="GET" id="filtrosForm">
                <div class="row">
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Grupo</label>
                        <select name="grupo_id" class="form-control">
                            <option value="">Todos los grupos</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}" 
                                    {{ request('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre_grupo }} ({{ $grupo->clave_grupo }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro por Tutor -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tutor</label>
                        <select name="tutor_id" class="form-control">
                            <option value="">Todos los tutores</option>
                            @foreach($tutores as $tutor)
                                <option value="{{ $tutor->id }}" 
                                    {{ request('tutor_id') == $tutor->id ? 'selected' : '' }}>
                                    {{ $tutor->nombre }} {{ $tutor->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro por Estado -->
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-control">
                            <option value="">Todos</option>
                            <option value="si" {{ request('estado') == 'si' ? 'selected' : '' }}>Presente</option>
                            <option value="no" {{ request('estado') == 'no' ? 'selected' : '' }}>Ausente</option>
                            <option value="justificado" {{ request('estado') == 'justificado' ? 'selected' : '' }}>Justificado</option>
                            <option value="np" {{ request('estado') == 'np' ? 'selected' : '' }}>No Programado</option>
                        </select>
                    </div>
                </div>

                <!-- Filtros avanzados -->
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Fecha desde</label>
                        <input type="date" 
                               name="fecha_desde" 
                               class="form-control" 
                               value="{{ request('fecha_desde') }}">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Fecha hasta</label>
                        <input type="date" 
                               name="fecha_hasta" 
                               class="form-control" 
                               value="{{ request('fecha_hasta') }}">
                    </div>

                   
                    <div class="col-md-6 mb-3 d-flex align-items-end">
                        <div class="d-flex gap-2 w-50">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search me-1"></i> Buscar
                            </button>
                            <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalAsistencias }}</h3>
                    <p>Total Asistencias</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $presentes }}</h3>
                    <p>Presentes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $ausentes }}</h3>
                    <p>Ausentes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $porcentajeAsistencia }}%</h3>
                    <p>% Asistencia</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

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
               
                @if(request()->hasAny(['search', 'grupo_id', 'tutor_id', 'estado', 'fecha_desde', 'fecha_hasta']))
                <div class="alert alert-info mb-3">
                    <strong>Filtros activos:</strong>
                    @if(request('search'))
                        <span class="badge badge-info">Buscar: "{{ request('search') }}"</span>
                    @endif
                    @if(request('grupo_id'))
                        <span class="badge badge-info">Grupo: {{ $grupos->find(request('grupo_id'))->nombre_grupo ?? '' }}</span>
                    @endif
                    @if(request('tutor_id'))
                        <span class="badge badge-info">Tutor: {{ $tutores->find(request('tutor_id'))->nombre ?? '' }}</span>
                    @endif
                    @if(request('estado'))
                        <span class="badge badge-info">Estado: {{ ucfirst(request('estado')) }}</span>
                    @endif
                    @if(request('fecha_desde') && request('fecha_hasta'))
                        <span class="badge badge-info">Fecha: {{ request('fecha_desde') }} al {{ request('fecha_hasta') }}</span>
                    @endif
                    <a href="{{ route('asistencias.index') }}" class="float-right">
                        <small><i class="fas fa-times"></i> Limpiar filtros</small>
                    </a>
                </div>
                @endif

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
                    {{ $asistencias->withQueryString()->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h5><i class="icon fas fa-info-circle"></i> No hay asistencias registradas</h5>
                    <p>
                        @if(request()->hasAny(['search', 'grupo_id', 'tutor_id', 'estado', 'fecha_desde', 'fecha_hasta']))
                            No se encontraron resultados con los filtros aplicados.
                        @else
                            Comienza registrando una nueva asistencia.
                        @endif
                    </p>
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
        .small-box {
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .input-group-text {
            background-color: #f8f9fa;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Auto-ocultar alertas
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Confirmación para eliminar
            $('form[method="POST"]').submit(function(e) {
                if ($(this).find('button[type="submit"]').hasClass('btn-danger')) {
                    return confirm('¿Está seguro de eliminar este registro? Esta acción no se puede deshacer.');
                }
            });

            // Tooltips
            $('[title]').tooltip({
                placement: 'top',
                trigger: 'hover'
            });

            // Estilo paginación
            $('.pagination').addClass('pagination-sm');

            // Auto-submit en algunos filtros
            $('select[name="estado"], select[name="grupo_id"], select[name="tutor_id"]').change(function() {
                $('#filtrosForm').submit();
            });

            // Validar rango de fechas
            $('input[name="fecha_hasta"]').change(function() {
                var fechaDesde = $('input[name="fecha_desde"]').val();
                var fechaHasta = $(this).val();
                
                if (fechaDesde && fechaHasta && fechaHasta < fechaDesde) {
                    alert('La fecha hasta debe ser mayor o igual a la fecha desde');
                    $(this).val('');
                }
            });
        });
    </script>
@stop