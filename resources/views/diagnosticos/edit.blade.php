@extends('adminlte::page')

@section('title', 'Editar Diagnóstico')

@section('content_header')
    <h1>EDITAR DIAGNOSTICO GRUPAL</h1>
    <p>Modificar información del diagnóstico grupal e indicadores</p>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-warning">
            <h3 class="card-title">Editar Diagnóstico</h3>
        </div>
        
        <form action="{{ route('diagnosticos.update', $diagnostico->id) }}" method="POST" id="diagnostico-form">
            @csrf
            @method('PUT')
            
            <div class="card-body">
              
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="grupos_id">Grupo <span class="text-danger">*</span></label>
                            <select name="grupos_id" id="grupos_id" class="form-control" required>
                                <option value="">Seleccione un grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ $diagnostico->grupos_id == $grupo->id ? 'selected' : '' }}>
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
                                    <option value="{{ $periodo->id }}" {{ $diagnostico->periodo_id == $periodo->id ? 'selected' : '' }}>
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
                                   class="form-control" 
                                   value="{{ $diagnostico->fecha_realizacion ? $diagnostico->fecha_realizacion->format('Y-m-d') : date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="problemarios">Problemarios Detectados</label>
                    <textarea name="problemarios" id="problemarios" class="form-control" 
                              rows="4" placeholder="Describa los principales problemas identificados...">{{ $diagnostico->problemarios }}</textarea>
                </div>

                <div class="form-group mb-4">
                    <label for="solucion">Solución Propuesta</label>
                    <textarea name="solucion" id="solucion" class="form-control" 
                              rows="4" placeholder="Describa la solución o estrategia a implementar...">{{ $diagnostico->solucion }}</textarea>
                </div>

            
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-table"></i> Indicadores Detectados
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success btn-sm" id="btn-agregar-fila">
                                <i class="fas fa-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tabla-indicadores">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="45%">INDICADOR</th>
                                        <th width="15%">SE PRESENTA</th>
                                        <th width="25%">CAUSA O PROBLEMÁTICA</th>
                                        <th width="10%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="indicadores-body">
                                    @if($diagnostico->indicadores && $diagnostico->indicadores->count() > 0)
                                        @foreach($diagnostico->indicadores as $index => $indicador)
                                        <tr id="fila-{{ $index }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <input type="hidden" name="indicadores[{{ $index }}][id]" value="{{ $indicador->id }}">
                                                <select name="indicadores[{{ $index }}][indicador]" class="form-control form-control-sm indicador-select" required>
                                                    <option value="">Seleccionar indicador</option>
                                                    <option value="Inadaptación al Medio Académico" {{ $indicador->descripcion == 'Inadaptación al Medio Académico' ? 'selected' : '' }}>
                                                        Inadaptación al Medio Académico
                                                    </option>
                                                    <option value="Problemas de salud" {{ $indicador->descripcion == 'Problemas de salud' ? 'selected' : '' }}>
                                                        Problemas de salud
                                                    </option>
                                                    <option value="Problemas Vocacionales" {{ $indicador->descripcion == 'Problemas Vocacionales' ? 'selected' : '' }}>
                                                        Problemas Vocacionales
                                                    </option>
                                                    <option value="Relación docente - estudiantil" {{ $indicador->descripcion == 'Relación docente - estudiantil' ? 'selected' : '' }}>
                                                        Relación docente - estudiantil
                                                    </option>
                                                    <option value="Relación estudiante - estudiante" {{ $indicador->descripcion == 'Relación estudiante - estudiante' ? 'selected' : '' }}>
                                                        Relación estudiante - estudiante
                                                    </option>
                                                    <option value="Toma de decisiones académicas" {{ $indicador->descripcion == 'Toma de decisiones académicas' ? 'selected' : '' }}>
                                                        Toma de decisiones académicas
                                                    </option>
                                                    <option value="Problemas afectivos" {{ $indicador->descripcion == 'Problemas afectivos' ? 'selected' : '' }}>
                                                        Problemas afectivos
                                                    </option>
                                                    <option value="Perfiles de ingreso inadecuados" {{ $indicador->descripcion == 'Perfiles de ingreso inadecuados' ? 'selected' : '' }}>
                                                        Perfiles de ingreso inadecuados
                                                    </option>
                                                    <option value="Falta de Hábitos de Estudio" {{ $indicador->descripcion == 'Falta de Hábitos de Estudio' ? 'selected' : '' }}>
                                                        Falta de Hábitos de Estudio
                                                    </option>
                                                    <option value="Capacidades sobresalientes" {{ $indicador->descripcion == 'Capacidades sobresalientes' ? 'selected' : '' }}>
                                                        Capacidades sobresalientes
                                                    </option>
                                                    <option value="Insuficientes recursos económicos" {{ $indicador->descripcion == 'Insuficientes recursos económicos' ? 'selected' : '' }}>
                                                        Insuficientes recursos económicos
                                                    </option>
                                                    <option value="Dificultades de socialización" {{ $indicador->descripcion == 'Dificultades de socialización' ? 'selected' : '' }}>
                                                        Dificultades de socialización
                                                    </option>
                                                    <option value="OTRO" {{ !in_array($indicador->descripcion, [
                                                        'Inadaptación al Medio Académico',
                                                        'Problemas de salud',
                                                        'Problemas Vocacionales',
                                                        'Relación docente - estudiantil',
                                                        'Relación estudiante - estudiante',
                                                        'Toma de decisiones académicas',
                                                        'Problemas afectivos',
                                                        'Perfiles de ingreso inadecuados',
                                                        'Falta de Hábitos de Estudio',
                                                        'Capacidades sobresalientes',
                                                        'Insuficientes recursos económicos',
                                                        'Dificultades de socialización'
                                                    ]) ? 'selected' : '' }}>
                                                        OTRO (Especificar)
                                                    </option>
                                                </select>
                                                <input type="text" name="indicadores[{{ $index }}][indicador_otro]" 
                                                       class="form-control form-control-sm mt-1 indicador-otro" 
                                                       placeholder="Especificar otro indicador" 
                                                       value="{{ !in_array($indicador->descripcion, [
                                                        'Inadaptación al Medio Académico',
                                                        'Problemas de salud',
                                                        'Problemas Vocacionales',
                                                        'Relación docente - estudiantil',
                                                        'Relación estudiante - estudiante',
                                                        'Toma de decisiones académicas',
                                                        'Problemas afectivos',
                                                        'Perfiles de ingreso inadecuados',
                                                        'Falta de Hábitos de Estudio',
                                                        'Capacidades sobresalientes',
                                                        'Insuficientes recursos económicos',
                                                        'Dificultades de socialización'
                                                    ]) ? $indicador->descripcion : '' }}"
                                                       style="{{ !in_array($indicador->descripcion, [
                                                        'Inadaptación al Medio Académico',
                                                        'Problemas de salud',
                                                        'Problemas Vocacionales',
                                                        'Relación docente - estudiantil',
                                                        'Relación estudiante - estudiante',
                                                        'Toma de decisiones académicas',
                                                        'Problemas afectivos',
                                                        'Perfiles de ingreso inadecuados',
                                                        'Falta de Hábitos de Estudio',
                                                        'Capacidades sobresalientes',
                                                        'Insuficientes recursos económicos',
                                                        'Dificultades de socialización'
                                                    ]) ? '' : 'display: none;' }}">
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-inline-block">
                                                    <input type="checkbox" name="indicadores[{{ $index }}][presencia]" value="1" 
                                                           class="form-check-input presencia-checkbox" id="presencia_{{ $index }}"
                                                           {{ str_contains($indicador->notas ?? '', 'presencia SI') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="presencia_{{ $index }}">SI</label>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea name="indicadores[{{ $index }}][causa]" class="form-control form-control-sm" 
                                                          rows="1" placeholder="Describa la causa">{{ $indicador->causa }}</textarea>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm btn-eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                      
                                        <tr id="fila-0">
                                            <td>1</td>
                                            <td>
                                                <select name="indicadores[0][indicador]" class="form-control form-control-sm indicador-select" required>
                                                    <option value="">Seleccionar indicador</option>
                                                    <option value="Inadaptación al Medio Académico">Inadaptación al Medio Académico</option>
                                                    <option value="Problemas de salud">Problemas de salud</option>
                                                    <option value="Problemas Vocacionales">Problemas Vocacionales</option>
                                                    <option value="Relación docente - estudiantil">Relación docente - estudiantil</option>
                                                    <option value="Relación estudiante - estudiante">Relación estudiante - estudiante</option>
                                                    <option value="Toma de decisiones académicas">Toma de decisiones académicas</option>
                                                    <option value="Problemas afectivos">Problemas afectivos</option>
                                                    <option value="Perfiles de ingreso inadecuados">Perfiles de ingreso inadecuados</option>
                                                    <option value="Falta de Hábitos de Estudio">Falta de Hábitos de Estudio</option>
                                                    <option value="Capacidades sobresalientes">Capacidades sobresalientes</option>
                                                    <option value="Insuficientes recursos económicos">Insuficientes recursos económicos</option>
                                                    <option value="Dificultades de socialización">Dificultades de socialización</option>
                                                    <option value="OTRO">OTRO (Especificar)</option>
                                                </select>
                                                <input type="text" name="indicadores[0][indicador_otro]" 
                                                       class="form-control form-control-sm mt-1 indicador-otro" 
                                                       placeholder="Especificar otro indicador" style="display: none;">
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-inline-block">
                                                    <input type="checkbox" name="indicadores[0][presencia]" value="1" 
                                                           class="form-check-input presencia-checkbox" id="presencia_0">
                                                    <label class="form-check-label" for="presencia_0">SI</label>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea name="indicadores[0][causa]" class="form-control form-control-sm" 
                                                          rows="1" placeholder="Describa la causa"></textarea>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm btn-eliminar" disabled>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btn-agregar-todos">
                                <i class="fas fa-list"></i> Agregar Todos los Indicadores
                            </button>
                            <button type="button" class="btn btn-outline-warning btn-sm" id="btn-limpiar">
                                <i class="fas fa-broom"></i> Limpiar Tabla
                            </button>
                        </div>
                    </div>
                </div>

           
                <div class="form-group mb-4">
                    <label for="objetivos">Objetivos del Diagnóstico</label>
                    <textarea name="objetivos" id="objetivos" class="form-control" 
                              rows="3" placeholder="Establezca los objetivos a alcanzar...">{{ $diagnostico->objetivos }}</textarea>
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
                                      rows="3" placeholder="Observaciones adicionales...">{{ $diagnostico->observaciones }}</textarea>
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
        #tabla-indicadores th {
            background-color: #343a40;
            color: white;
            text-align: center;
            vertical-align: middle;
        }
        #tabla-indicadores td {
            vertical-align: middle;
        }
        .form-check-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        .form-check-label {
            margin-left: 0.3rem;
            cursor: pointer;
        }
        .presencia-checkbox:checked {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-sm {
            padding: 0.15rem 0.4rem;
            font-size: 0.8rem;
        }
    </style>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    let contadorFilas = {{ $diagnostico->indicadores ? $diagnostico->indicadores->count() : 0 }};
    if (contadorFilas === 0) contadorFilas = 1;
    
    const indicadoresBase = [
        "Inadaptación al Medio Académico",
        "Problemas de salud",
        "Problemas Vocacionales",
        "Relación docente - estudiantil",
        "Relación estudiante - estudiante",
        "Toma de decisiones académicas",
        "Problemas afectivos",
        "Perfiles de ingreso inadecuados",
        "Falta de Hábitos de Estudio",
        "Capacidades sobresalientes",
        "Insuficientes recursos económicos",
        "Dificultades de socialización"
    ];
    
    function agregarFila(indicadorPredefinido = '', presencia = false, causa = '') {
        const filaId = contadorFilas;
        contadorFilas++;
        

        let options = '<option value="">Seleccionar indicador</option>';
        indicadoresBase.forEach(function(ind) {
            const selected = ind === indicadorPredefinido ? 'selected' : '';
            options += `<option value="${ind}" ${selected}>${ind}</option>`;
        });
        options += '<option value="OTRO">OTRO (Especificar)</option>';
        
       
        const mostrarOtro = indicadorPredefinido && !indicadoresBase.includes(indicadorPredefinido);
        
        const nuevaFila = `
            <tr id="fila-${filaId}">
                <td>${contadorFilas}</td>
                <td>
                    <select name="indicadores[${filaId}][indicador]" class="form-control form-control-sm indicador-select" required>
                        ${options}
                    </select>
                    <input type="text" name="indicadores[${filaId}][indicador_otro]" 
                           class="form-control form-control-sm mt-1 indicador-otro" 
                           placeholder="Especificar otro indicador" 
                           value="${mostrarOtro ? indicadorPredefinido : ''}"
                           style="${mostrarOtro ? '' : 'display: none;'}">
                </td>
                <td class="text-center">
                    <div class="form-check d-inline-block">
                        <input type="checkbox" name="indicadores[${filaId}][presencia]" value="1" 
                               class="form-check-input presencia-checkbox" id="presencia_${filaId}"
                               ${presencia ? 'checked' : ''}>
                        <label class="form-check-label" for="presencia_${filaId}">SI</label>
                    </div>
                </td>
                <td>
                    <textarea name="indicadores[${filaId}][causa]" class="form-control form-control-sm" 
                              rows="1" placeholder="Describa la causa...">${causa}</textarea>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        
        document.getElementById('indicadores-body').insertAdjacentHTML('beforeend', nuevaFila);
        
      
        renumerarFilas();
    }
    
    function renumerarFilas() {
        const filas = document.querySelectorAll('#indicadores-body tr');
        filas.forEach((fila, index) => {
            fila.querySelector('td:first-child').textContent = index + 1;
            
            
            const btnEliminar = fila.querySelector('.btn-eliminar');
            if (filas.length === 1) {
                btnEliminar.disabled = true;
            } else {
                btnEliminar.disabled = false;
            }
        });
    }
    
   
    document.getElementById('btn-agregar-fila').addEventListener('click', function() {
        agregarFila();
    });
    
  
    document.getElementById('btn-agregar-todos').addEventListener('click', function() {
        indicadoresBase.forEach(function(indicador) {
            agregarFila(indicador);
        });
        alert('Se agregaron todos los indicadores predefinidos');
    });
    
  
    document.getElementById('btn-limpiar').addEventListener('click', function() {
        if (confirm('¿Está seguro de limpiar toda la tabla? Se eliminarán todos los indicadores.')) {
            document.getElementById('indicadores-body').innerHTML = '';
            contadorFilas = 0;
            
        
            agregarFila();
        }
    });
    
    
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('indicador-select')) {
            const fila = e.target.closest('tr');
            const campoOtro = fila.querySelector('.indicador-otro');
            
            if (e.target.value === 'OTRO') {
                campoOtro.style.display = 'block';
                campoOtro.required = true;
                campoOtro.focus();
            } else {
                campoOtro.style.display = 'none';
                campoOtro.required = false;
                campoOtro.value = '';
            }
        }
    });
    
   
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-eliminar')) {
            const fila = e.target.closest('tr');
            const totalFilas = document.querySelectorAll('#indicadores-body tr').length;
            
            if (totalFilas > 1) {
                if (confirm('¿Eliminar este indicador?')) {
                    fila.remove();
                    renumerarFilas();
                }
            } else {
                alert('Debe mantener al menos un indicador');
            }
        }
    });
    
   
    document.getElementById('diagnostico-form').addEventListener('submit', function(e) {
       
        const totalFilas = document.querySelectorAll('#indicadores-body tr').length;
        if (totalFilas === 0) {
            e.preventDefault();
            alert('Debe agregar al menos un indicador');
            return false;
        }
   
        let valido = true;
        const selects = document.querySelectorAll('.indicador-select');
        
        selects.forEach((select, index) => {
            if (!select.value) {
                valido = false;
                alert(`La fila ${index + 1} NO tiene un indicador seleccionado`);
                select.focus();
                return false;
            }
            
            if (select.value === 'OTRO') {
                const campoOtro = select.closest('tr').querySelector('.indicador-otro');
                if (!campoOtro.value.trim()) {
                    valido = false;
                    alert(`La fila ${index + 1} tiene "OTRO" seleccionado pero no especificó el indicador`);
                    campoOtro.focus();
                    return false;
                }
            }
        });
        
        if (!valido) {
            e.preventDefault();
            return false;
        }
        
        const btnSubmit = this.querySelector('button[type="submit"]');
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';
        
        return true;
    });
    
 
    const primerSelect = document.querySelector('.indicador-select');
    if (primerSelect) {
        primerSelect.addEventListener('change', function() {
            const campoOtro = this.closest('tr').querySelector('.indicador-otro');
            if (this.value === 'OTRO') {
                campoOtro.style.display = 'block';
                campoOtro.required = true;
            } else {
                campoOtro.style.display = 'none';
                campoOtro.required = false;
                campoOtro.value = '';
            }
        });
    }
    
    renumerarFilas();
});
</script>
@stop