@php
    // Si $grupo existe (edit), obtenemos los IDs de los tutorados seleccionados
    $selectedTutorados = $grupo?->tutorados?->pluck('id')->toArray() ?? [];
@endphp

<form action="{{ isset($grupo) ? route('grupos.update', $grupo) : route('grupos.store') }}" method="POST">
    @csrf
    @if(isset($grupo))
        @method('PUT')
    @endif

   
    <div class="mb-3">
        <label for="clave_grupo" class="form-label">Clave del Grupo</label>
        <input type="text" name="clave_grupo" id="clave_grupo" class="form-control" 
            value="{{ old('clave_grupo', $grupo->clave_grupo ?? '') }}" required>
    </div>

    
    <div class="mb-3">
        <label for="nombre_grupo" class="form-label">Nombre del Grupo</label>
        <input type="text" name="nombre_grupo" id="nombre_grupo" class="form-control" 
            value="{{ old('nombre_grupo', $grupo->nombre_grupo ?? '') }}" required>
    </div>

  
            <div class="col-md-4">
                    <label for="periodo_id">Periodo</label>
                    <select name="periodo_id" id="periodo_id" class="form-control" required>
                        <option value="">Selecciona un periodo</option>
                        @foreach($periodos as $periodo)
                            <option value="{{ $periodo->id }}">{{ $periodo->nombre_periodo }}</option>
                        @endforeach
                    </select>
            </div>

    <div class="mb-3">
        <label for="tutor_id" class="form-label">Tutor</label>
        <select name="tutor_id" id="tutor_id" class="form-select" required>
            <option value="">-- Seleccione --</option>
            @foreach($tutores as $tutor)
                <option value="{{ $tutor->id }}" 
                    {{ old('tutor_id', $grupo->tutores_id ?? '') == $tutor->id ? 'selected' : '' }}>
                    {{ $tutor->name }}
                </option>
            @endforeach
        </select>
    </div>


    <div class="mb-3">
        <label for="tutorados" class="form-label">Tutorados</label>
        <select name="tutorados[]" id="tutorados" class="form-select" multiple required>
            @foreach($tutorados as $tutorado)
                <option value="{{ $tutorado->id }}" 
                    {{ in_array($tutorado->id, $selectedTutorados) ? 'selected' : '' }}>
                    {{ $tutorado->name }}
                </option>
            @endforeach
        </select>
    </div>

    
    <div class="mb-3">
        <label for="carrera" class="form-label">Carrera</label>
        <input type="text" name="carrera" id="carrera" class="form-control" 
            value="{{ old('carrera', $grupo->carrera ?? '') }}" required>
    </div>

   
    <div class="mb-3">
        <label for="semestre" class="form-label">Semestre</label>
        <input type="number" name="semestre" id="semestre" class="form-control" 
            value="{{ old('semestre', $grupo->semestre ?? '') }}" min="1" required>
    </div>

  
    <div class="mb-3">
        <label for="modalidad" class="form-label">Modalidad</label>
        <select name="modalidad" id="modalidad" class="form-select" required>
            @php
                $modalidades = ['presencial', 'virtual', 'mixta'];
            @endphp
            @foreach($modalidades as $modalidad)
                <option value="{{ $modalidad }}" 
                    {{ old('modalidad', $grupo->modalidad ?? '') == $modalidad ? 'selected' : '' }}>
                    {{ ucfirst($modalidad) }}
                </option>
            @endforeach
        </select>
    </div>

    
    <div class="mb-3">
        <label for="turno" class="form-label">Turno</label>
        <select name="turno" id="turno" class="form-select" required>
            @php
                $turnos = ['matutino', 'intermedio', 'vespertino'];
            @endphp
            @foreach($turnos as $turno)
                <option value="{{ $turno }}" 
                    {{ old('turno', $grupo->turno ?? '') == $turno ? 'selected' : '' }}>
                    {{ ucfirst($turno) }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ isset($gr
