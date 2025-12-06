@extends('adminlte::page')

@section('title', 'Editar Canalización')

@section('content_header')
<h1>Editar Canalización</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('coordinador'))
        <form action="{{ route('canalizaciones.update', $canalizacion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="individuales_id">Estudiante</label>
                <select name="individuales_id" class="form-control" required>
                    @foreach($individuales->where('requiere_canalizacion', 'si') as $ind)
                        <option value="{{ $ind->id }}" @if($canalizacion->individuales_id == $ind->id) selected @endif>
                            {{ $ind->estudiante->nombre ?? '' }} {{ $ind->estudiante->apellidos ?? '' }}
                        </option>
                    @endforeach
                </select>
                @error('individuales_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="tipo_atencion">Tipo de Atención</label>
                <select name="tipo_atencion" class="form-control" required>
                    @foreach([
                        'servicios psicologicos',
                        'servicios de salud',
                        'adicciones',
                        'beca manutencion',
                        'beca transporte',
                        'beca alimentacion',
                        'asesoria academica',
                        'asesoria procesos academicos/administrativos',
                        'aptitudes sobresalientes'
                    ] as $tipo)
                        <option value="{{ $tipo }}" {{ $canalizacion->tipo_atencion == $tipo ? 'selected' : '' }}>
                            {{ ucfirst($tipo) }}
                        </option>
                    @endforeach
                </select>
                @error('tipo_atencion')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="causa_problema">Causa del Problema</label>
                <textarea name="causa_problema" class="form-control" rows="3">{{ $canalizacion->causa_problema }}</textarea>
            </div>

            <div class="form-group">
                <label for="acciones_sugeridas">Acciones Sugeridas</label>
                <textarea name="acciones_sugeridas" class="form-control" rows="3">{{ $canalizacion->acciones_sugeridas }}</textarea>
            </div>

            <div class="form-group">
                <label for="primera_sesion_propuesta">Primera Sesión Propuesta</label>
                <input type="date" name="primera_sesion_propuesta" class="form-control" value="{{ $canalizacion->primera_sesion_propuesta }}">
            </div>

            <div class="form-group">
                <label for="primera_sesion_real">Primera Sesión Real</label>
                <input type="date" name="primera_sesion_real" class="form-control" value="{{ $canalizacion->primera_sesion_real }}">
            </div>

            <div class="form-group">
                <label for="seguimiento_tutor">Seguimiento Tutor</label>
                <textarea name="seguimiento_tutor" class="form-control" rows="3">{{ $canalizacion->seguimiento_tutor }}</textarea>
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" class="form-control">
                    @foreach(['pendiente','en_proceso','finalizado'] as $estado)
                        <option value="{{ $estado }}" {{ $canalizacion->estado == $estado ? 'selected' : '' }}>
                            {{ ucfirst($estado) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="3">{{ $canalizacion->observaciones }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Canalización</button>
        </form>
        @else
            <p class="text-danger">No tienes permisos para editar esta canalización.</p>
        @endif
    </div>
</div>
@stop
