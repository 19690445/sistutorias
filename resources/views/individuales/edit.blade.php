@extends('adminlte::page')

@section('title', 'Editar Registro Individual')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">
            <i class="fas fa-edit"></i>
            Editar Registro Individual
        </h1>
        <a href="{{ route('individuales.show', $individuale) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a Detalles
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit"></i>
                        Editar Registro Individual
                    </h3>
                </div>

                <form action="{{ route('individuales.update', $individuale) }}" method="POST" id="formIndividual">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                    
                        <div class="row border-bottom mb-3 pb-3">
                            <div class="col-12">
                                <h5 class="text-warning">
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
                                                {{ $individuale->periodo_id == $periodo->id ? 'selected' : '' }}>
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
                                                {{ $individuale->tutores_id == $tutor->id ? 'selected' : '' }}>
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
                                                {{ $individuale->estudiantes_id == $estudiante->id ? 'selected' : '' }}>
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
                                    @enderror>
                                </div>
                            </div>
                        </div>

                
                        <div class="row border-bottom mb-3 pb-3">
                            <div class="col-12">
                                <h5 class="text-warning">
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
                                        <option value="si" {{ $individuale->requiere_canalizacion == 'si' ? 'selected' : '' }}>Sí, requiere canalización</option>
                                        <option value="no" {{ $individuale->requiere_canalizacion == 'no' ? 'selected' : '' }}>No, no requiere canalización</option>
                                    </select>
                                    @error('requiere_canalizacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror>
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
                                        <option value="pendiente" {{ $individuale->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="en_proceso" {{ $individuale->estado == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                        <option value="completado" {{ $individuale->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror>
                                </div>
                            </div>
                        </div>

                     
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="motivo">
                                        <i class="fas fa-comment-dots"></i> Motivo u Observaciones
                                    </label>
                                    <textarea name="motivo" id="motivo" 
                                              class="form-control @error('motivo') is-invalid @enderror"
                                              rows="3" placeholder="Describa el motivo por el cual requiere o no canalización">{{ $individuale->motivo }}</textarea>
                                    @error('motivo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror>
                                    <small class="text-muted">
                                        Descripción breve del motivo de canalización o situación del estudiante
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <h5><i class="fas fa-info-circle"></i> Información del Registro</h5>
                            <ul class="mb-0">
                                <li><strong>ID:</strong> {{ $individuale->id }}</li>
                                <li><strong>Creado:</strong> {{ $individuale->created_at->format('d/m/Y H:i') }}</li>
                                <li><strong>Última actualización:</strong> {{ $individuale->updated_at->format('d/m/Y H:i') }}</li>
                                @if($individuale->canalizaciones->count() > 0)
                                    <li><strong>Canalizaciones asociadas:</strong> {{ $individuale->canalizaciones->count() }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning btn-lg btn-block">
                                    <i class="fas fa-save"></i> Actualizar Registro
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('individuales.show', $individuale) }}" class="btn btn-default btn-lg btn-block">
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
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: #212529;
        }
        .text-warning {
            color: #ffc107 !important;
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
                    title: '¿Actualizar registro?',
                    text: "¿Está seguro de que desea actualizar este registro individual?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, actualizar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        
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