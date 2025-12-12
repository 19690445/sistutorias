        @extends('adminlte::page')

        @section('title', 'Panel del Tutor')

        @section('content_header')
        <div class="d-flex justify-content-between align-items-center py-3">
            <div>
                <h1 class="h2 mb-0 text-primary"><i class="fas fa-user-tie me-2"></i>Panel del Tutor</h1>
                <p class="text-muted mb-0">Resumen de actividades y herramientas disponibles</p>
            </div>
            <div class="d-flex align-items-center">
                <div class="me-3 text-end">
                    <p class="mb-0 text-muted small">Bienvenido</p>
                    <p class="mb-0 fw-bold">{{ Auth::user()->name }}</p>
                </div>
                <div class="user-avatar">
                    <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width: 50px; height: 50px;">
                        <i class="fas fa-user fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
        @stop

        @section('content')

        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card border-start border-4 border-info border-opacity-75 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted fw-normal mb-1">Tutorados Asignados</h6>
                                <h3 class="fw-bold mb-0">{{ $totalTutorados ?? 0 }}</h3>
                                <p class="text-success small mb-0">
                                    <i class="fas fa-arrow-up me-1"></i>Activos
                                </p>
                            </div>
                            <div class="icon-circle bg-info bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-user-graduate fs-3 text-info"></i>
                            </div>
                        </div>
                        <a href="#" class="stretched-link text-decoration-none d-block mt-3 text-info small">
                            Ver detalles <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card border-start border-4 border-success border-opacity-75 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted fw-normal mb-1">Sesiones Realizadas</h6>
                                <h3 class="fw-bold mb-0">{{ $totalSesiones ?? 0 }}</h3>
                                <p class="text-success small mb-0">
                                    <i class="fas fa-calendar-check me-1"></i>Este mes: {{ $sesionesMes ?? 0 }}
                                </p>
                            </div>
                            <div class="icon-circle bg-success bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-book-open fs-3 text-success"></i>
                            </div>
                        </div>
                        <a href="#" class="stretched-link text-decoration-none d-block mt-3 text-success small">
                            Registrar nueva <i class="fas fa-plus-circle ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card border-start border-4 border-warning border-opacity-75 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted fw-normal mb-1">Reportes Generados</h6>
                                <h3 class="fw-bold mb-0">{{ $totalReportes ?? 0 }}</h3>
                                <p class="text-warning small mb-0">
                                    <i class="fas fa-clock me-1"></i>Pendientes: {{ $reportesPendientes ?? 0 }}
                                </p>
                            </div>
                            <div class="icon-circle bg-warning bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-file-alt fs-3 text-warning"></i>
                            </div>
                        </div>
                        <a href="#" class="stretched-link text-decoration-none d-block mt-3 text-warning small">
                            Ver reportes <i class="fas fa-external-link-alt ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card border-start border-4 border-danger border-opacity-75 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted fw-normal mb-1">Tutores Activos</h6>
                                <h3 class="fw-bold mb-0">{{ $tutoresActivos ?? 0 }}</h3>
                                <p class="text-danger small mb-0">
                                    <i class="fas fa-users me-1"></i>Total registrados
                                </p>
                            </div>
                            <div class="icon-circle bg-danger bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-chalkboard-teacher fs-3 text-danger"></i>
                            </div>
                        </div>
                        <a href="{{ route('tutores.index') }}" class="stretched-link text-decoration-none d-block mt-3 text-danger small">
                            Gestionar <i class="fas fa-cog ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0 text-primary">
                                <i class="fas fa-chart-line me-2"></i>Progreso de Tutorías
                            </h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Últimos 6 meses
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Último mes</a></li>
                                    <li><a class="dropdown-item" href="#">Últimos 3 meses</a></li>
                                    <li><a class="dropdown-item" href="#">Este año</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 250px;">
                            <canvas id="graficaProgreso"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="fas fa-chart-pie me-2"></i>Distribución de Actividades
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 250px;">
                            <canvas id="graficaActividades"></canvas>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small"><i class="fas fa-circle text-success me-1"></i> Tutorías Grupales</span>
                                <span class="small fw-bold">35%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small"><i class="fas fa-circle text-warning me-1"></i> Individuales</span>
                                <span class="small fw-bold">45%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small"><i class="fas fa-circle text-info me-1"></i> Reportes</span>
                                <span class="small fw-bold">10%</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="small"><i class="fas fa-circle text-danger me-1"></i> Seguimientos</span>
                                <span class="small fw-bold">10%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="fas fa-tools me-2"></i>Herramientas del Tutor
                        </h5>
                        <p class="text-muted small mb-0">Accede rápidamente a las funciones principales</p>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('tutores.index') }}" class="card tool-card text-decoration-none h-100 border">
                                    <div class="card-body text-center p-4">
                                        <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle p-3 mb-3 mx-auto" style="width: 70px; height: 70px;">
                                            <i class="fas fa-users fs-3 text-primary"></i>
                                        </div>
                                        <h6 class="fw-bold mb-2">Gestionar Tutores</h6>
                                        <p class="text-muted small mb-0">Administra la información de tutores</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-lg-3 col-md-6">
                                <a href="#" class="card tool-card text-decoration-none h-100 border">
                                    <div class="card-body text-center p-4">
                                        <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle p-3 mb-3 mx-auto" style="width: 70px; height: 70px;">
                                            <i class="fas fa-user-graduate fs-3 text-success"></i>
                                        </div>
                                        <h6 class="fw-bold mb-2">Ver Tutorados</h6>
                                        <p class="text-muted small mb-0">Consulta estudiantes asignados</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-lg-3 col-md-6">
                                <a href="#" class="card tool-card text-decoration-none h-100 border">
                                    <div class="card-body text-center p-4">
                                        <div class="icon-wrapper bg-warning bg-opacity-10 rounded-circle p-3 mb-3 mx-auto" style="width: 70px; height: 70px;">
                                            <i class="fas fa-book fs-3 text-warning"></i>
                                        </div>
                                        <h6 class="fw-bold mb-2">Registrar Seguimiento</h6>
                                        <p class="text-muted small mb-0">Documenta avances y reuniones</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-lg-3 col-md-6">
                                <a href="#" class="card tool-card text-decoration-none h-100 border">
                                    <div class="card-body text-center p-4">
                                        <div class="icon-wrapper bg-info bg-opacity-10 rounded-circle p-3 mb-3 mx-auto" style="width: 70px; height: 70px;">
                                            <i class="fas fa-file-alt fs-3 text-info"></i>
                                        </div>
                                        <h6 class="fw-bold mb-2">Generar Reportes</h6>
                                        <p class="text-muted small mb-0">Crea informes de actividades</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="fas fa-bell me-2"></i>Próximas Actividades
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Reunión de seguimiento</h6>
                                        <p class="text-muted small mb-0">Hoy, 3:00 PM - Sala 203</p>
                                    </div>
                                    <span class="badge bg-info">Próximo</span>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Reporte mensual</h6>
                                        <p class="text-muted small mb-0">Vence en 2 días</p>
                                    </div>
                                    <span class="badge bg-warning">Pendiente</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @stop

        @section('footer')
        <div class="footer py-3 text-center text-muted">
            <div class="container">
                <p class="mb-0">
                    Sistema de Tutorías — Panel del Tutor © {{ date('Y') }}
                    <span class="mx-2">|</span>
                    <i class="fas fa-sync-alt me-1"></i>Última actualización: {{ now()->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
        @stop

        @section('css')
        <style>
            .tool-card {
                transition: transform 0.2s, box-shadow 0.2s;
            }
            
            .tool-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
                border-color: #007bff !important;
            }
            
            .icon-circle {
                transition: transform 0.3s;
            }
            
            .card:hover .icon-circle {
                transform: scale(1.1);
            }
            
            .avatar-circle {
                background: linear-gradient(135deg, #007bff, #6610f2);
            }
            
            .border-start {
                border-left-width: 4px !important;
            }
            
            .chart-container {
                position: relative;
            }
        </style>
        @stop

        @section('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

              
                const ctxProgreso = document.getElementById('graficaProgreso');
                new Chart(ctxProgreso, {
                    type: 'line',
                    data: {
                        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
                        datasets: [{
                            label: 'Sesiones de Tutoría',
                            data: [5, 9, 7, 10, 8, 12],
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#007bff',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                ticks: {
                                    stepSize: 2
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });

              
                const ctxActividades = document.getElementById('graficaActividades');
                new Chart(ctxActividades, {
                    type: 'doughnut',
                    data: {
                        labels: ['Tutorías Grupales', 'Individuales', 'Reportes', 'Seguimientos'],
                        datasets: [{
                            data: [35, 45, 10, 10],
                            backgroundColor: [
                                '#28a745',
                                '#ffc107',
                                '#17a2b8',
                                '#dc3545'
                            ],
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.label}: ${context.parsed}%`;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
        @stop