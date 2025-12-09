@extends('adminlte::page')

@section('title', 'Dashboard PAT')

@section('content_header')
    <h1>Dashboard de Programas de Acción Tutorial</h1>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="float-right">
                <a href="{{ route('pats.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nuevo PAT
                </a>
                <a href="{{ route('pats.index') }}" class="btn btn-primary">
                    <i class="fas fa-list"></i> Ver Todos los PATs
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- filtro -->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('pats.dashboard') }}" class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="grupo_id">Filtrar por Grupo:</label>
                                <select name="grupo_id" id="grupo_id" class="form-control select2" onchange="this.form.submit()">
                                    <option value="">-- Todos los grupos --</option>
                                    @foreach($grupos as $grupo)
                                        <option value="{{ $grupo->id }}" {{ request('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                            {{ $grupo->nombre_grupo ?? $grupo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="periodo_id">Filtrar por Periodo:</label>
                                <select name="periodo_id" id="periodo_id" class="form-control select2" onchange="this.form.submit()">
                                    <option value="">-- Todos los periodos --</option>
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id }}" {{ request('periodo_id') == $periodo->id ? 'selected' : '' }}>
                                            {{ $periodo->nombre_periodo ?? $periodo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                                <a href="{{ route('pats.dashboard') }}" class="btn btn-default">
                                    <i class="fas fa-times"></i> Limpiar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @foreach($grupos as $grupo)
            @php
                $patsQuery = $grupo->pats()->with('tutor');
                
                if (request('periodo_id')) {
                    $patsQuery->where('periodo_id', request('periodo_id'));
                }
                
                $patsGrupo = $patsQuery->get();
                $totalActividades = $patsGrupo->count();
                $completadas = $patsGrupo->where('estado', 'completado')->count();
                $enProceso = $patsGrupo->where('estado', 'en_proceso')->count();
                $pendientes = $patsGrupo->where('estado', 'pendiente')->count();
            @endphp
            
            @if(!request('grupo_id') || request('grupo_id') == $grupo->id)
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users"></i> {{ $grupo->nombre_grupo ?? $grupo->nombre }}
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-info">{{ $totalActividades }} actividades</span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($totalActividades > 0)
                                <div class="progress-group">
                                    Completadas
                                    <span class="float-right"><b>{{ $completadas }}</b>/{{ $totalActividades }}</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: {{ $totalActividades > 0 ? ($completadas/$totalActividades)*100 : 0 }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="progress-group">
                                    En Proceso
                                    <span class="float-right"><b>{{ $enProceso }}</b>/{{ $totalActividades }}</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: {{ $totalActividades > 0 ? ($enProceso/$totalActividades)*100 : 0 }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <strong>Tutores:</strong>
                                    <ul class="list-unstyled">
                                        @foreach($patsGrupo->groupBy('tutor.nombre') as $tutorNombre => $patsTutor)
                                            <li>
                                                <i class="fas fa-user-tie"></i> {{ $tutorNombre }}
                                                <span class="badge badge-light">{{ $patsTutor->count() }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                
                                <div class="mt-2">
                                    <a href="{{ route('pats.index', ['grupo_id' => $grupo->id, 'periodo_id' => request('periodo_id')]) }}" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Ver Actividades
                                    </a>
                                    <a href="{{ route('pats.create', ['grupo_id' => $grupo->id, 'periodo_id' => request('periodo_id')]) }}" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> Agregar PAT
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <p>No hay actividades registradas</p>
                                    <a href="{{ route('pats.create', ['grupo_id' => $grupo->id, 'periodo_id' => request('periodo_id')]) }}" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> Agregar PAT
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    
    @if(!request('grupo_id'))
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Estadísticas Generales</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Completados</span>
                                        <span class="info-box-number">{{ $estadisticas['completados'] ?? 0 }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: {{ $estadisticas['porcentaje_completados'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-sync-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">En Proceso</span>
                                        <span class="info-box-number">{{ $estadisticas['en_proceso'] ?? 0 }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: {{ $estadisticas['porcentaje_en_proceso'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-secondary">
                                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Pendientes</span>
                                        <span class="info-box-number">{{ $estadisticas['pendientes'] ?? 0 }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: {{ $estadisticas['porcentaje_pendientes'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-clipboard-list"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total PATs</span>
                                        <span class="info-box-number">{{ $estadisticas['total'] ?? 0 }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop

@section('css')
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
        }
        .card-outline {
            border-top: 3px solid #007bff;
        }
        .info-box {
            min-height: 90px;
        }
        .info-box-icon {
            height: 90px;
            line-height: 90px;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@stop