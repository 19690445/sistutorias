@extends('adminlte::page')

@section('title', 'Editar PAT')

@section('content')
<div class="container">
    <h1>Editar PAT</h1>
    <form action="{{ route('pats.update', $pat->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="actividad" class="form-label">Actividad</label>
            <input type="text" name="actividad" id="actividad" class="form-control" value="{{ $pat->actividad}}" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ $pat->descripcion }}">
        </div>
        <div class="mb-3">
            <label for="tutores_id" class="form-label">Tutor</label>
            <select name="tutores_id" id="tutores_id" class="form-control" required>
                @foreach($tutores as $tutor)
                    <option value="{{ $tutor->id }}" @if($tutor->id == $pat->tutores_id) selected @endif>
                        {{ $tutor->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="grupos_id" class="form-label">Grupo</label>
            <select name="grupos_id" id="grupos_id" class="form-control" required>
                @foreach($grupos as $grupo)
                    <option value="{{ $grupo->id }}" @if($grupo->id == $pat->grupos_id) selected @endif>
                        {{ $grupo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('pats.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@stop
