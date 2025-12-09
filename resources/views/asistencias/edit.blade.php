@extends('adminlte::page')

@section('title', 'Editar Asistencia')

@section('content_header')
    <h1>Editar Asistencia</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-warning">
        <h3 class="card-title">Editar Registro de Asistencia</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('asistencias.update', $asistencia->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                @if(in_array(Auth::user()->rol, ['admin', 'coordinador']))
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tutores_id">Tutor</label>
                        <select name="tutores_id" id="tutores_id" class="form-control select2">
                            <option value="">Seleccionar Tutor</option>
                            @foreach($tutores as $tutor)
                                <option value="{{ $tutor->id }}" {{ $asistencia->tutores_id == $tutor->id ? 'selected' : '' }}>
                                    {{ $tutor->nombre }} {{ $tutor->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="grupo_id">Grupo</label>
                        <select name="grupo_id" id="grupo_id" class="form-control select2" required>
                            <option value="">Seleccionar Grupo</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}" {{ $asistencia->grupo_id == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre_grupo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="periodo_id">Periodo</label>
                        <select name="periodo_id" id="periodo_id" class="form-control select2" required>
                            <option value="">Seleccionar Periodo</option>
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo->id }}" {{ $asistencia->periodo_id == $periodo->id ? 'selected' : '' }}>
                                    {{ $periodo->nombre_periodo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="estudiantes_id">Estudiante</label>
                        <select name="estudiantes_id" id="estudiantes_id" class="form-control select2" required>
                            <option value="">Cargando estudiantes</option>
                            @if($asistencia->grupo)
                                @foreach($asistencia->grupo->estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id }}" {{ $asistencia->estudiantes_id == $estudiante->id ? 'selected' : '' }}>
                                        {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="sesion">Sesión</label>
                        <input type="number" name="sesion" class="form-control" 
                               value="{{ old('sesion', $asistencia->sesion) }}" min="1" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" class="form-control" 
                               value="{{ old('fecha', $asistencia->fecha->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select name="estado" class="form-control">
                            <option value="si" {{ $asistencia->estado == 'si' ? 'selected' : '' }}>Presente</option>
                            <option value="no" {{ $asistencia->estado == 'no' ? 'selected' : '' }}>Ausente</option>
                            <option value="np" {{ $asistencia->estado == 'np' ? 'selected' : '' }}>No Programado</option>
                            <option value="justificado" {{ $asistencia->estado == 'justificado' ? 'selected' : '' }}>Justificado</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="estado">&nbsp;</label>
                        <div class="form-control-plaintext">
                            @php
                                $estados = [
                                    'si' => ['label' => 'Presente', 'class' => 'badge-success'],
                                    'no' => ['label' => 'Ausente', 'class' => 'badge-danger'],
                                    'np' => ['label' => 'No Prog.', 'class' => 'badge-warning'],
                                    'justificado' => ['label' => 'Justificado', 'class' => 'badge-info'],
                                ];
                                $estado = $estados[$asistencia->estado] ?? $estados['no'];
                            @endphp
                            <span class="badge {{ $estado['class'] }}">{{ $estado['label'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="3" 
                                  placeholder="Observaciones adicionales...">{{ old('observaciones', $asistencia->observaciones) }}</textarea>
                        <small class="text-muted">Opcional. Máximo 500 caracteres.</small>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('asistencias.index') }}" class="btn btn-default">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    
                    <div class="float-right">
                        <span class="text-muted mr-3">
                            <i class="fas fa-calendar"></i> Creado: {{ $asistencia->created_at->format('d/m/Y H:i') }}
                        </span>
                        <span class="text-muted">
                            <i class="fas fa-history"></i> Actualizado: {{ $asistencia->updated_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding-top: 4px;
    }
    .card {
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    
    $('.select2').select2({
        theme: 'bootstrap',
        placeholder: 'Seleccionar...'
    });

    $('#grupo_id').change(function() {
        const grupoId = $(this).val();
        const estudianteSelect = $('#estudiantes_id');
        
        if (grupoId) {
            estudianteSelect.html('<option value="">Cargando estudiantes...</option>');
            
            $.ajax({
                url: '/asistencias/estudiantes/' + grupoId,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    estudianteSelect.html('<option value="">Seleccionar Estudiante</option>');
                    
                    response.forEach(function(estudiante) {
                        const selected = {{ $asistencia->estudiantes_id }} == estudiante.id ? 'selected' : '';
                        estudianteSelect.append(
                            `<option value="${estudiante.id}" ${selected}>${estudiante.nombre_completo}</option>`
                        );
                    });
                    
                    estudianteSelect.select2();
                },
                error: function() {
                    estudianteSelect.html('<option value="">Error al cargar estudiantes</option>');
                }
            });
        } else {
            estudianteSelect.html('<option value="">Seleccione un grupo primero</option>');
        }
    });

    $('form').submit(function(e) {
        const sesion = $('input[name="sesion"]').val();
        const fecha = $('input[name="fecha"]').val();
        
        if (!sesion || !fecha) {
            e.preventDefault();
            alert('Por favor complete todos los campos requeridos.');
            return false;
        }
        
        return true;
    });
});
</script>
@stop