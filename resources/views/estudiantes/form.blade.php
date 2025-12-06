<div class="row">
    <div class="col-md-6 mb-3">
        <label>Matrícula</label>
        <input type="text" name="matricula" class="form-control" value="{{ old('matricula', $estudiante->matricula ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Correo Institucional</label>
        <input type="email" name="correo_institucional" class="form-control" value="{{ old('correo_institucional', $estudiante->correo_institucional ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $estudiante->nombre ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Apellidos</label>
        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $estudiante->apellidos ?? '') }}" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>CURP</label>
        <input type="text" name="curp" class="form-control" value="{{ old('curp', $estudiante->curp ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Fecha Nacimiento</label>
        <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Género</label>
        <select name="genero" class="form-control">
            <option value="" disabled selected>Seleccione</option>
            <option value="masculino" {{ old('genero', $estudiante->genero ?? '')=='masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="femenino" {{ old('genero', $estudiante->genero ?? '')=='femenino' ? 'selected' : '' }}>Femenino</option>
            <option value="otro" {{ old('genero', $estudiante->genero ?? '')=='otro' ? 'selected' : '' }}>Otro</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label>Teléfono Celular</label>
        <input type="text" name="telefono_celular" class="form-control" value="{{ old('telefono_celular', $estudiante->telefono_celular ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Carrera</label>
        <input type="text" name="carrera" class="form-control" value="{{ old('carrera', $estudiante->carrera ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Semestre</label>
        <input type="number" name="semestre" class="form-control" value="{{ old('semestre', $estudiante->semestre ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Estado</label>
        <select name="estado" class="form-control">
            @foreach(['activo','baja_temporal','baja_definitiva','egresado'] as $estado)
                <option value="{{ $estado }}" {{ old('estado', $estudiante->estado ?? '') == $estado ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_',' ', $estado)) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label>Fecha Ingreso</label>
        <input type="date" name="fecha_ingreso" class="form-control" value="{{ old('fecha_ingreso', $estudiante->fecha_ingreso ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Fecha Egreso</label>
        <input type="date" name="fecha_egreso" class="form-control" value="{{ old('fecha_egreso', $estudiante->fecha_egreso ?? '') }}">
    </div>

    <div class="col-md-12 mb-3">
        <label>Domicilio</label>
        <textarea name="domicilio" class="form-control" rows="2">{{ old('domicilio', $estudiante->domicilio ?? '') }}</textarea>
    </div>
</div>
