@extends('adminlte::page')

@section('title', 'Diagnósticos')

@section('content_header')
    <h1>Diagnósticos GRUPAL</h1>
    <p>Gestión de diagnósticos e indicadores</p>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Filtros -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Filtrar Diagnósticos</h3>
                    <div class="card-tools">
                        <a href="{{ route('diagnosticos.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Nuevo Diagnóstico
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('diagnosticos.index') }}" class="form-inline">
                        <div class="form-group mr-3">
                            <label for="grupo_id" class="mr-2">Grupo</label>
                            <select name="grupo_id" id="grupo_id" class="form-control" style="width: 200px;">
                                <option value="">Todos los grupos</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ request('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->nombre_grupo ?? $grupo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mr-3">
                            <label for="periodo_id" class="mr-2">Periodo</label>
                            <select name="periodo_id" id="periodo_id" class="form-control" style="width: 200px;">
                                <option value="">Todos los periodos</option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ request('periodo_id') == $periodo->id ? 'selected' : '' }}>
                                        {{ $periodo->nombre_periodo ?? $periodo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <a href="{{ route('diagnosticos.index') }}" class="btn btn-default ml-2">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Diagnósticos -->
            @if($diagnosticos->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Diagnósticos</h3>
                        <div class="card-tools">
                            <span class="badge badge-primary">{{ $diagnosticos->total() }} registros</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Grupo</th>
                                        <th>Periodo</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Indicadores</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($diagnosticos as $diagnosticoItem)
                                    <tr>
                                        <td>{{ $diagnosticoItem->id }}</td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{ $diagnosticoItem->grupo->nombre_grupo ?? $diagnosticoItem->grupo->nombre ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ $diagnosticoItem->periodo->nombre_periodo ?? $diagnosticoItem->periodo->nombre ?? 'N/A' }}</td>
                                        <td>
                                            @if($diagnosticoItem->fecha_realizacion)
                                                {{ $diagnosticoItem->fecha_realizacion->format('d/m/Y') }}
                                            @else
                                                <span class="text-muted">No asignada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $diagnosticoItem->estado == 'completado' ? 'success' : ($diagnosticoItem->estado == 'en_proceso' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst(str_replace('_', ' ', $diagnosticoItem->estado)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $diagnosticoItem->indicadores->count() }} indicador(es)
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('diagnosticos.edit', $diagnosticoItem->id) }}" 
                                               class="btn btn-xs btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('diagnosticos.destroy', $diagnosticoItem->id) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger" 
                                                        onclick="return confirm('¿Eliminar este diagnóstico y sus indicadores?')" 
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Paginación -->
                        <div class="mt-3">
                            {{ $diagnosticos->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center">
                        <div class="py-5">
                            <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                            <h4>No se encontraron diagnósticos</h4>
                            <p class="text-muted">
                                @if(request('grupo_id') || request('periodo_id'))
                                    No hay diagnósticos registrados con los filtros aplicados.
                                @else
                                    No hay diagnósticos registrados en el sistema.
                                @endif
                            </p>
                            <a href="{{ route('diagnosticos.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Crear Primer Diagnóstico
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
  
    <div class="modal fade" id="detallesModal" tabindex="-1" role="dialog" aria-labelledby="detallesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="detallesModalLabel">Detalles del Diagnóstico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detallesContenido">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .badge {
            font-size: 0.85em;
        }
        .btn-xs {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    </style>
@stop
@section('js')
<script>
    
    function verDetalles(id) {
    
        $('#detallesContenido').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
                <p class="mt-2">Cargando detalles...</p>
            </div>
        `);
        $('#detallesModal').modal('show');
        
        // Hacer solicitud AJAX con timeout
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 segundos timeout
        
        fetch(`/diagnosticos/${id}/detalles`, {
            signal: controller.signal,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            clearTimeout(timeoutId);
            
            if (!response.ok) {
                if (response.status === 404) {
                    throw new Error('Diagnóstico no encontrado');
                } else if (response.status === 500) {
                    throw new Error('Error del servidor');
                } else {
                    throw new Error(`Error ${response.status}: ${response.statusText}`);
                }
            }
            return response.text();
        })
        .then(html => {
            $('#detallesContenido').html(html);
        })
        .catch(error => {
            console.error('Error en AJAX:', error);
            $('#detallesContenido').html(`
                <div class="alert alert-danger">
                    <h5><i class="fas fa-exclamation-triangle"></i> Error al cargar detalles</h5>
                    <p>${error.message}</p>
                    <hr>
                    <p class="mb-1"><strong>Posibles causas:</strong></p>
                    <ul class="mb-0">
                        <li>El diagnóstico no existe</li>
                        <li>Problema de conexión con el servidor</li>
                        <li>La ruta no está correctamente definida</li>
                    </ul>
                </div>
            `);
        })
        .finally(() => {
            clearTimeout(timeoutId);
        });
    }
    
    $(document).ready(function() {
        $('#detallesModal').on('hidden.bs.modal', function () {
            $('#detallesContenido').empty();
        });
    });
</script>
@stop