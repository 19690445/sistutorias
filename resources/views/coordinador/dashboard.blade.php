@extends('adminlte::page')

@section('title', 'Panel Coordinador')

@section('content_header')
<div class="d-flex justify-content-between align-items-center py-2">
    <div>
        <h1 class="h3 mb-1 text-warning fw-bold">
            <i class="fas fa-user-cog me-2"></i>Panel Coordinador
        </h1>
        <p class="text-muted mb-0 small">Resumen del sistema</p>
    </div>
    <div class="text-end">
        <p class="mb-0 text-muted xsmall">Bienvenido</p>
        <p class="mb-0 fw-bold">{{ Auth::user()->name }}</p>
        <span class="badge bg-warning text-dark small">
            {{ Auth::user()->role->nombre ?? 'Coordinador' }}
        </span>
    </div>
</div>
@stop

@section('content')


<div class="row g-2 mb-3">
    <div class="col-md-4">
        <div class="card border-start border-3 border-success shadow-sm">
            <div class="card-body py-2">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-0 small">Tutorados</h6>
                        <h4 class="mb-0 fw-bold">{{ $totalTutorados ?? 0 }}</h4>
                    </div>
                    <div class="ms-2">
                        <i class="fas fa-user-graduate fa-lg text-success"></i>
                    </div>
                </div>
                <a href="{{ route('coordinador.tutorados.index') }}" class="stretched-link"></a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-start border-3 border-warning shadow-sm">
            <div class="card-body py-2">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-0 small">Sesiones</h6>
                        <h4 class="mb-0 fw-bold">{{ $totalSesiones ?? 0 }}</h4>
                    </div>
                    <div class="ms-2">
                        <i class="fas fa-book-open fa-lg text-warning"></i>
                    </div>
                </div>
                <a href="#" class="stretched-link"></a>
            </div>
        </div>
    </div>
</div>


<div class="row g-2 mb-3">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-2">
                <h6 class="card-title mb-0 text-warning small">
                    <i class="fas fa-chart-line me-1"></i>Avance de Tutorías
                </h6>
            </div>
            <div class="card-body p-2">
                <canvas id="graficaAvance" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-2">
                <h6 class="card-title mb-0 text-warning small">
                    <i class="fas fa-chart-pie me-1"></i>Distribución
                </h6>
            </div>
            <div class="card-body p-2">
                <canvas id="graficaDistribucion" height="120"></canvas>
            </div>
        </div>
    </div>
</div>


<div class="card shadow-sm">
    <div class="card-header bg-warning bg-opacity-10 border-warning py-2">
        <h6 class="card-title mb-0 text-warning small">
            <i class="fas fa-tools me-1"></i>Herramientas
        </h6>
    </div>
    <div class="card-body p-2">
        <div class="row g-2">
            <div class="col-md-3 col-6">
                <a href="{{ route('tutores.index') }}" class="card h-100 border-0 text-decoration-none">
                    <div class="card-body text-center p-2">
                        <div class="mb-1">
                            <i class="fas fa-chalkboard-teacher fa-lg text-warning"></i>
                        </div>
                        <p class="mb-0 small">Gestionar Tutores</p>
                    </div>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="{{ route('coordinador.tutorados.index') }}" class="card h-100 border-0 text-decoration-none">
                    <div class="card-body text-center p-2">
                        <div class="mb-1">
                            <i class="fas fa-user-graduate fa-lg text-warning"></i>
                        </div>
                        <p class="mb-0 small">Ver Tutorados</p>
                    </div>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="" class="card h-100 border-0 text-decoration-none">
                    <div class="card-body text-center p-2">
                        <div class="mb-1">
                            <i class="fas fa-chart-bar fa-lg text-warning"></i>
                        </div>
                        <p class="mb-0 small">Estadísticas</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')
<div class="text-center text-muted py-2 xsmall">
    Sistema de Tutorías — <span class="badge bg-warning text-dark">{{ Auth::user()->role->nombre ?? 'Coordinador' }}</span> © {{ date('Y') }}
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    new Chart(document.getElementById('graficaAvance'), {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{
                data: [12, 15, 10, 18, 14, 20],
                backgroundColor: '#ffc107',
                borderColor: '#e0a800',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false }
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    ticks: { font: { size: 9 } }
                },
                x: {
                    ticks: { font: { size: 9 } }
                }
            }
        }
    });

    
    new Chart(document.getElementById('graficaDistribucion'), {
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
            maintainAspectRatio: false,
            plugins: { 
                legend: { 
                    position: 'bottom',
                    labels: { 
                        padding: 10,
                        font: { size: 9 }
                    }
                }
            },
            cutout: '60%'
        }
    });
</script>
@stop           