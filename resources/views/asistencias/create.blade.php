@extends('adminlte::page')

@section('title', 'Crear Asistencia')

@section('content_header')
<h1>Crear Asistencia</h1>
@stop

@section('content')
<form action="{{ route('asistencias.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="grupo_id">Grupo</label>
        <select name="grupo_id" id="grupo_id" class="form-control" required>
            <option value="">Seleccione un grupo</option>
            @foreach($grupos as $grupo)
                <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="estudiantes">Estudiantes</label>
        <div id="estudiantes">
            <!-- se carga estudiantes del grupo seleccionado -->
        </div>
    </div>

    <div class="form-group">
        <label for="sesion">Sesión</label>
        <input type="number" name="sesion" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@stop

@section('js')
<script>
    document.getElementById('grupo_id').addEventListener('change', function() {
        let grupoId = this.value;
        let estudiantesDiv = document.getElementById('estudiantes');

        if(grupoId) {
            fetch(`/sistutorias/public/asistencias/estudiantes/${grupoId}`)
                .then(response => response.json())
                .then(data => {
                    estudiantesDiv.innerHTML = '';
                    data.forEach(estudiante => {
                        let checkbox = document.createElement('div');
                        checkbox.innerHTML = `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="estudiantes[]" value="${estudiante.id}" id="estudiante${estudiante.id}" checked>
                                <label class="form-check-label" for="estudiante${estudiante.id}">${estudiante.nombre} ${estudiante.apellidos}</label>
                            </div>
                        `;
                        estudiantesDiv.appendChild(checkbox);
                    });
                });
        } else {
            estudiantesDiv.innerHTML = '';
        }
    });
</script>
@stop
