@extends('adminlte::page')

@section('title', 'Nueva Canalización')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">
            <i class="fas fa-project-diagram"></i>
            Nueva Canalización
        </h1>
        <a href="{{ route('individuales.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a Individuales
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clipboard-list"></i>
                        Formulario de Canalización
                    </h3>
                </div>

                @if(request()->has('individual_id') && $individualSeleccionado)
                    <div class="alert alert-success m-3">
                        <h5><i class="fas fa-link"></i> Registro Individual Vinculado</h5>
                        <p>
                            <strong>Estudiante:</strong> {{ $individualSeleccionado->estudiante->nombre ?? 'N/A' }} {{ $individualSeleccionado->estudiante->apellido ?? '' }}<br>
                            <strong>Tutor:</strong> {{ $individualSeleccionado->tutor->nombre ?? 'N/A' }} {{ $individualSeleccionado->tutor->apellido ?? '' }}<br>
                            <strong>Período:</strong> {{ $individualSeleccionado->periodo->nombre ?? 'N/A' }}
                        </p>
                    </div>
                @endif

                <form action="{{ route('canalizaciones.store') }}" method="POST" id="formCanalizacion">
                    @csrf
                    
                    <div class="card-body">
                  
                        @if(request()->has('individual_id') && $individualSeleccionado)
                            <input type="hidden" name="individuales_id" value="{{ $individualSeleccionado->id }}">
                        @endif

                        @if(!request()->has('individual_id'))
                        <div class="row border-bottom mb-3 pb-3">
                            <div class="col-12">
                                <h5 class="text-primary">
                                    <i class="fas fa-user-graduate mr-2"></i>SELECCIONAR TUTORADO
                                </h5>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="individuales_id">
                                        <i class="fas fa-user"></i> Estudiante que requiere canalización *
                                    </label>
                                    <select name="individuales_id" id="individuales_id" 
                                            class="form-control select2 @error('individuales_id') is-invalid @enderror" 
                                            {{ request()->has('individual_id') ? 'disabled' : 'required' }}>
                                        <option value="">Seleccione un estudiante</option>
                                        @foreach($individuales as $individuo)
                                            @php
                                                $nombreEstudiante = $individuo->estudiante ? $individuo->estudiante->nombre . ' ' . $individuo->estudiante->apellido : 'N/A';
                                                $nombreTutor = $individuo->tutor ? $individuo->tutor->nombre . ' ' . $individuo->tutor->apellido : 'N/A';
                                            @endphp
                                            <option value="{{ $individuo->id }}" 
                                                {{ (request()->has('individual_id') && $individuo->id == $individualSeleccionado->id) ? 'selected' : '' }}
                                                data-estudiante="{{ $nombreEstudiante }}"
                                                data-tutor="{{ $nombreTutor }}">
                                                {{ $nombreEstudiante }}
                                                - Tutor: {{ $nombreTutor }}
                                                ({{ $individuo->periodo->nombre ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('individuales_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="text-muted">
                                        Solo se muestran estudiantes que requieren canalización y no están completados
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row mb-3" id="infoEstudiante" style="{{ !request()->has('individual_id') ? 'display: none;' : '' }}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Estudiante seleccionado</label>
                                    <input type="text" class="form-control" id="display_estudiante" readonly
                                           value="{{ request()->has('individual_id') ? ($individualSeleccionado->estudiante->nombre ?? '') . ' ' . ($individualSeleccionado->estudiante->apellido ?? '') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tutor asignado</label>
                                    <input type="text" class="form-control" id="display_tutor" readonly
                                           value="{{ request()->has('individual_id') ? ($individualSeleccionado->tutor->nombre ?? '') . ' ' . ($individualSeleccionado->tutor->apellido ?? '') : '' }}">
                                </div>
                            </div>
                        </div>

                     
                        <div class="row border-bottom mb-3 pb-3">
                            <div class="col-12">
                                <h5 class="text-primary">
                                    <i class="fas fa-headset mr-2"></i>TIPO DE ATENCIÓN
                                </h5>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tipo_atencion">
                                        <i class="fas fa-hands-helping"></i> Tipo de atención requerida *
                                    </label>
                        <select name="tipo_atencion" id="tipo_atencion" 
                                class="form-control @error('tipo_atencion') is-invalid @enderror" required>
                            <option value="">Seleccione área de atención</option>
                            <option value="Asesoria Individual">Asesoría Individual</option>
                            <option value="Salud y hábitos alimenticios">Salud y hábitos alimenticios</option>
                            <option value="Consumo de substancias tóxicas">Consumo de sustancias tóxicas</option>
                            <option value="Problemas emocionales">Problemas emocionales</option>
                            <option value="Problemas familiares">Problemas familiares</option>
                            <option value="Problemas académicos">Problemas académicos</option>
                            <option value="Manejo de sexualidad y relaciones de pareja">Manejo de sexualidad y relaciones de pareja</option>
                            <option value="Otros (especifique)">Otros (especifique)</option>
                        </select>
                                    @error('tipo_atencion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                      
                        <div class="row mb-3" id="otrosContainer" style="display: none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="causa_problema">
                                        <i class="fas fa-edit"></i> Especifique el tipo de atención *
                                    </label>
                                    <textarea name="causa_problema" id="causa_problema" 
                                              class="form-control @error('causa_problema') is-invalid @enderror"
                                              rows="2" placeholder="Describa específicamente el tipo de atención requerida">{{ old('causa_problema') }}</textarea>
                                    @error('causa_problema')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sección 3: Detalles del Caso -->
                        <div class="row border-bottom mb-3 pb-3">
                            <div class="col-12">
                                <h5 class="text-primary">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>DETALLES DEL CASO
                                </h5>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="causa_problema_general">
                                        <i class="fas fa-file-medical-alt"></i> Descripción del problema o situación
                                    </label>
                                    <textarea name="causa_problema_general" id="causa_problema_general" 
                                              class="form-control @error('causa_problema_general') is-invalid @enderror"
                                              rows="3" placeholder="Describa el problema específico, situación o motivo de la canalización">{{ old('causa_problema_general') }}</textarea>
                                    @error('causa_problema_general')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 4: Acciones y Planificación -->
                        <div class="row border-bottom mb-3 pb-3">
                            <div class="col-12">
                                <h5 class="text-primary">
                                    <i class="fas fa-tasks mr-2"></i>ACCIÓN Y PLANIFICACIÓN
                                </h5>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="acciones_sugeridas">
                                        <i class="fas fa-clipboard-check"></i> Acciones sugeridas o por tomar *
                                    </label>
                                    <textarea name="acciones_sugeridas" id="acciones_sugeridas" 
                                              class="form-control @error('acciones_sugeridas') is-invalid @enderror"
                                              rows="4" placeholder="Describa las acciones sugeridas o que se planean tomar" required>{{ old('acciones_sugeridas') }}</textarea>
                                    @error('acciones_sugeridas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="primera_sesion_propuesta">
                                        <i class="fas fa-calendar-plus"></i> Fecha propuesta para primera sesión
                                    </label>
                                    <input type="date" name="primera_sesion_propuesta" id="primera_sesion_propuesta"
                                           class="form-control @error('primera_sesion_propuesta') is-invalid @enderror"
                                           value="{{ old('primera_sesion_propuesta') }}">
                                    @error('primera_sesion_propuesta')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="primera_sesion_real">
                                        <i class="fas fa-calendar-check"></i> Fecha real de sesión inicial
                                    </label>
                                    <input type="date" name="primera_sesion_real" id="primera_sesion_real"
                                           class="form-control @error('primera_sesion_real') is-invalid @enderror"
                                           value="{{ old('primera_sesion_real') }}">
                                    @error('primera_sesion_real')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 5: Seguimiento y Estado -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary">
                                    <i class="fas fa-chart-line mr-2"></i>SEGUIMIENTO Y EVALUACIÓN
                                </h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="seguimiento_tutor">
                                        <i class="fas fa-book-medical"></i> Seguimiento del tutor
                                    </label>
                                    <textarea name="seguimiento_tutor" id="seguimiento_tutor" 
                                              class="form-control @error('seguimiento_tutor') is-invalid @enderror"
                                              rows="3" placeholder="Registre aquí las notas de seguimiento">{{ old('seguimiento_tutor') }}</textarea>
                                    @error('seguimiento_tutor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">
                                        <i class="fas fa-tag"></i> Estado de la canalización *
                                    </label>
                                    <select name="estado" id="estado" 
                                            class="form-control @error('estado') is-invalid @enderror" required>
                                        <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="en_proceso" {{ old('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                        <option value="finalizado" {{ old('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                    <div class="form-group mt-3">
                                        <label for="observaciones">
                                            <i class="fas fa-sticky-note"></i> Observaciones generales
                                        </label>
                                        <textarea name="observaciones" id="observaciones" 
                                                  class="form-control @error('observaciones') is-invalid @enderror"
                                                  rows="3" placeholder="Observaciones adicionales">{{ old('observaciones') }}</textarea>
                                        @error('observaciones')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-save"></i> Guardar Canalización
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('individuales.index') }}" class="btn btn-default btn-lg btn-block">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <style>
        .border-bottom {
            border-bottom: 2px solid #dee2e6 !important;
        }
        .required-field:after {
            content: " *";
            color: #dc3545;
        }
        .card-header {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }
        .text-primary {
            color: #764ba2 !important;
        }
        .alert-success {
            border-left: 4px solid #28a745;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Inicializar Select2
            $('.select2').select2({
                placeholder: "Seleccione un estudiante",
                allowClear: true,
                width: '100%'
            });

            // Mostrar información del estudiante seleccionado
            $('#individuales_id').change(function() {
                var selectedOption = $(this).find('option:selected');
                var estudianteInfo = selectedOption.data('estudiante');
                var tutorInfo = selectedOption.data('tutor');
                
                if (estudianteInfo && tutorInfo) {
                    $('#display_estudiante').val(estudianteInfo);
                    $('#display_tutor').val(tutorInfo);
                    $('#infoEstudiante').show();
                } else {
                    $('#infoEstudiante').hide();
                }
            });

            // Mostrar/ocultar campo para "Otros (especifique)"
            $('#tipo_atencion').change(function() {
                if ($(this).val() === 'Otros (especifique)') {
                    $('#otrosContainer').show();
                    $('#causa_problema').attr('required', true);
                } else {
                    $('#otrosContainer').hide();
                    $('#causa_problema').removeAttr('required');
                }
            });
            
            // Trigger change on page load
            $('#tipo_atencion').trigger('change');
            
            // Si viene con individual_id pre-seleccionado
            @if(request()->has('individual_id') && $individualSeleccionado)
                $('#infoEstudiante').show();
            @endif
            
            // Validación del formulario
            $('#formCanalizacion').submit(function(e) {
                let valid = true;
                
                // Validar campos requeridos
                $(this).find('[required]').each(function() {
                    if (!$(this).val().trim()) {
                        valid = false;
                        $(this).addClass('is-invalid');
                        $(this).focus();
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                
                if (!valid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Campos Requeridos',
                        text: 'Por favor complete todos los campos obligatorios',
                        confirmButtonText: 'Entendido'
                    });
                }
            });

            // Mostrar confirmación antes de enviar
            $('#formCanalizacion').submit(function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: '¿Crear canalización?',
                    text: "¿Está seguro de que desea crear esta canalización?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, crear',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar el formulario
                        $(this).unbind('submit').submit();
                    }
                });
            });
            
            // Establecer fecha mínima para campos de fecha
            const today = new Date().toISOString().split('T')[0];
            $('#primera_sesion_propuesta').attr('min', today);
            $('#primera_sesion_real').attr('max', today);
        });
    </script>
    
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif
    
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'Entendido'
            });
        </script>
    @endif
@stop