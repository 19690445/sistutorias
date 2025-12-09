<!-- @extends('adminlte::page')

@section('title', 'Revisar Grupos')

@section('content_header')
    <h1>Grupos Importados</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Clave</th>
                        <th>Nombre</th>
                        <th>Tutor</th>
                        <th>Periodo</th>
                        <th>Carrera</th>
                        <th>Semestre</th>
                        <th>Aula</th>
                        <th>Horario</th>
                        <th>Modalidad</th>
                        <th>Turno</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupos as $grupo)
                        <tr>
                            <td>{{ $grupo->id }}</td>
                            <td>{{ $grupo->clave_grupo }}</td>
                            <td>{{ $grupo->nombre_grupo }}</td>
                            <td>{{ $grupo->tutor->nombre ?? 'Sin tutor' }}</td>
                            <td>{{ $grupo->periodo->nombre_periodo ?? 'Sin periodo' }}</td>
                            <td>{{ $grupo->carrera }}</td>
                            <td>{{ $grupo->semestre }}</td>
                            <td>{{ $grupo->aula }}</td>
                            <td>{{ $grupo->horario }}</td>
                            <td>{{ $grupo->modalidad }}</td>
                            <td>{{ $grupo->turno }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop -->
