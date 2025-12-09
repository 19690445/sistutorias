@extends('adminlte::page')

@section('title', 'PAT - ' . $pat->nombre_pat)

@section('content_header')
    <h1>PAT: {{ $pat->nombre_pat }}</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">Información del PAT</h3>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $pat->nombre_pat }}</p>
                    <p><strong>Objetivo:</strong> {{ $pat->objetivo ?? 'No especificado' }}</p>
                    <p><strong>Estado:</strong>
                        @php
                            $estados = [
                                'pendiente' => ['label' => 'Pendiente', 'class' => 'warning'],
                                'en_progreso' => ['label' => 'En Progreso', 'class' => 'primary'],
                                'completado' => ['label' => 'Completado', 'class' => 'success'],
                                'cancelado' => ['label' => 'Cancelado', 'class' => 'danger'],
                            ];
                            $estado = $estados[$pat->estado] ?? $estados['pendiente'];
                        @endphp
                        <span class="badge badge-{{ $estado['class'] }}">
                            {{ $estado['label'] }}
                        </span>
                    </p>
                    <p><strong>Avance:</strong>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-success" style="width: {{ $pat->porcentaje_avance }}%">
                                <strong>{{ $pat->porcentaje_avance }}%</strong>
                            </div>
                        </div>
                    </p>
                    <p><strong>Fecha Inicio:</strong> {{ $pat->fecha_inicio->format('d/m/Y') }}</p>
                    <p><strong>Fecha Fin:</strong> {{ $pat->fecha_fin->format('d/m/Y') }}</p>
                    <p><strong>Observaciones:</strong> {{ $pat->observaciones ?? 'Ninguna' }}</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Participantes</h3>
                </div>
                <div class="card-body">
                    <p><strong>Tutor:</strong><br>
                        {{ $pat->tutor->nombre ?? 'N/A' }} {{ $pat->tutor->apellido ?? '' }}<br>
                        <small>{{ $pat->tutor->email ?? '' }}</small>
                    </p>
                    <p><strong>Estudiante:</strong><br>
                        {{ $pat->estudiante->nombre ?? 'N/A' }} {{ $pat->estudiante->apellido ?? '' }}<br>
                        <small>{{ $pat->estudiante->corre_institucional ?? '' }}</small>
                    </p>
                    <p><strong>Grupo:</strong> {{ $pat->grupo->nombre_grupo ?? 'N/A' }}</p>
                    <p><strong>Periodo:</strong> {{ $pat->periodo->nombre_periodo ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">Acciones</h3>
                </div>
                <div class="card-body">
                    <div class="btn-group-vertical w-100">
                        <a href="{{ route('pats.edit', $pat->id) }}" class="btn btn-warning mb-2">
                            <i class="fas fa-edit"></i> Editar PAT
                        </a>
                        <a href="{{ route('pats.actividades', $pat->id) }}" class="btn btn-info mb-2">
                            <i class="fas fa-tasks"></i> Gestionar Actividades
                        </a>
                        <a href="{{ route('pats.index') }}" class="btn btn-default mb-2">
                            <i class="fas fa-arrow-left"></i> Volver a PATs
                        </a>
                        <form action="{{ route('pats.destroy', $pat->id) }}" method="POST" class="w-100">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" 
                                    onclick="return confirm('¿Eliminar este PAT?')">
                                <i class="fas fa-trash"></i> Eliminar PAT
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cronograma 15x16 -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title">Cronograma de Actividades (15x16 semanas)</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <small>Actualizado: {{ $pat->updated_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                        <table class="table table-bordered table-sm" style="min-width: 1200px;">
                            <thead class="thead-dark sticky-top" style="position: sticky; top: 0; z-index: 1;">
                                <tr>
                                    <th rowspan="2" class="text-center align-middle" style="width: 200px;">
                                        Actividades (15)
                                    </th>
                                    <th colspan="16" class="text-center">
                                        Semanas (16)
                                    </th>
                                </tr>
                                <tr>
                                    @for($semana = 1; $semana <= 16; $semana++)
                                    <th class="text-center" style="width: 40px;">
                                        S{{ $semana }}
                                    </th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cronograma as $numero => $data)
                                <tr>
                                    <td>
                                        <strong>Act. {{ $numero }}:</strong> {{ $data['actividad']->nombre_actividad }}
                                        <br>
                                        <small class="text-muted">
                                            Estado: 
                                            @php
                                                $estadosAct = [
                                                    'pendiente' => 'secondary',
                                                    'en_progreso' => 'primary',
                                                    'completado' => 'success',
                                                ];
                                            @endphp
                                            <span class="badge badge-{{ $estadosAct[$data['actividad']->estado] ?? 'secondary' }}">
                                                {{ ucfirst($data['actividad']->estado) }}
                                            </span>
                                        </small>
                                    </td>
                                    @for($semana = 1; $semana <= 16; $semana++)
                                    @php
                                        $registro = $data['semanas'][$semana];
                                    @endphp
                                    <td class="text-center align-middle" 
                                        onclick="marcarSemana({{ $pat->id }}, {{ $data['actividad']->id }}, {{ $semana }}, this)"
                                        style="cursor: pointer; height: 50px;"
                                        title="Act. {{ $numero }} - Semana {{ $semana }}
{{ $registro->observaciones ? 'Observación: ' . $registro->observaciones : 'Click para marcar/completar' }}
{{ $registro->fecha_completado ? 'Completado: ' . $registro->fecha_completado->format('d/m/Y') : '' }}">
                                        @if($registro->completado)
                                            <i class="fas fa-check-circle text-success fa-2x"></i>
                                            <br>
                                            <small class="text-muted">S{{ $semana }}</small>
                                        @else
                                            <i class="far fa-circle text-secondary fa-2x"></i>
                                            <br>
                                            <small class="text-muted">S{{ $semana }}</small>
                                        @endif
                                    </td>
                                    @endfor
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td class="text-right"><strong>Totales por semana:</strong></td>
                                    @for($semana = 1; $semana <= 16; $semana++)
                                    @php
                                        $completadasSemana = 0;
                                        foreach($cronograma as $data) {
                                            if($data['semanas'][$semana]->completado) {
                                                $completadasSemana++;
                                            }
                                        }
                                        $porcentajeSemana = count($cronograma) > 0 
                                            ? round(($completadasSemana / count($cronograma)) * 100) 
                                            : 0;
                                    @endphp
                                    <td class="text-center">
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-info" style="width: {{ $porcentajeSemana }}%"></div>
                                        </div>
                                        <small>{{ $completadasSemana }}/15</small>
                                    </td>
                                    @endfor
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Instrucciones</h6>
                                <p class="mb-1">• Click en cualquier celda para marcar/completar la actividad</p>
                                <p class="mb-0">• Verde: Completado | Gris: Pendiente</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-light">
                                <h6><i class="fas fa-chart-bar"></i> Resumen</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Actividades:</strong> 15</p>
                                        <p class="mb-0"><strong>Semanas:</strong> 16</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Avance:</strong> {{ $pat->porcentaje_avance }}%</p>
                                        <p class="mb-0"><strong>Estado:</strong> {{ ucfirst($pat->estado) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="observacionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Marcar Actividad</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formObservacion">
                        @csrf
                        <input type="hidden" id="pat_id">
                        <input type="hidden" id="actividad_id">
                        <input type="hidden" id="semana">
                        
                        <div class="form-group">
                            <label>Estado</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="completado" name="completado">
                                <label class="form-check-label" for="completado">
                                    Marcar como completado
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="observaciones">Observaciones (opcional)</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" 
                                      rows="3" placeholder="Observaciones sobre esta actividad..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambio()">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .sticky-top {
        background-color: #fff;
    }
    .table-sm td, .table-sm th {
        padding: 0.3rem;
    }
    .progress {
        border-radius: 5px;
        overflow: hidden;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    td:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s;
    }
</style>
@stop

@section('js')
<script>
    function marcarSemana(patId, actividadId, semana, elemento) {
       
        $('#pat_id').val(patId);
        $('#actividad_id').val(actividadId);
        $('#semana').val(semana);
        
        
        const completado = $(elemento).find('.fa-check-circle').length > 0;
        $('#completado').prop('checked', completado);
        
      
        $('#observacionModal').modal('show');
    }
    
    function guardarCambio() {
        const patId = $('#pat_id').val();
        const actividadId = $('#actividad_id').val();
        const semana = $('#semana').val();
        const completado = $('#completado').is(':checked');
        const observaciones = $('#observaciones').val();
        
        $.ajax({
            url: `/pats/${patId}/cronograma`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                actividad_id: actividadId,
                semana: semana,
                completado: completado ? 1 : 0,
                observaciones: observaciones
            },
            success: function(response) {
                if (response.success) {
                 
                    const selector = `td[onclick*="actividad_id=${actividadId}"][onclick*="semana=${semana}"]`;
                    const celda = $(selector);
                    
                    if (completado) {
                        celda.html(`
                            <i class="fas fa-check-circle text-success fa-2x"></i>
                            <br>
                            <small class="text-muted">S${semana}</small>
                        `);
                    } else {
                        celda.html(`
                            <i class="far fa-circle text-secondary fa-2x"></i>
                            <br>
                            <small class="text-muted">S${semana}</small>
                        `);
                    }
                 
                    const estadoBadge = $(`tr:has(td[onclick*="actividad_id=${actividadId}"]) .badge`);
                    if (estadoBadge.length && response.estado_actividad) {
                        const estado = response.estado_actividad;
                        const clases = {
                            'pendiente': 'secondary',
                            'en_progreso': 'primary',
                            'completado': 'success'
                        };
                        estadoBadge.removeClass().addClass(`badge badge-${clases[estado]}`)
                            .text(estado.charAt(0).toUpperCase() + estado.slice(1));
                    }
                    
                    $('#observacionModal').modal('hide');
                    
                   
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                alert('Error al guardar cambios');
            }
        });
    }
    
    $(document).ready(function() {
        // Tooltips para celdas
        $('td[title]').tooltip({
            placement: 'top',
            trigger: 'hover'
        });
    });
</script>
@stop