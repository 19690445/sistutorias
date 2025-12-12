@csrf

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nombre_periodo" class="font-weight-bold">
                Nombre del Periodo <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                </div>
                <input type="text" 
                       name="nombre_periodo" 
                       id="nombre_periodo"
                       class="form-control @error('nombre_periodo') is-invalid @enderror"
                       value="{{ old('nombre_periodo', $periodo->nombre_periodo ?? '') }}" 
                       placeholder="Ej: Semestre 2024-I"
                       required
                       autofocus>
                @error('nombre_periodo')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>
            <small class="form-text text-muted">
                Ej: Semestre 2024-I, Cuatrimestre Enero-Abril 2024
            </small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="año_periodo" class="font-weight-bold">
                Año del Periodo <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-calendar"></i>
                    </span>
                </div>
                <input type="number" 
                       name="año_periodo" 
                       id="año_periodo"
                       class="form-control @error('año_periodo') is-invalid @enderror"
                       value="{{ old('año_periodo', $periodo->año_periodo ?? date('Y')) }}" 
                       min="2000" 
                       max="2100"
                       required>
                @error('año_periodo')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>
            <small class="form-text text-muted">
                Año del periodo académico
            </small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="fecha_inicio" class="font-weight-bold">
                Fecha de Inicio <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-play-circle"></i>
                    </span>
                </div>
                <input type="date" 
                       name="fecha_inicio" 
                       id="fecha_inicio"
                       class="form-control @error('fecha_inicio') is-invalid @enderror"
                       value="{{ old('fecha_inicio', $periodo->fecha_inicio ?? '') }}" 
                       required
                       onchange="validarFechas()">
                @error('fecha_inicio')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>
            <small class="form-text text-muted">
                Fecha en que inicia el periodo
            </small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="fecha_fin" class="font-weight-bold">
                Fecha de Fin
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-stop-circle"></i>
                    </span>
                </div>
                <input type="date" 
                       name="fecha_fin" 
                       id="fecha_fin"
                       class="form-control @error('fecha_fin') is-invalid @enderror"
                       value="{{ old('fecha_fin', $periodo->fecha_fin ?? '') }}"
                       onchange="validarFechas()">
                @error('fecha_fin')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>
            <small class="form-text text-muted">
                Fecha en que finaliza el periodo (opcional)
            </small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="estado" class="font-weight-bold">
                Estado <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-toggle-on"></i>
                    </span>
                </div>
                <select name="estado" 
                        id="estado"
                        class="form-control @error('estado') is-invalid @enderror" 
                        required>
                    <option value="">Seleccione un estado</option>
                    <option value="activo" 
                            {{ (old('estado', $periodo->estado ?? '') == 'activo') ? 'selected' : '' }}
                            data-badge="badge-success">
                        Activo
                    </option>
                    <option value="inactivo" 
                            {{ (old('estado', $periodo->estado ?? '') == 'inactivo') ? 'selected' : '' }}
                            data-badge="badge-secondary">
                        Inactivo
                    </option>
                    <option value="finalizado" 
                            {{ (old('estado', $periodo->estado ?? '') == 'finalizado') ? 'selected' : '' }}
                            data-badge="badge-info">
                        Finalizado
                    </option>
                </select>
                @error('estado')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>
            <small class="form-text text-muted">
                Estado actual del periodo académico
            </small>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label class="font-weight-bold">Indicador de Estado</label>
            <div class="alert alert-light border" id="estado-indicator">
                @php
                    $estadoActual = old('estado', $periodo->estado ?? '');
                    $badgeClass = match($estadoActual) {
                        'activo' => 'badge-success',
                        'inactivo' => 'badge-secondary',
                        'finalizado' => 'badge-info',
                        default => 'badge-light'
                    };
                    $estadoTexto = match($estadoActual) {
                        'activo' => 'Activo - El periodo está en curso',
                        'inactivo' => 'Inactivo - El periodo no está activo',
                        'finalizado' => 'Finalizado - El periodo ha concluido',
                        default => 'Seleccione un estado'
                    };
                @endphp
                <span class="badge {{ $badgeClass }} badge-pill p-2">
                    <i class="fas fa-circle mr-1"></i> {{ ucfirst($estadoActual ?: 'Sin estado') }}
                </span>
                <small class="d-block mt-1 text-muted">{{ $estadoTexto }}</small>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="descripcion" class="font-weight-bold">
        Descripción
    </label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fas fa-align-left"></i>
            </span>
        </div>
        <textarea name="descripcion" 
                  id="descripcion"
                  class="form-control @error('descripcion') is-invalid @enderror"
                  rows="4"
                  placeholder="Descripción del periodo académico...">{{ old('descripcion', $periodo->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">
                <i class="fas fa-exclamation-circle"></i> {{ $message }}
            </div>
        @enderror
    </div>
    <div class="d-flex justify-content-between mt-1">
        <small class="form-text text-muted">
            Información adicional sobre el periodo académico
        </small>
        <small class="form-text text-muted">
            <span id="contador-descripcion">0</span>/500 caracteres
        </small>
    </div>
</div>

<div class="form-group">
    <div class="form-check">
        <input type="checkbox" 
               class="form-check-input" 
               id="confirmar_datos"
               required>
        <label class="form-check-label" for="confirmar_datos">
            Confirmo que la información proporcionada es correcta
        </label>
    </div>
</div>

<hr>

<div class="form-group text-right">
    <div class="btn-group" role="group">
        <a href="{{ route('periodos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-times mr-1"></i> Cancelar
        </a>
        <button type="reset" class="btn btn-outline-warning">
            <i class="fas fa-redo mr-1"></i> Limpiar
        </button>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save mr-1"></i> Guardar Periodo
        </button>
    </div>
</div>

@push('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }
    label {
        margin-bottom: 0.5rem;
    }
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }
    .form-control:focus + .input-group-text {
        border-color: #80bdff;
        background-color: #e9ecef;
    }
    .badge-success {
        background-color: #28a745;
    }
    .badge-secondary {
        background-color: #6c757d;
    }
    .badge-info {
        background-color: #17a2b8;
    }
    .badge-light {
        background-color: #f8f9fa;
        color: #212529;
    }
    #estado-indicator {
        min-height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
      
        const estadoSelect = document.getElementById('estado');
        const estadoIndicator = document.getElementById('estado-indicator');
        
        estadoSelect.addEventListener('change', function() {
            const estado = this.value;
            let badgeClass = 'badge-light';
            let texto = 'Seleccione un estado';
            let descripcion = '';
            
            switch(estado) {
                case 'activo':
                    badgeClass = 'badge-success';
                    texto = 'Activo';
                    descripcion = 'El periodo está en curso';
                    break;
                case 'inactivo':
                    badgeClass = 'badge-secondary';
                    texto = 'Inactivo';
                    descripcion = 'El periodo no está activo';
                    break;
                case 'finalizado':
                    badgeClass = 'badge-info';
                    texto = 'Finalizado';
                    descripcion = 'El periodo ha concluido';
                    break;
            }
            
            estadoIndicator.innerHTML = `
                <span class="badge ${badgeClass} badge-pill p-2">
                    <i class="fas fa-circle mr-1"></i> ${texto}
                </span>
                <small class="d-block mt-1 text-muted">${descripcion}</small>
            `;
        });
        

        const descripcionTextarea = document.getElementById('descripcion');
        const contadorDescripcion = document.getElementById('contador-descripcion');
        
        descripcionTextarea.addEventListener('input', function() {
            const longitud = this.value.length;
            contadorDescripcion.textContent = longitud;
            
            if (longitud > 500) {
                contadorDescripcion.classList.add('text-danger');
                this.classList.add('is-invalid');
            } else {
                contadorDescripcion.classList.remove('text-danger');
                this.classList.remove('is-invalid');
            }
        });
        
        contadorDescripcion.textContent = descripcionTextarea.value.length;
        
      
        window.validarFechas = function() {
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            
            if (fechaInicio.value && fechaFin.value) {
                const inicio = new Date(fechaInicio.value);
                const fin = new Date(fechaFin.value);
                
                if (fin < inicio) {
                    fechaFin.classList.add('is-invalid');
                    fechaFin.nextElementSibling.innerHTML = 
                        '<i class="fas fa-exclamation-circle"></i> La fecha de fin no puede ser anterior a la fecha de inicio';
                    return false;
                } else {
                    fechaFin.classList.remove('is-invalid');
                    fechaFin.nextElementSibling.innerHTML = '';
                }
            }
            return true;
        };
        
        // Validación antes de enviar
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!validarFechas()) {
                e.preventDefault();
                alert('Por favor, corrija las fechas antes de enviar el formulario.');
                return false;
            }
            
            const descripcion = descripcionTextarea.value;
            if (descripcion.length > 500) {
                e.preventDefault();
                alert('La descripción no puede exceder los 500 caracteres.');
                descripcionTextarea.focus();
                return false;
            }
            
            const confirmarCheck = document.getElementById('confirmar_datos');
            if (!confirmarCheck.checked) {
                e.preventDefault();
                alert('Debe confirmar que la información es correcta.');
                confirmarCheck.focus();
                return false;
            }
            
            return true;
        });
    });
</script>
@endpush