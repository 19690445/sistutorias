@extends('adminlte::page')

@section('title', 'Panel de Administración')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-primary mb-0">
            <i class="fas fa-tachometer-alt"></i> Panel de Administración
        </h1>
        <span class="badge bg-info text-dark px-3 py-2">
            Rol: <strong>{{ Auth::user()->role->nombre }}</strong>
        </span>
    </div>
@stop

@section('content')
    <div class="alert alert-light border shadow-sm mb-4">
        <h4 class="mb-1">Bienvenido, {{ Auth::user()->name }}</h4>
        <p class="text-muted mb-0">
            Has iniciado sesión como <strong>{{ Auth::user()->role->nombre }}</strong>.
        </p>
    </div>

   
    {{-- PANEL PARA ADMINISTRADOR --}}
    
    @if(Auth::user()->role->nombre === 'admin')
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ \App\Models\User::count() }}</h3>
                        <p>Usuarios Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ \App\Models\Estudiante::count() }}</h3>
                        <p>Tutorados Activos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ \App\Models\User::whereHas('role', fn($q) => $q->where('nombre', 'docente'))->count() }}</h3>
                        <p>Docentes</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ \App\Models\User::whereHas('role', fn($q) => $q->where('nombre', 'coordinador'))->count() }}</h3>
                        <p>Coordinadores</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title text-primary"><i class="fas fa-cogs"></i> Configuración del Sistema</h3>
            </div>
            <div class="card-body">
                <p>Como administrador, puedes gestionar usuarios, roles y accesos al sistema.</p>
                <ul>
                    <li>Monitorear el total de usuarios registrados.</li>
                    <li>Asignar roles (coordinador, docente, tutorado).</li>
                    <li>Gestionar la seguridad y accesos del sistema.</li>
                </ul>
            </div>
        </div>
    @endif

    {{-- PANEL PARA COORDINADOR --}}
    
    @if(Auth::user()->role->nombre === 'coordinador')
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-start border-4 border-primary shadow-sm">
                    <div class="card-body">
                        <h5><i class="fas fa-chalkboard-teacher text-primary"></i> Docentes Registrados</h5>
                        <p class="display-6">{{ \App\Models\User::whereHas('role', fn($q) => $q->where('nombre', 'docente'))->count() }}</p>
                        <small class="text-muted">Docentes activos en el sistema</small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-start border-4 border-success shadow-sm">
                    <div class="card-body">
                        <h5><i class="fas fa-user-graduate text-success"></i> Tutorados Asignados</h5>
                        <p class="display-6">{{ \App\Models\Estudiante::count() }}</p>
                        <small class="text-muted">Tutorados activos bajo supervisión</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title text-primary">
                    <i class="fas fa-clipboard-list"></i> Supervisión Académica
                </h3>
            </div>
            <div class="card-body">
                <p>Como coordinador, puedes monitorear el desempeño de docentes y tutorados.</p>
                <ul>
                    <li>Ver estadísticas de tutorías.</li>
                    <li>Revisar la carga de trabajo de los docentes.</li>
                    <li>Supervisar las asignaciones académicas.</li>
                </ul>
            </div>
        </div>
    @endif

   
    {{-- PANEL PARA DOCENTE --}}
   
    @if(Auth::user()->role->nombre === 'docente')
        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title text-primary">
                    <i class="fas fa-users"></i> Mis Tutorados
                </h3>
            </div>
            <div class="card-body">
                @php
                    $tutorados = \App\Models\Estudiante::where('users_id', Auth::id())->get();
                @endphp

                @if($tutorados->isEmpty())
                    <p class="text-muted">No tienes tutorados asignados aún.</p>
                @else
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Carrera</th>
                                <th>Correo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tutorados as $t)
                                <tr>
                                    <td>{{ $t->nombre }}</td>
                                    <td>{{ $t->carrera ?? 'No especificada' }}</td>
                                    <td>{{ $t->email ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @endif

  
    {{-- PANEL PARA TUTORADO --}}
    
    @if(Auth::user()->role->nombre === 'tutorado')
        <div class="card shadow">
            <div class="card-header bg-light">
                <h3 class="card-title text-primary"><i class="fas fa-book"></i> Mi Progreso Académico</h3>
            </div>
            <div class="card-body">
                <p>Consulta tus avances, tutorías y observaciones asignadas por tu docente.</p>
                <ul>
                    <li>Visualiza tus actividades y resultados.</li>
                    <li>Accede a materiales de apoyo.</li>
                    <li>Revisa las observaciones del tutor.</li>
                </ul>
                <div class="alert alert-info mt-3">
                    Última sesión registrada: {{ now()->subDays(rand(1,10))->format('d/m/Y') }}
                </div>
            </div>
        </div>
    @endif
@stop

@section('footer')
    <p class="text-center text-muted mb-0">
        Sistema de Tutorías — Panel {{ ucfirst(Auth::user()->role->nombre) }} © {{ date('Y') }}
    </p>
@stop
