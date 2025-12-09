@extends('adminlte::page')

@section('title', 'Editar PAT')

@section('content_header')
    <h1>Programa de Acción Tutorial (PAT)</h1>
    <p>Editar actividades por semana</p>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-warning">
            <h3 class="card-title">Editar Programa de Acción Tutorial</h3>
        </div>
        
        <form action="{{ route('pats.update', $pat->id) }}" method="POST" id="edit-pat-form">
            @csrf
            @method('PUT')
            
            <div class="card-body">
          
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tutores_id">Nombre del Tutor:</label>
                            <select class="form-control select2" id="tutores_id" name="tutores_id" required>
                                <option value="">Seleccionar tutor</option>
                                @foreach($tutores as $tutor)
                                    <option value="{{ $tutor->id }}" {{ $tutor->id == $pat->tutores_id ? 'selected' : '' }}>
                                        {{ $tutor->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="grupos_id">Grupo</label>
                            <select name="grupos_id" id="grupos_id" class="form-control select2" required>
                                <option value="">Seleccione un grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ $grupo->id == $pat->grupos_id ? 'selected' : '' }}>
                                        {{ $grupo->nombre_grupo ?? $grupo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="periodo_id">Periodo</label>
                            <select name="periodo_id" id="periodo_id" class="form-control select2" required>
                                <option value="">Seleccionar</option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ $periodo->id == $pat->periodo_id ? 'selected' : '' }}>
                                        {{ $periodo->nombre_periodo ?? $periodo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">NO.</th>
                                <th width="30%">ACTIVIDAD</th>
                                <th width="10%">RESPONSABLE</th>
                                <th width="5%">P</th>
                                @for($i = 1; $i <= 16; $i++)
                                    <th width="3%" class="text-center">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @php
                     
                                $semanasPlaneadas = $pat->semana_planeada ? explode(',', $pat->semana_planeada) : [];
                                $semanasReales = $pat->semana_real ? explode(',', $pat->semana_real) : [];
                                $esPlaneada = in_array('P', $semanasPlaneadas);
                            @endphp
                            
                            <tr id="actividad-{{ $pat->id }}">
                                <td>1</td>
                                <td>
                                    <input type="text" name="actividad" class="form-control form-control-sm" 
                                           value="{{ $pat->actividad }}" required>
                                </td>
                                <td>
                                    <select name="responsable" class="form-control form-control-sm" required>
                                        <option value="tutor" {{ $pat->responsable == 'tutor' ? 'selected' : '' }}>Tutor</option>
                                        <option value="tutorado" {{ $pat->responsable == 'tutorado' ? 'selected' : '' }}>Tutorado</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="checkbox" name="planeada" value="1" 
                                           class="actividad-checkbox" {{ $esPlaneada ? 'checked' : '' }}>
                                </td>
                                
                                <!-- casillass para semanas -->
                                @for($semana = 1; $semana <= 16; $semana++)
                                    <td>
                                        <input type="checkbox" name="semanas[{{ $semana }}]" value="1" 
                                               class="actividad-checkbox semana-checkbox" 
                                               {{ in_array($semana, $semanasReales) ? 'checked' : '' }}>
                                    </td>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </div>
               
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado">Estado de la Actividad:</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="pendiente" {{ $pat->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_proceso" {{ $pat->estado == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="completado" {{ $pat->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Resumen de Semanas:</label>
                            <div class="alert alert-info">
                                @if(count($semanasReales) > 0)
                                    <strong>Semanas realizadas:</strong> {{ implode(', ', $semanasReales) }}
                                    <br>
                                    <strong>Total semanas:</strong> {{ count($semanasReales) }} de 16
                                @else
                                    <strong>No hay semanas marcadas aún</strong>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-warning" id="btn-update">
                    <i class="fas fa-save"></i> Actualizar PAT
                </button>
                <a href="{{ route('pats.index') }}" class="btn btn-default">Cancelar</a>
            </div>
        </form>
       
    </div>
@stop

@section('css')
    <style>
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .table thead th {
            background-color: #343a40;
            color: white;
        }
        .actividad-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        .responsable-select {
            width: 100%;
            padding: 2px 5px;
            font-size: 0.9rem;
        }
        .card-header.bg-warning {
            background-color: #ffc107 !important;
        }
        .form-control-sm {
            padding: 2px 5px;
            font-size: 0.9rem;
            height: auto;
        }
        .select2-container--default .select2-selection--single {
            height: 38px;
        }
        #btn-update {
            min-width: 120px;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
        
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        
            $('[data-toggle="tooltip"]').tooltip();
         
            const form = document.getElementById('edit-pat-form');
            const originalData = new FormData(form);
            let hasChanges = false;
         
            form.querySelectorAll('input, select, textarea').forEach(input => {
                input.addEventListener('change', function() {
                    hasChanges = true;
                });
                
                if (input.type === 'text' || input.type === 'textarea') {
                    input.addEventListener('input', function() {
                        hasChanges = true;
                    });
                }
            });
          
            let isSubmitting = false;
            form.addEventListener('submit', function(e) {
                if (isSubmitting) {
                    e.preventDefault();
                    return false;
                }
                
                const actividadInput = form.querySelector('input[name="actividad"]');
                if (!actividadInput.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'El nombre de la actividad es requerido'
                    });
                    return false;
                }
                
                isSubmitting = true;
                document.getElementById('btn-update').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';
                document.getElementById('btn-update').disabled = true;
                
                return true;
            });
        });
        
        document.querySelectorAll('.semana-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                actualizarEstado();
            });
        });
        
        function actualizarEstado() {
            const checkboxes = document.querySelectorAll('.semana-checkbox:checked');
            const estadoSelect = document.getElementById('estado');
            
            if (checkboxes.length === 0) {
                estadoSelect.value = 'pendiente';
            } else if (checkboxes.length === 16) {
                estadoSelect.value = 'completado';
            } else {
                estadoSelect.value = 'en_proceso';
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            actualizarEstado();
        });
    </script>
@stop