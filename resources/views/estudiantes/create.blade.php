@extends('adminlte::page')

@section('title', 'Crear Estudiante')

@section('content_header')
    <h1>Crear Estudiante</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('estudiantes.store') }}" method="POST">
            @csrf
            @include('estudiantes.form')

            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </form>
    </div>
</div>
@stop
