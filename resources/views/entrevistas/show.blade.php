@extends('adminlte::page')

@section('title', 'Detalles del Formulario')

@section('content_header')
    <h1>Detalles del Formulario de Entrevista</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header bg-info text-white">
        <h4>Información General</h4>
    </div>

    <div class="card-body">

        <p><strong>Carrera:</strong> {{ $form->carrera }}</p>
        <p><strong>Número de Control:</strong> {{ $form->numero_control }}</p>
        <p><strong>Nombre Completo:</strong> {{ $form->nombre_completo }}</p>
        <p><strong>Edad:</strong> {{ $form->edad }}</p>
        <p><strong>Género:</strong> {{ $form->genero }}</p>
        <p><strong>Estado Civil:</strong> {{ $form->estado_civil }}</p>
        <hr>

        <p><strong>Fecha de Nacimiento:</strong> {{ $form->fecha_nacimiento }}</p>
        <p><strong>Lugar de Nacimiento:</strong> {{ $form->lugar_nacimiento }}</p>
        <p><strong>Teléfono Celular:</strong> {{ $form->telefono_celular }}</p>
        <p><strong>Teléfono Hogar:</strong> {{ $form->telefono_hogar }}</p>

    </div>
</div>

<div class="mt-3">
    <a href="{{ route('entrevistas.index') }}" class="btn btn-secondary">Volver</a>
    <a href="{{ route('entrevistas.pdf', $form->id) }}" class="btn btn-danger">Descargar PDF</a>
</div>

@stop
