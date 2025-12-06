@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mi Información</h1>

    <form action="{{ route('estudiantes.perfil.update', $estudiante->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('estudiantes.form')

        <button class="btn btn-success">Actualizar Mis Datos</button>
    </form>
</div>
@endsection
