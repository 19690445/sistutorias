@extends('adminlte::page')

@section('title', 'Canalizaciones')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">
            <i class="fas fa-project-diagram"></i>
            Canalizaciones
        </h1>
        <a href="{{ route('canalizaciones.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Canalización
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
                        Listado de Canalizaciones
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar...">
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
                                    <th>Tipo Atención</th>
                                    <th>Estado</th>
                                    <th>Fecha Propuesta</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($canalizaciones as $canalizacion)
                                    <tr>
                                        <td>{{ $canalizacion->id }}</td>
                                        <td>
                                            <strong>{{ $canalizacion->individual->estudiante->nombre ?? 'N/A' }} {{ $canalizacion->individual->estudiante->apellido ?? '' }}</strong><br>
                                            <small class="text-muted">{{ $canalizacion->individual->estudiante->matricula ?? '' }}</small>
                                        </td>
                                        <td>
                                            {{ $canalizacion->individual->tutor->nombre ?? 'N/A' }} {{ $canalizacion->individual->tutor->apellido ?? '' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $canalizacion->tipo_atencion }}</span>
                                        </td>
                                        <td>
                                            @if($canalizacion->estado == 'pendiente')
                                                <span class="badge badge-warning">Pendiente</span>
                                            @elseif($canalizacion->estado == 'en_proceso')
                                                <span class="badge badge-primary">En Proceso</span>
                                            @else
                                                <span class="badge badge-success">Finalizado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($canalizacion->primera_sesion_propuesta)
                                                {{ \Carbon\Carbon::parse($canalizacion->primera_sesion_propuesta)->format('d/m/Y') }}
                                            @else
                                                <span class="text-muted">No programada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('canalizaciones.show', $canalizacion) }}" 
                                                   class="btn btn-sm btn-info" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('canalizaciones.edit', $canalizacion) }}" 
                                                   class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('canalizaciones.destroy', $canalizacion) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('¿Eliminar esta canalización?')"
                                                            title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                                                <h4>No hay canalizaciones registradas</h4>
                                                <p class="text-muted">Comience creando una nueva canalización.</p>
                                                <a href="{{ route('canalizaciones.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Crear Primera Canalización
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
                            Mostrando {{ $canalizaciones->firstItem() }} a {{ $canalizaciones->lastItem() }} de {{ $canalizaciones->total() }} registros
                        </span>
                    </div>
                    <div class="float-right">
                        {{ $canalizaciones->links() }}
                    </div>
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
        .badge {
            font-size: 0.85em;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
          
            $('input[name="table_search"]').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#btnBuscar').click(function() {
                $('input[name="table_search"]').trigger('keyup');
            });
        });
    </script>
@stop