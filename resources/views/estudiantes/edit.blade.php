@extends('adminlte::page')

@section('title', 'Editar Estudiante')

@section('content_header')
    <h1>Editar Estudiante</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ route('estudiantes.update', $estudiante->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('estudiantes.form')

            <button class="btn btn-success">
                <i class="fas fa-sync"></i> Actualizar
            </button>
        </form>

    </div>
</div>
@stop
 