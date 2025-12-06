@extends('adminlte::page')

@section('title', 'Panel del Tutor')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-primary mb-0"><i class="fas fa-user-tie"></i> Panel del Tutor</h1>
        <span class="badge bg-info text-dark px-3 py-2">
            Bienvenido, <strong>{{ Auth::user()->name }}</strong>
        </span>
    </div>
@stop

@section('content')
    {{-- ====================== --}}
    {{-- TARJETAS RESUMEN --}}
    {{-- ====================== --}}
    <div class="row mt-3">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info shadow-sm">
                <div class="inner">
                    <h3>{{ $totalTutorados ?? 0 }}</h3>
                    <p>Tutorados Asignados</p>
                </div>
                <div class="icon"><i class="fas fa-user-graduate"></i></div>
                <a href="#" class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ $totalSesiones ?? 0 }}</h3>
                    <p>Sesiones Realizadas</p>
                </div>
                <div class="icon"><i class="fas fa-book-open"></i></div>
                <a href="#" class="small-box-footer">Registrar nueva <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning shadow-sm">
                <div class="inner">
                    <h3>{{ $totalReportes ?? 0 }}</h3>
                    <p>Reportes Generados</p>
                </div>
                <div class="icon"><i class="fas fa-file-alt"></i></div>
                <a href="#" class="small-box-footer">Ver reportes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger shadow-sm">
                <div class="inner">
                    <h3>{{ $tutoresActivos ?? 0 }}</h3>
                    <p>Tutores Activos</p>
                </div>
                <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <a href="{{ route('tutores.index') }}" class="small-box-footer">Gestionar tutores <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    {{-- ====================== --}}
    {{-- GRAFICAS Y ACTIVIDAD --}}
    {{-- ====================== --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h3 class="card-title text-primary">
                        <i class="fas fa-chart-line"></i> Progreso de Tutorías
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="graficaProgreso" height="180"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h3 class="card-title text-primary">
                        <i class="fas fa-chart-pie"></i> Distribución de Actividades
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="graficaActividades" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================== --}}
    {{-- HERRAMIENTAS --}}
    {{-- ====================== --}}
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-tools me-2"></i>
            <h3 class="card-title mb-0">Herramientas del Docente</h3>
        </div>

        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-3">
                    <a href="{{ route('tutores.index') }}" class="text-decoration-none text-primary d-block">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <p class="mb-0">Gestionar Tutores</p>
                    </a>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <a href="#" class="text-decoration-none text-primary d-block">
                        <i class="fas fa-user-graduate fa-2x mb-2"></i>
                        <p class="mb-0">Ver Tutorados</p>
                    </a>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <a href="#" class="text-decoration-none text-primary d-block">
                        <i class="fas fa-book fa-2x mb-2"></i>
                        <p class="mb-0">Registrar Seguimiento</p>
                    </a>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <a href="#" class="text-decoration-none text-primary d-block">
                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                        <p class="mb-0">Generar Reportes</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <p class="text-center text-muted mt-3 mb-0">
        Sistema de Tutorías — Panel del Tutor © {{ date('Y') }}
    </p>
@stop

@section('js')
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // === GRAFICA DE PROGRESO ===
        const ctxProgreso = document.getElementById('graficaProgreso');
        new Chart(ctxProgreso, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sesiones de Tutoría',
                    data: [5, 9, 7, 10, 8, 12],
                    borderColor: '#007bff',
                    tension: 0.3,
                    fill: true,
                    backgroundColor: 'rgba(0,123,255,0.1)'
                }]
            },
            options: {
                responsive: true,
                plugins: {legend: {display: false}},
                scales: {y: {beginAtZero: true}}
            }
        });

        // === GRAFICA DE ACTIVIDADES ===
        const ctxActividades = document.getElementById('graficaActividades');
        new Chart(ctxActividades, {
            type: 'doughnut',
            data: {
                labels: ['Tutorías Grupales', 'Individuales', 'Reportes', 'Seguimientos'],
                datasets: [{
                    data: [35, 45, 10, 10],
                    backgroundColor: ['#28a745', '#ffc107', '#17a2b8', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {position: 'bottom'},
                }
            }
        });
    </script>
@stop
