<div class="container-fluid">
    <h5>Estudiante: {{ $estudiante->nombre }} {{ $estudiante->apellido }}</h5>
    
    @if($estudiante->asistencias->count() > 0)
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Sesión</th>
                        <th>Tutor</th>
                        <th>Grupo</th>
                        <th>Periodo</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estudiante->asistencias as $asistencia)
                    <tr>
                        <td>{{ $asistencia->fecha->format('d/m/Y') }}</td>
                        <td>{{ $asistencia->sesion }}</td>
                        <td>{{ $asistencia->tutor->nombre ?? 'N/A' }}</td>
                        <td>{{ $asistencia->grupo->nombre ?? 'N/A' }}</td>
                        <td>{{ $asistencia->periodo->nombre ?? 'N/A' }}</td>
                        <td>
                            @php
                                $estados = [
                                    'si' => ['label' => 'Presente', 'class' => 'success'],
                                    'no' => ['label' => 'Ausente', 'class' => 'danger'],
                                    'np' => ['label' => 'No Programado', 'class' => 'warning'],
                                    'justificado' => ['label' => 'Justificado', 'class' => 'info'],
                                ];
                                $estado = $estados[$asistencia->estado];
                            @endphp
                            <span class="badge badge-{{ $estado['class'] }}">
                                {{ $estado['label'] }}
                            </span>
                        </td>
                        <td>{{ $asistencia->observaciones ?? 'Sin observaciones' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            <h6>Resumen:</h6>
            @php
                $total = $estudiante->asistencias->count();
                $presentes = $estudiante->asistencias->where('estado', 'si')->count();
                $ausentes = $estudiante->asistencias->where('estado', 'no')->count();
                $justificados = $estudiante->asistencias->where('estado', 'justificado')->count();
                $noProgramados = $estudiante->asistencias->where('estado', 'np')->count();
                $porcentaje = $total > 0 ? round(($presentes / $total) * 100, 2) : 0;
            @endphp
            <p>Total de sesiones: {{ $total }}</p>
            <p>Presentes: {{ $presentes }} ({{ $porcentaje }}%)</p>
            <p>Ausentes: {{ $ausentes }}</p>
            <p>Justificados: {{ $justificados }}</p>
            <p>No programados: {{ $noProgramados }}</p>
        </div>
    @else
        <div class="alert alert-info">
            El estudiante no tiene registros de asistencia.
        </div>
    @endif
</div>