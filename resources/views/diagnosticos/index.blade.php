@extends('adminlte::page')

@section('title', 'Diagnósticos')

@section('content_header')
    <h1 class="text-primary">Diagnósticos</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @can('create', App\Models\Diagnostico::class)
        <a href="{{ route('diagnosticos.create') }}" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Nuevo Diagnóstico
        </a>
    @endcan

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Grupo</th>
                        <th>Periodo</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diagnosticos as $diagnostico)
                        <tr>
                            <td>{{ $diagnostico->id }}</td>
                            <td>{{ $diagnostico->grupo->nombre_grupo ?? '-' }}</td>
                            <td>{{ $diagnostico->periodo->nombre ?? '-' }}</td>
                            <td><span class="badge bg-info">{{ $diagnostico->estado }}</span></td>
                            <td>{{ $diagnostico->fecha_realizacion }}</td>
                            <td>
                                <a href="{{ route('diagnosticos.show', $diagnostico) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @can('update', $diagnostico)
                                    <form action="{{ route('diagnosticos.responder', $diagnostico) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-edit"></i> Contestar
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
