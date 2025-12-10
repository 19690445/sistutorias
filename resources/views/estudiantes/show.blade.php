{{-- resources/views/estudiantes/show.blade.php --}}
<div class="card">
    <div class="card-header">
        <h5>Canalizaciones del Estudiante</h5>
    </div>
    <div class="card-body">
        @if($estudiante->canalizaciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Motivo</th>
                            <th>Tutor</th>
                            <th>Período</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estudiante->canalizaciones as $canalizacion)
                            <tr>
                                <td>{{ $canalizacion->id }}</td>
                                <td>{{ $canalizacion->fecha_canalizacion->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($canalizacion->motivo, 50) }}</td>
                                <td>{{ $canalizacion->tutor->nombre ?? 'N/A' }}</td>
                                <td>{{ $canalizacion->periodo->nombre ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('canalizaciones.show', $canalizacion->id) }}" 
                                       class="btn btn-sm btn-info">
                                        Ver
                                    </a>
                                    <a href="{{ route('canalizaciones.edit', $canalizacion->id) }}" 
                                       class="btn btn-sm btn-warning">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                Este estudiante no tiene canalizaciones registradas.
                <a href="{{ route('canalizaciones.create', ['estudiante_id' => $estudiante->id]) }}" 
                   class="btn btn-sm btn-primary ml-2">
                    Crear Canalización
                </a>
            </div>
        @endif
    </div>
</div>