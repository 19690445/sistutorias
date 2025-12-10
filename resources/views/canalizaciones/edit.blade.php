@extends('adminlte::page')

@section('title', 'Editar Canalización')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">
            <i class="fas fa-edit"></i>
            Editar Canalización
        </h1>
        <a href="{{ route('canalizaciones.show', $canalizacione) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Editar Canalización
                    </h3>
                </div>

                <form action="{{ route('canalizaciones.update', $canalizacione) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                     
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Estudiante:</label>
                                    <input type="text" class="form-control bg-light" readonly
                                           value="{{ $canalizacione->individual->estudiante->nombre ?? 'N/A' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tutor asignado:</label>
                                    <input type="text" class="form-control bg-light" readonly
                                           value="{{ $canalizacione->individual->tutor->nombre ?? 'N/A' }}">
                                </div>
                            </div>
                        </div>

                     
                        <input type="hidden" name="individuales_id" value="{{ $canalizacione->individuales_id }}">

                     
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
                                        <option value="Asesoria Individual" {{ old('tipo_atencion', $canalizacione->tipo_atencion) == 'Asesoria Individual' ? 'selected' : '' }}>Asesoría Individual</option>
                                        <option value="Salud y hábitos alimenticios" {{ old('tipo_atencion', $canalizacione->tipo_atencion) == 'Salud y hábitos alimenticios' ? 'selected' : '' }}>Salud y hábitos alimenticios</option>
                                        <option value="Consumo de substancias tóxicas" {{ old('tipo_atencion', $canalizacione->tipo_atencion) == 'Consumo de substancias tóxicas' ? 'selected' : '' }}>Consumo de sustancias tóxicas</option>
                                        <option value="Problemas emocionales" {{ old('tipo_atencion', $canalizacione->tipo_atencion) == 'Problemas emocionales' ? 'selected' : '' }}>Problemas emocionales</option>
                                        <option value="Problemas familiares" {{ old('tipo_atencion', $canalizacione->tipo_atencion) == 'Problemas familiares' ? 'selected' : '' }}>Problemas familiares</option>
                                        <option value="Problemas académicos" {{ old('tipo_atencion', $canalizacione->tipo_atencion) == 'Problemas académicos' ? 'selected' : '' }}>Problemas académicos</option>
                                        <option value="Manejo de sexualidad y relaciones de pareja" {{ old('tipo_atencion', $canalizacione->tipo_atencion) == 'Manejo de sexualidad y relaciones de pareja' ? 'selected' : '' }}>Manejo de sexualidad y relaciones de pareja</option>
                                        <option value="Otros (especifique)" {{ old('tipo_atencion', $canalizacione->tipo_atencion) == 'Otros (especifique)' ? 'selected' : '' }}>Otros (especifique)</option>
                                    </select>
                                    @error('tipo_atencion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    
                        <div class="row mb-3" id="otrosContainer" style="{{ old('tipo_atencion', $canalizacione->tipo_atencion) == 'Otros (especifique)' ? '' : 'display: none;' }}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="causa_problema">
                                        <i class="fas fa-edit"></i> Especifique el tipo de atención
                                    </label>
                                    <textarea name="causa_problema" id="causa_problema" 
                                              class="form-control @error('causa_problema') is-invalid @enderror"
                                              rows="2" placeholder="Describa específicamente el tipo de atención requerida">{{ old('causa_problema', $canalizacione->causa_problema) }}</textarea>
                                    @error('causa_problema')
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
                                              rows="3">{{ old('causa_problema_general', $canalizacione->causa_problema_general) }}</textarea>
                                    @error('causa_problema_general')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror>
                                </div>
                            </div>
                        </div>

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
                                              rows="4" required>{{ old('acciones_sugeridas', $canalizacione->acciones_sugeridas) }}</textarea>
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
                                           value="{{ old('primera_sesion_propuesta', $canalizacione->primera_sesion_propuesta) }}">
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
                                           value="{{ old('primera_sesion_real', $canalizacione->primera_sesion_real) }}">
                                    @error('primera_sesion_real')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror>
                                </div>
                            </div>
                        </div>

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
                                              rows="3">{{ old('seguimiento_tutor', $canalizacione->seguimiento_tutor) }}</textarea>
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
                                        <option value="pendiente" {{ old('estado', $canalizacione->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="en_proceso" {{ old('estado', $canalizacione->estado) == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                        <option value="finalizado" {{ old('estado', $canalizacione->estado) == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
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
                                                  rows="3">{{ old('observaciones', $canalizacione->observaciones) }}</textarea>
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
                                <button type="submit" class="btn btn-warning btn-lg btn-block">
                                    <i class="fas fa-save"></i> Actualizar
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('canalizaciones.show', $canalizacione) }}" class="btn btn-default btn-lg btn-block">
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
    <style>
        .border-bottom {
            border-bottom: 2px solid #dee2e6 !important;
        }
        .card-header {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            color: #212529;
        }
        .text-primary {
            color: #764ba2 !important;
        }
        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
           
            $('#tipo_atencion').change(function() {
                if ($(this).val() === 'Otros (especifique)') {
                    $('#otrosContainer').show();
                    $('#causa_problema').attr('required', true);
                } else {
                    $('#otrosContainer').hide();
                    $('#causa_problema').removeAttr('required');
                }
            });
            
            
            $('#tipo_atencion').trigger('change');
        });
    </script>
@stop