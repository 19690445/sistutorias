@extends('adminlte::page')

@section('title', 'Registros Individuales')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">
            <i class="fas fa-users"></i>
            Registros Individuales
        </h1>
        <a href="{{ route('individuales.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Registro
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i>
                        Listado de Registros Individuales
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 300px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar estudiante, tutor...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default" id="btnBuscar">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Estudiante</th>
                                    <th>Tutor</th>
                                    <th>Período</th>
                                    <th>Canalización</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($individuales as $individuo)
                                    <tr>
                                        <td>{{ $individuo->id }}</td>
                                        <td>
                                            <strong>{{ $individuo->estudiante->nombre ?? 'N/A' }} {{ $individuo->estudiante->apellido ?? '' }}</strong><br>
                                            <small class="text-muted">{{ $individuo->estudiante->matricula ?? 'Sin matrícula' }}</small>
                                        </td>
                                        <td>
                                            {{ $individuo->tutor->nombre ?? 'N/A' }} {{ $individuo->tutor->apellido ?? '' }}
                                        </td>
                                        <td>
                                            {{ $individuo->periodo->nombre ?? 'N/A' }}<br>
                                            <small class="text-muted">{{ $individuo->created_at->format('d/m/Y') }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if($individuo->requiere_canalizacion == 'si')
                                                <span class="badge badge-danger">REQUIERE</span>
                                                @if($individuo->canalizaciones_count > 0)
                                                    <br>
                                                    <small class="text-success">
                                                        <i class="fas fa-check-circle"></i> {{ $individuo->canalizaciones_count }} canalizaciones
                                                    </small>
                                                @else
                                                    <br>
                                                    <small class="text-warning">
                                                        <i class="fas fa-exclamation-circle"></i> Pendiente
                                                    </small>
                                                @endif
                                            @else
                                                <span class="badge badge-success">NO REQUIERE</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($individuo->estado == 'pendiente')
                                                <span class="badge badge-warning">Pendiente</span>
                                            @elseif($individuo->estado == 'en_proceso')
                                                <span class="badge badge-primary">En Proceso</span>
                                            @else
                                                <span class="badge badge-success">Completado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('individuales.show', $individuo) }}" 
                                                class="btn btn-sm btn-info" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <a href="{{ route('individuales.edit', $individuo) }}" 
                                                class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                @if($individuo->requiere_canalizacion == 'si' && $individuo->estado != 'completado')
                                                    <a href="{{ route('canalizaciones.create') }}?individual_id={{ $individuo->id }}" 
                                                    class="btn btn-sm btn-primary" title="Crear Canalización">
                                                        <i class="fas fa-project-diagram"></i>
                                                    </a>
                                                @endif
                                                
                                                @if($individuo->canalizaciones_count == 0)
                                                    <form action="{{ route('individuales.destroy', $individuo) }}" 
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('¿Eliminar este registro?')"
                                                                title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                                                <h4>No hay registros individuales</h4>
                                                <p class="text-muted">Comience creando un nuevo registro.</p>
                                                <a href="{{ route('individuales.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Crear Primer Registro
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card-footer clearfix">
                    <div class="float-left">
                        <span class="text-muted">
                            Mostrando {{ $individuales->firstItem() }} a {{ $individuales->lastItem() }} de {{ $individuales->total() }} registros
                        </span>
                    </div>
                    <div class="float-right">
                        {{ $individuales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mt-3">
        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Registros</span>
                    <span class="info-box-number">{{ $individuales->total() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fas fa-exclamation-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Requieren Canalización</span>
                    <span class="info-box-number">
                        {{ $individuales->where('requiere_canalizacion', 'si')->count() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pendientes</span>
                    <span class="info-box-number">
                        {{ $individuales->where('estado', 'pendiente')->count() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Completados</span>
                    <span class="info-box-number">
                        {{ $individuales->where('estado', 'completado')->count() }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table thead th {
            background-color: #343a40;
            color: white;
            border-color: #454d55;
        }
        .empty-state {
            padding: 40px 0;
            text-align: center;
        }
        .empty-state i {
            opacity: 0.5;
        }
        .info-box {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .info-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .badge {
            font-size: 0.85em;
            padding: 4px 8px;
        }
        .btn-group .btn {
            margin-right: 2px;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Buscador en tiempo real
            $('input[name="table_search"]').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#btnBuscar').click(function() {
                $('input[name="table_search"]').trigger('keyup');
            });

            // Confirmación para eliminar
            $('form[method="POST"] button[type="submit"]').click(function(e) {
                if (!confirm('¿Está seguro de eliminar este registro?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@stop