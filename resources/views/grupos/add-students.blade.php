@extends('adminlte::page')

@section('title', 'Agregar Estudiantes')

@section('content_header')
    <h1>Agregar Estudiantes a: {{ $grupo->nombre_grupo }}</h1>
@stop

@section('content')
    <form action="{{ route('grupos.storeStudents', $grupo->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Estudiantes Disponibles</label>
            <select name="estudiantes[]" class="form-control" multiple required>
                @foreach($estudiantes as $estudiante)
                    <option value="{{ $estudiante->id }}">{{ $estudiante->nombre }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Mantén presionada la tecla Ctrl para seleccionar varios estudiantes.</small>
        </div>

        <button type="submit" class="btn btn-success mt-2">Agregar Estudiantes</button>
    </form>
@stop
