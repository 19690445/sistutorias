@extends('adminlte::page')

@section('title', 'Diagnósticos')

@section('content_header')
    <h1>Diagnósticos</h1>
    @can('create', App\Models\Diagnostico::class)
        <a href="{{ route('diagnosticos.create') }}" class="btn btn-primary">Nuevo Diagnóstico</a>
    @endcan
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($diagnosticos->isEmpty())
        <div class="alert alert-info">No hay diagnósticos disponibles.</div>
    @else
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Grupo</th>
                            <th>Periodo</th>
                            <th>Problemarios</th>
                            <th>Objetivos</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diagnosticos as $diagnostico)
                            <tr>
                                <td>{{ $diagnostico->id }}</td>
                                <td>{{ $diagnostico->grupo->nombre ?? 'Sin grupo' }}</td>
                                <td>{{ $diagnostico->periodo->nombre ?? 'Sin periodo' }}</td>
                                <td>{{ Str::limit($diagnostico->problemarios, 50) }}</td>
                                <td>{{ Str::limit($diagnostico->objetivos, 50) }}</td>
                                <td>{{ optional($diagnostico->fecha_realizacion)->format('d/m/Y') ?? '-' }}</td>
                                <td>{{ $diagnostico->estado ?? 'Pendiente' }}</td>
                                <td>
                                    <a href="{{ route('diagnosticos.show', $diagnostico->id) }}" class="btn btn-sm btn-info">Ver</a>
                                    
                                    @if(in_array(Auth::user()->role->nombre, ['admin', 'coordinador', 'docente']))
                                        <form action="{{ route('diagnosticos.responder', $diagnostico->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Responder</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@stop
