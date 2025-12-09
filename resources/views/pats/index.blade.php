@extends('adminlte::page')

@section('title', 'Programas de Acción Tutorial')

@section('content_header')
    <h1>Programas de Acción Tutorial (PAT)</h1>
    <p>Gestione las actividades tutoriales por grupo</p>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
          
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Filtrar PATs</h3>
                    <div class="card-tools">
                        <a href="{{ route('pats.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Nuevo PAT
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('pats.index') }}" class="form-inline">
                        <div class="form-group mr-3">
                            <label for="grupo_id" class="mr-2">Grupo:</label>
                            <select name="grupo_id" id="grupo_id" class="form-control select2" style="width: 200px;"
                                    onchange="this.form.submit()">
                                <option value="">-- Todos los grupos --</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ request('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->nombre_grupo ?? $grupo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mr-3">
                            <label for="periodo_id" class="mr-2">Periodo:</label>
                            <select name="periodo_id" id="periodo_id" class="form-control select2" style="width: 200px;"
                                    onchange="this.form.submit()">
                                <option value="">-- Todos los periodos --</option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ request('periodo_id') == $periodo->id ? 'selected' : '' }}>
                                        {{ $periodo->nombre_periodo ?? $periodo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <a href="{{ route('pats.index') }}" class="btn btn-default ml-2">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @if($pats->count() > 0)
                
                <div class="mb-3">
                    <a href="{{ route('pats.create', [
                        'grupo_id' => request('grupo_id'),
                        'periodo_id' => request('periodo_id')
                    ]) }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Crear Nuevo PAT
                    </a>
                    <span class="ml-2 text-muted">
                        <i class="fas fa-info-circle"></i> Mostrando {{ $pats->count() }} PAT(s)
                    </span>
                </div>

                @if(request('grupo_id') && $grupoSeleccionado = $grupos->firstWhere('id', request('grupo_id')))
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users"></i> Grupo: {{ $grupoSeleccionado->nombre_grupo ?? $grupoSeleccionado->nombre }}
                                @if(request('periodo_id') && $periodoSeleccionado = $periodos->firstWhere('id', request('periodo_id')))
                                    <span class="ml-2">
                                        <i class="fas fa-calendar"></i> Periodo: {{ $periodoSeleccionado->nombre_periodo ?? $periodoSeleccionado->nombre }}
                                    </span>
                                @endif
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($pats->groupBy('tutor.nombre') as $tutorNombre => $patsTutor)
                                    <div class="col-md-4">
                                        <div class="card card-outline card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-user-tie"></i> Tutor: {{ $tutorNombre }}
                                                </h3>
                                                <span class="badge badge-info">{{ $patsTutor->count() }} actividades</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Actividad</th>
                                                                <th>Estado</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($patsTutor as $pat)
                                                            <tr>
                                                                <td>
                                                                    <small>{{ $pat->actividad }}</small>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-{{ $pat->estado == 'completado' ? 'success' : ($pat->estado == 'en_proceso' ? 'warning' : 'secondary') }}">
                                                                        {{ ucfirst(str_replace('_', ' ', $pat->estado)) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('pats.edit', $pat->id) }}" class="btn btn-xs btn-info" title="Editar">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <form action="{{ route('pats.destroy', $pat->id) }}" method="POST" style="display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-xs btn-danger" 
                                                                                onclick="return confirm('¿Eliminar esta actividad?')" title="Eliminar">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                 
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Grupo</th>
                                            <th>Tutor</th>
                                            <th>Periodo</th>
                                            <th>Actividad</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pats as $pat)
                                        <tr>
                                            <td>{{ $pat->id }}</td>
                                            <td>
                                                <span class="badge badge-primary">
                                                    {{ $pat->grupo->nombre_grupo ?? $pat->grupo->nombre ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>{{ $pat->tutor->nombre ?? 'N/A' }}</td>
                                            <td>{{ $pat->periodo->nombre_periodo ?? $pat->periodo->nombre ?? 'N/A' }}</td>
                                            <td>{{ Str::limit($pat->actividad, 50) }}</td>
                                            <td>
                                                <span class="badge badge-{{ $pat->estado == 'completado' ? 'success' : ($pat->estado == 'en_proceso' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $pat->estado)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('pats.edit', $pat->id) }}" class="btn btn-xs btn-info" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('pats.destroy', $pat->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger" 
                                                            onclick="return confirm('¿Eliminar esta actividad?')" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @else
             
                <div class="card">
                    <div class="card-body text-center">
                        <div class="py-5">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h4>No se encontraron PATs</h4>
                            <p class="text-muted">
                                @if(request('grupo_id') || request('periodo_id'))
                                    No hay PATs registrados con los filtros aplicados.
                                @else
                                    No hay PATs registrados en el sistema.
                                @endif
                            </p>
                            <a href="{{ route('pats.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Crear Primer PAT
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
        }
        .card-outline {
            border-top: 3px solid #007bff;
        }
        .table-sm td, .table-sm th {
            padding: 0.3rem;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
           
            $('.select2').select2({
                theme: 'bootstrap4'
            });
          
            $('[title]').tooltip();
        });
    </script>
@stop