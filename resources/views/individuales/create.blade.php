@extends('adminlte::page')

@section('title', 'Nuevo Registro Individual')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">
            <i class="fas fa-user-plus"></i>
            Nuevo Registro Individual
        </h1>
        <a href="{{ route('individuales.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-check"></i>
                        Formulario de Registro Individual
                    </h3>
                </div>

                <form action="{{ route('individuales.store') }}" method="POST" id="formIndividual">
                    @csrf
                    
                    <div class="card-body">
                        
                        <div class="row border-bottom mb-3 pb-3">
                            <div class="col-12">
                                <h5 class="text-primary">
                                    <i class="fas fa-info-circle mr-2"></i>INFORMACIÓN BÁSICA
                                </h5>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="periodo_id">
                                        <i class="fas fa-calendar-alt"></i> Período Académico *
                                    </label>
                                    <select name="periodo_id" id="periodo_id" 
                                            class="form-control select2 @error('periodo_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un período</option>
                                        @foreach($periodos as $periodo)
                                            <option value="{{ $periodo->id }}" 
                                                {{ old('periodo_id') == $periodo->id ? 'selected' : '' }}>
                                                {{ $periodo->nombre }} ({{ $periodo->fecha_inicio }} - {{ $periodo->fecha_fin }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('periodo_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tutores_id">
                                        <i class="fas fa-chalkboard-teacher"></i> Tutor Asignado *
                                    </label>
                                    <select name="tutores_id" id="tutores_id" 
                                            class="form-control select2 @error('tutores_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un tutor</option>
                                        @foreach($tutores as $tutor)
                                            <option value="{{ $tutor->id }}" 
                                                {{ old('tutores_id') == $tutor->id ? 'selected' : '' }}>
                                                {{ $tutor->nombre }} {{ $tutor->apellido }}
                                                @if($tutor->especialidad)
                                                    - {{ $tutor->especialidad }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tutores_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estudiantes_id">
                                        <i class="fas fa-user-graduate"></i> Estudiante *
                                    </label>
                                    <select name="estudiantes_id" id="estudiantes_id" 
                                            class="form-control select2 @error('estudiantes_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un estudiante</option>
                                        @foreach($estudiantes as $estudiante)
                                            <option value="{{ $estudiante->id }}" 
                                                {{ old('estudiantes_id') == $estudiante->id ? 'selected' : '' }}>
                                                {{ $estudiante->matricula }} - {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                                                @if($estudiante->carrera)
                                                    ({{ $estudiante->carrera }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('estudiantes_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    
                        <div class="row border-bottom mb-3 pb-3">
                            <div class="col-12">
                                <h5 class="text-primary">
                                    <i class="fas fa-clipboard-check mr-2"></i>EVALUACIÓN DEL TUTORADO
                                </h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="requiere_canalizacion">
                                        <i class="fas fa-project-diagram"></i> ¿Requiere Canalización? *
                                    </label>
                                    <select name="requiere_canalizacion" id="requiere_canalizacion" 
                                            class="form-control @error('requiere_canalizacion') is-invalid @enderror" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="si" {{ old('requiere_canalizacion') == 'si' ? 'selected' : '' }}>Sí, requiere canalización</option>
                                        <option value="no" {{ old('requiere_canalizacion') == 'no' ? 'selected' : '' }}>No, no requiere canalización</option>
                                    </select>
                                    @error('requiere_canalizacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="text-muted">
                                        Si selecciona "Sí", el estudiante podrá acceder al formulario de canalización
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">
                                        <i class="fas fa-tasks"></i> Estado del Proceso *
                                    </label>
                                    <select name="estado" id="estado" 
                                            class="form-control @error('estado') is-invalid @enderror" required>
                                        <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="en_proceso" {{ old('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                        <option value="completado" {{ old('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                 
                        <div class="row mb-3" id="motivoContainer">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="motivo">
                                        <i class="fas fa-comment-dots"></i> Motivo o Observaciones
                                    </label>
                                    <textarea name="motivo" id="motivo" 
                                              class="form-control @error('motivo') is-invalid @enderror"
                                              rows="3" placeholder="Describa el motivo por el cual requiere o no canalización">{{ old('motivo') }}</textarea>
                                    @error('motivo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="text-muted">
                                        Descripción breve del motivo de canalización o situación del estudiante
                                    </small>
                                </div>
                            </div>
                        </div>

                    
                        <div class="alert alert-info mt-3">
                            <h5><i class="fas fa-info-circle"></i> Información Importante</h5>
                            <ul class="mb-0">
                                <li>Los campos marcados con <span class="text-danger">*</span> son obligatorios</li>
                                <li>Si selecciona "Sí" en "Requiere Canalización", el estado se establecerá como "Pendiente"</li>
                                <li>Un estudiante solo puede tener un registro por período académico</li>
                                <li>Para crear una canalización, primero debe guardar este registro</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-save"></i> Guardar Registro
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="reset" class="btn btn-default btn-lg btn-block">
                                    <i class="fas fa-undo"></i> Limpiar Formulario
                                </button>
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
            background: linear-gradient(135deg, #0062cc 0%, #0099ff 100%);
            color: white;
        }
        .text-primary {
            color: #0062cc !important;
        }
        .alert-info {
            border-left: 4px solid #17a2b8;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
         
            $('.select2').select2({
                placeholder: "Seleccione una opción",
                allowClear: true,
                width: '100%'
            });

            
            $('#requiere_canalizacion').change(function() {
                if ($(this).val() === 'si') {
                    $('#estado').val('pendiente');
                    $('#motivo').attr('placeholder', 'Describa el motivo por el cual requiere canalización');
                } else if ($(this).val() === 'no') {
                    $('#estado').val('completado');
                    $('#motivo').attr('placeholder', 'Observaciones generales sobre el estudiante');
                }
            });

            $('#estudiantes_id, #periodo_id').change(function() {
                var estudianteId = $('#estudiantes_id').val();
                var periodoId = $('#periodo_id').val();
                
                if (estudianteId && periodoId) {
                    $.ajax({
                        url: '{{ route("individuales.verificar") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            estudiantes_id: estudianteId,
                            periodo_id: periodoId,
                            individual_id: null 
                        },
                        success: function(response) {
                            if (response.existe) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Registro Existente',
                                    html: 'Este estudiante ya tiene un registro en el período seleccionado.<br>' +
                                          'Estudiante: ' + response.estudiante_nombre + '<br>' +
                                          'Tutor: ' + response.tutor_nombre,
                                    confirmButtonText: 'Entendido'
                                });
                                $('#estudiantes_id').val('').trigger('change');
                            }
                        }
                    });
                }
            });

          
            $('#formIndividual').submit(function(e) {
                let valid = true;
            
                $(this).find('[required]').each(function() {
                    if (!$(this).val().trim()) {
                        valid = false;
                        $(this).addClass('is-invalid');
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

         
            $('#formIndividual').submit(function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: '¿Guardar registro?',
                    text: "¿Está seguro de que desea guardar este registro individual?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar el formulario
                        $(this).unbind('submit').submit();
                    }
                });
            });
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