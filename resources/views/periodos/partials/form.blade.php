@csrf
<div class="form-group">
    <label>Nombre del Periodo</label>
    <input type="text" name="nombre_periodo" class="form-control" value="{{ old('nombre_periodo', $periodo->nombre_periodo ?? '') }}" required>
</div>

<div class="form-group">
    <label>Año del Periodo</label>
    <input type="number" name="año_periodo" class="form-control" value="{{ old('año_periodo', $periodo->año_periodo ?? '') }}" required>
</div>

<div class="form-group">
    <label>Fecha de Inicio</label>
    <input type="date" name="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $periodo->fecha_inicio ?? '') }}" required>
</div>

<div class="form-group">
    <label>Fecha de Fin</label>
    <input type="date" name="fecha_fin" class="form-control" value="{{ old('fecha_fin', $periodo->fecha_fin ?? '') }}">
</div>

<div class="form-group">
    <label>Estado</label>
    <select name="estado" class="form-control" required>
        <option value="activo" {{ (old('estado', $periodo->estado ?? '')=='activo')?'selected':'' }}>Activo</option>
        <option value="inactivo" {{ (old('estado', $periodo->estado ?? '')=='inactivo')?'selected':'' }}>Inactivo</option>
        <option value="finalizado" {{ (old('estado', $periodo->estado ?? '')=='finalizado')?'selected':'' }}>Finalizado</option>
    </select>
</div>

<div class="form-group">
    <label>Descripción</label>
    <textarea name="descripcion" class="form-control">{{ old('descripcion', $periodo->descripcion ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-success">Guardar</button>
<a href="{{ route('periodos.index') }}" class="btn btn-secondary">Cancelar</a>
