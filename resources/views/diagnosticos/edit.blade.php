@extends('adminlte::page')

@section('title', 'Editar Diagnóstico')

@section('content_header')
    <h1>EDITAR DIAGNOSTICO GRUPAL</h1>
    <p>Modificar información del diagnóstico</p>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-warning">
            <h3 class="card-title">Editar Diagnóstico</h3>
        </div>
        
        <form action="{{ route('diagnosticos.update', $diagnostico->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-body">
             
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="grupos_id">Grupo<span class="text-danger">*</span></label>
                            <select name="grupos_id" id="grupos_id" class="form-control" required>
                                <option value="">Seleccione un grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ $grupo->id == $diagnostico->grupos_id ? 'selected' : '' }}>
                                        {{ $grupo->nombre_grupo ?? $grupo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="periodo_id">Periodo <span class="text-danger">*</span></label>
                            <select name="periodo_id" id="periodo_id" class="form-control" required>
                                <option value="">Seleccionar</option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ $periodo->id == $diagnostico->periodo_id ? 'selected' : '' }}>
                                        {{ $periodo->nombre_periodo ?? $periodo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_realizacion">Fecha de Realización</label>
                            <input type="date" name="fecha_realizacion" id="fecha_realizacion" 
                                   class="form-control" value="{{ $diagnostico->fecha_realizacion ? $diagnostico->fecha_realizacion->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                </div>


                <div class="form-group mb-4">
                    <label for="problemarios">Problemarios Detectados</label>
                    <textarea name="problemarios" id="problemarios" class="form-control" 
                              rows="4">{{ $diagnostico->problemarios }}</textarea>
                </div>

                <div class="form-group mb-4">
                    <label for="solucion">Solución Propuesta</label>
                    <textarea name="solucion" id="solucion" class="form-control" 
                              rows="4">{{ $diagnostico->solucion }}</textarea>
                </div>

        
                @if($diagnostico->indicadores->count() > 0)
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-table"></i> Indicadores Registrados
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="45%">INDICADOR</th>
                                            <th width="15%">SE PRESENTA</th>
                                            <th width="25%">CAUSA O PROBLEMÁTICA</th>
                                            <th width="10%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($diagnostico->indicadores as $index => $indicador)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $indicador->descripcion }}</td>
                                            <td class="text-center">
                                                @if(str_contains($indicador->notas ?? '', 'presencia SI'))
                                                    <span class="badge badge-success">SI</span>
                                                @else
                                                    <span class="badge badge-secondary">NO</span>
                                                @endif
                                            </td>
                                            <td>{{ $indicador->causa }}</td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-info btn-sm" onclick="editarIndicador({{ $indicador->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('indicadores.destroy', $indicador->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este indicador?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

            
                <div class="form-group mb-4">
                    <label for="objetivos">Objetivos del Diagnóstico</label>
                    <textarea name="objetivos" id="objetivos" class="form-control" 
                              rows="3">{{ $diagnostico->objetivos }}</textarea>
                </div>

            
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado">Estado del Diagnóstico <span class="text-danger">*</span></label>
                            <select name="estado" id="estado" class="form-control" required>
                                <option value="pendiente" {{ $diagnostico->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_proceso" {{ $diagnostico->estado == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="completado" {{ $diagnostico->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="observaciones">Observaciones Generales</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" 
                                      rows="3">{{ $diagnostico->observaciones }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save"></i> Actualizar Diagnóstico
                </button>
                <a href="{{ route('diagnosticos.index') }}" class="btn btn-default">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
@stop

@section('css')
    <style>
        .card-info {
            border-color: #17a2b8;
        }
        .card-info .card-header {
            background-color: #17a2b8;
            color: white;
        }
        table th {
            background-color: #343a40;
            color: white;
            text-align: center;
        }
    </style>
@stop

@section('js')
    <script>
        function editarIndicador(id) {
            
            alert('Función para editar indicador con ID: ' + id);
           
        }
    </script>
@stop