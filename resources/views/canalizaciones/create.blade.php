@extends('adminlte::page')

@section('title', 'Crear Canalización')

@section('content_header')
<h1>Crear Canalización</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('canalizaciones.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="individuales_id">Estudiante</label>
                <select name="individuales_id" class="form-control" required>
                    <option value="">-- Seleccione un estudiante --</option>
                    @foreach($individuales as $ind)
                        <option value="{{ $ind->id }}">
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
                    <option value="">-- Seleccione --</option>
                    <option value="servicios psicologicos">Servicios Psicológicos</option>
                    <option value="servicios de salud">Servicios de Salud</option>
                    <option value="adicciones">Adicciones</option>
                    <option value="beca manutencion">Beca Mantención</option>
                    <option value="beca transporte">Beca Transporte</option>
                    <option value="beca alimentacion">Beca Alimentación</option>
                    <option value="asesoria academica">Asesoría Académica</option>
                    <option value="asesoria procesos academicos/administrativos">Asesoría Procesos Académicos/Administrativos</option>
                    <option value="aptitudes sobresalientes">Aptitudes Sobresalientes</option>
                </select>
                @error('tipo_atencion')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="causa_problema">Causa del Problema</label>
                <textarea name="causa_problema" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="acciones_sugeridas">Acciones Sugeridas</label>
                <textarea name="acciones_sugeridas" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="primera_sesion_propuesta">Primera Sesión Propuesta</label>
                <input type="date" name="primera_sesion_propuesta" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Guardar Canalización</button>
        </form>
    </div>
</div>
@stop
