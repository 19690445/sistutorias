@extends('adminlte::page')

@section('title', 'Tomar Asistencia')

@section('content_header')
    <h1>Tomar Asistencia</h1>
@stop

@section('content')
    @if($tutores->isEmpty() || $periodos->isEmpty() || $grupos->isEmpty())
    <div class="alert alert-warning">
        <h5><i class="icon fas fa-exclamation-triangle"></i> Advertencia</h5>
        <p>Faltan datos necesarios para tomar asistencia:</p>
        <ul>
            @if($tutores->isEmpty()) <li>No hay tutores registrados</li> @endif
            @if($periodos->isEmpty()) <li>No hay periodos registrados</li> @endif
            @if($grupos->isEmpty()) <li>No hay grupos registrados</li> @endif
        </ul>
        <p>Por favor, registre los datos faltantes antes de continuar.</p>
    </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Registrar Nueva Asistencia</h3>
        </div>
        <form id="formAsistencia" action="{{ route('asistencias.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tutores_id">Tutor *</label>
                            <select name="tutores_id" id="tutores_id" class="form-control select2" required
                                    {{ $tutores->isEmpty() ? 'disabled' : '' }}>
                                <option value="">Seleccionar Tutor</option>
                                @foreach($tutores as $tutor)
                                    <option value="{{ $tutor->id }}">
                                        {{ $tutor->nombre }} {{ $tutor->apellido }}
                                    </option>
                                @endforeach
                            </select>
                            @if($tutores->isEmpty())
                                <small class="text-danger">No hay tutores disponibles</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="grupo_id">Grupo</label>
                            <select name="grupo_id" id="grupo_id" class="form-control select2" required
                                    {{ $grupos->isEmpty() ? 'disabled' : '' }}>
                                <option value="">Seleccione un grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nombre_grupo }}</option>
                                @endforeach
                            </select>
                            @if($grupos->isEmpty())
                                <small class="text-danger">No hay grupos disponibles</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="periodo_id">Periodo</label>
                            <select name="periodo_id" id="periodo_id" class="form-control select2" required
                                    {{ $periodos->isEmpty() ? 'disabled' : '' }}>
                                <option value="">Seleccionar</option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}">{{ $periodo->nombre_periodo ?? $periodo->nombre }}</option>
                                @endforeach
                            </select>
                            @if($periodos->isEmpty())
                                <small class="text-danger">No hay periodos disponibles</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sesion">Sesión</label>
                            <input type="number" name="sesion" id="sesion" 
                                   class="form-control" min="1" value="1" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" id="fecha" 
                                   class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>

                <div id="estudiantes-container" style="display: none;">
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4>Lista de Estudiantes</h4>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" id="marcar-todos">
                                    <i class="fas fa-check-circle"></i> Marcar Todos Presentes
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" id="marcar-ausentes">
                                    <i class="fas fa-times-circle"></i> Marcar Todos Ausentes
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="35%">Estudiante</th>
                                    <th width="25%">Asistencia</th>
                                    <th width="35%">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody id="lista-estudiantes">
                                <!-- Los estudiantes se cargan aquí  -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="btnGuardar" class="btn btn-success" disabled>
                    <i class="fas fa-save"></i> Guardar Asistencia
                </button>
                <a href="{{ route('asistencias.index') }}" class="btn btn-default">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
    <style>
        .select2-container--bootstrap .select2-selection {
            border: 1px solid #ced4da;
            height: 38px;
        }
        .estado-select {
            min-width: 150px;
        }
    </style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        
        $('.select2').select2({
            theme: 'bootstrap',
            placeholder: 'Seleccionar...',
            allowClear: false
        });
        
        $('#grupo_id').change(function() {
            const grupoId = $(this).val();
            
            if (!grupoId) {
                $('#estudiantes-container').hide();
                $('#btnGuardar').prop('disabled', true);
                return;
            }
            
            const url = "{{ url('asistencias/estudiantes') }}/" + grupoId;
            console.log('Solicitando estudiantes de grupo:', grupoId);
            console.log('URL:', url);
            
           
            $('#lista-estudiantes').html('<tr><td colspan="4" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando estudiantes...</td></tr>');
            $('#estudiantes-container').show();
            
          
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Respuesta recibida:', response);
                    const tbody = $('#lista-estudiantes');
                    tbody.empty();
                    
                    if (response && response.length > 0) {
                        response.forEach(function(estudiante, index) {
                            const row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>
                                        ${estudiante.nombre_completo}
                                        <input type="hidden" name="estudiantes[${index}][id]" 
                                               value="${estudiante.id}">
                                    </td>
                                    <td>
                                        <select name="estudiantes[${index}][estado]" 
                                                class="form-control estado-select" required>
                                            <option value="si" selected>Presente</option>
                                            <option value="no">Ausente</option>
                                            <option value="np">No Programado</option>
                                            <option value="justificado">Justificado</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" 
                                               name="estudiantes[${index}][observaciones]" 
                                               class="form-control" 
                                               placeholder="Observaciones...">
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                        
                        $('#btnGuardar').prop('disabled', false);
                        
                
                        $('.estado-select').select2({
                            theme: 'bootstrap',
                            minimumResultsForSearch: -1
                        });
                    } else {
                        tbody.html('<tr><td colspan="4" class="text-center text-danger">No hay estudiantes en este grupo</td></tr>');
                        $('#btnGuardar').prop('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en AJAX:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        responseText: xhr.responseText,
                        error: error
                    });
                    
                    $('#lista-estudiantes').html(
                        '<tr><td colspan="4" class="text-center text-danger">' +
                        '<i class="fas fa-exclamation-triangle"></i> Error al cargar estudiantes<br>' +
                        'Código: ' + xhr.status + ' - ' + error +
                        '</td></tr>'
                    );
                    
                    $('#btnGuardar').prop('disabled', true);
                }
            });
        });

    
        $('#marcar-todos').click(function() {
            $('.estado-select').val('si').trigger('change');
        });

        $('#marcar-ausentes').click(function() {
            $('.estado-select').val('no').trigger('change');
        });

        function validarFormulario() {
            const grupoId = $('#grupo_id').val();
            const periodoId = $('#periodo_id').val();
            const sesion = $('#sesion').val();
            const fecha = $('#fecha').val();
            const tutorId = $('#tutores_id').val();
            
            return grupoId && periodoId && sesion && fecha && tutorId;
        }

        $('select, input').change(function() {
            const grupoId = $('#grupo_id').val();
            if (grupoId && $('#lista-estudiantes tr').length > 0) {
                $('#btnGuardar').prop('disabled', false);
            } else {
                $('#btnGuardar').prop('disabled', true);
            }
        });
    });
</script>
@stop