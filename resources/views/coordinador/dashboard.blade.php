@extends('adminlte::page')

@section('title', 'Panel del Coordinador')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-warning mb-0"><i class="fas fa-user-cog"></i> Panel del Coordinador</h1>
        <span class="badge bg-warning text-dark px-3 py-2">
            Bienvenido, <strong>{{ Auth::user()->name }}</strong>
        </span>
    </div>
@stop

@section('content')
   
    {{-- TARJETAS RESUMEN --}}
    
        <div class="col-lg-6 col-6">
            <div class="small-box bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ $totalTutorados ?? 0 }}</h3>
                    <p>Tutorados Registrados</p>
                </div>
                <div class="icon"><i class="fas fa-user-graduate"></i></div>
                <a href="{{ route('coordinador.tutorados.index') }}" class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-6 col-6">
            <div class="small-box bg-warning shadow-sm">
                <div class="inner">
                    <h3>{{ $totalSesiones ?? 0 }}</h3>
                    <p>Sesiones de Tutoría</p>
                </div>
                <div class="icon"><i class="fas fa-book-open"></i></div>
                <a href="#" class="small-box-footer">Ver sesiones <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-6 col-6">
            <div class="small-box bg-danger shadow-sm">
                <div class="inner">
                    <h3>{{ $reportesPendientes ?? 0 }}</h3>
                    <p>Reportes Pendientes</p>
                </div>
                <div class="icon"><i class="fas fa-file-alt"></i></div>
                <a href="#" class="small-box-footer">Revisar reportes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

   
    {{--MONITOREO --}}
   
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h3 class="card-title text-warning">
                        <i class="fas fa-chart-line"></i> Avance de Tutorías por Mes
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="graficaAvance" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

  
    {{-- HERRAMIENTAS DEL COORDINADOR --}}
   
    <div class="card shadow">
        <div class="card-header bg-warning text-dark d-flex align-items-center">
            <i class="fas fa-tools me-2"></i>
            <h3 class="card-title mb-0">Herramientas del Coordinador</h3>
        </div>

        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-3">
                    <a href="{{ route('tutores.index') }}" class="text-decoration-none text-warning d-block">
                        <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
                        <p class="mb-0">Gestionar Tutores</p>
                    </a>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <a href="{{ route('coordinador.tutorados.index') }}" class="text-decoration-none text-warning d-block">
                        <i class="fas fa-user-graduate fa-2x mb-2"></i>
                        <p class="mb-0">Ver Tutorados</p>
                    </a>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <a href="#" class="text-decoration-none text-warning d-block">
                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                        <p class="mb-0">Revisar Reportes</p>
                    </a>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <a href="#" class="text-decoration-none text-warning d-block">
                        <i class="fas fa-chart-bar fa-2x mb-2"></i>
                        <p class="mb-0">Estadísticas del Sistema</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <p class="text-center text-muted mt-3 mb-0">
        Sistema de Tutorías — Panel del Coordinador © {{ date('Y') }}
    </p>
@stop

@section('js')
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // === GRAFICA DE AVANCE ===
        const ctxAvance = document.getElementById('graficaAvance');
        new Chart(ctxAvance, {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sesiones Realizadas',
                    data: [12, 15, 10, 18, 14, 20],
                    backgroundColor: '#ffc107',
                    borderColor: '#e0a800',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {legend: {display: false}},
                scales: {y: {beginAtZero: true}}
            }
        });

        // === GRAFICA DE DISTRIBUCION ===
        const ctxDistribucion = document.getElementById('graficaDistribucion');
        new Chart(ctxDistribucion, {
            type: 'doughnut',
            data: {
                labels: ['Tutor A', 'Tutor B', 'Tutor C', 'Tutor D'],
                datasets: [{
                    data: [25, 30, 20, 25],
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {legend: {position: 'bottom'}}
            }
        });
    </script>
@stop
