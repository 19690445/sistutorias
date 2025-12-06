@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Estudiantes (Vista Docente)</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Semestre</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($estudiantes as $est)
            <tr>
                <td>{{ $est->matricula }}</td>
                <td>{{ $est->nombre }} {{ $est->apellidos }}</td>
                <td>{{ $est->carrera }}</td>
                <td>{{ $est->semestre }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
