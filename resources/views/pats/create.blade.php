@extends('adminlte::page')

@section('title', 'Registro de PAT')

@section('content_header')
    <h1>Programa de Acción Tutorial (PAT)</h1>
    <p>Registro de actividades por semana</p>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Nuevo Programa de Acción Tutorial</h3>
        </div>
        
        <form action="{{ route('pats.store') }}" method="POST">
            @csrf
            
            <div class="card-body">
               
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tutor">Nombre del Tutor:</label>
                            <select class="form-control select2" id="tutor" name="tutores_id" required
                                    {{ $tutores->isEmpty() ? 'disabled' : '' }}>
                                <option value="">Seleccionar tutor</option>
                                @foreach($tutores as $tutor)
                                    <option value="{{ $tutor->id }}">{{ $tutor->nombre }}</option>
                                @endforeach
                            </select>
                            @if($tutores->isEmpty())
                                <small class="text-danger">No hay tutores disponibles</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="grupo_id">Grupo</label>
                            <select name="grupo_id" id="grupo_id" class="form-control select2" required
                                    {{ $grupos->isEmpty() ? 'disabled' : '' }}>
                                <option value="">Seleccione un grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ request('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->nombre_grupo ?? $grupo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @if($grupos->isEmpty())
                                <small class="text-danger">No hay grupos disponibles</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="periodo_id">Periodo</label>
                            <select name="periodo_id" id="periodo_id" class="form-control select2" required
                                    {{ $periodos->isEmpty() ? 'disabled' : '' }}>
                                <option value="">Seleccionar</option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ request('periodo_id') == $periodo->id ? 'selected' : '' }}>
                                        {{ $periodo->nombre_periodo ?? $periodo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @if($periodos->isEmpty())
                                <small class="text-danger">No hay periodos disponibles</small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">NO.</th>
                                <th width="30%">ACTIVIDAD</th>
                                <th width="10%">RESPONSABLE</th>
                                <th width="5%">P</th>
                                @for($i = 1; $i <= 16; $i++)
                                    <th width="3%" class="text-center">{{ $i }}</th>
                                @endfor
                                <th width="5%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="actividades-container">
                            <!-- se generan las filas dinamicamente -->
                        </tbody>
                    </table>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" id="nueva-actividad" class="form-control" placeholder="Nueva actividad">
                            <div class="input-group-append">
                                <button type="button" id="agregar-actividad" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Agregar Actividad
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select id="responsable-actividad" class="form-control">
                                <option value="tutor">Tutor</option>
                                <option value="tutorado">Tutorado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" {{ $tutores->isEmpty() || $grupos->isEmpty() || $periodos->isEmpty() ? 'disabled' : '' }}>
                    <i class="fas fa-save"></i> Guardar PAT
                </button>
                <a href="{{ route('pats.index') }}" class="btn btn-default">Cancelar</a>
            </div>
        </form>
    </div>
@stop

@section('css')
    <style>
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .table thead th {
            background-color: #343a40;
            color: white;
        }
        .actividad-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        .responsable-select {
            width: 100%;
            padding: 2px 5px;
            font-size: 0.9rem;
        }
        #actividades-container tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .select2-container--default .select2-selection--single {
            height: 38px;
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
        
        let contadorActividades = 0;
        
        document.getElementById('agregar-actividad').addEventListener('click', function() {
            const actividadInput = document.getElementById('nueva-actividad');
            const responsableSelect = document.getElementById('responsable-actividad');
            
            if (actividadInput.value.trim() === '') {
                alert('Por favor ingrese el nombre de la actividad');
                return;
            }
            
            contadorActividades++;
            
            const fila = document.createElement('tr');
            fila.id = `actividad-${contadorActividades}`;
            
        
            fila.innerHTML = `
                <td>${contadorActividades}</td>
                <td>
                    <input type="hidden" name="actividades[${contadorActividades}][actividad]" value="${actividadInput.value}">
                    ${actividadInput.value}
                </td>
                <td>
                    <select name="actividades[${contadorActividades}][responsable]" class="responsable-select">
                        <option value="tutor" ${responsableSelect.value === 'tutor' ? 'selected' : ''}>Tutor</option>
                        <option value="tutorado" ${responsableSelect.value === 'tutorado' ? 'selected' : ''}>Tutorado</option>
                    </select>
                </td>
                <td>
                    <input type="checkbox" name="actividades[${contadorActividades}][planeada]" value="1" class="actividad-checkbox">
                </td>
            `;
            
            //casillas
            for (let semana = 1; semana <= 16; semana++) {
                fila.innerHTML += `
                    <td>
                        <input type="checkbox" name="actividades[${contadorActividades}][semanas][${semana}]" value="1" class="actividad-checkbox semana-checkbox" data-actividad="${contadorActividades}" data-semana="${semana}">
                    </td>
                `;
            }
            
            const celdaAcciones = document.createElement('td');
            celdaAcciones.innerHTML = `
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarActividad(${contadorActividades})">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            fila.appendChild(celdaAcciones);
            
            document.getElementById('actividades-container').appendChild(fila);
            
    
            actividadInput.value = '';
        });
        
        function eliminarActividad(id) {
            document.getElementById(`actividad-${id}`).remove();
         
            const filas = document.querySelectorAll('#actividades-container tr');
            filas.forEach((fila, index) => {
                fila.cells[0].textContent = index + 1;
            });
            contadorActividades = filas.length;
        }
        
    
        document.getElementById('nueva-actividad').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('agregar-actividad').click();
            }
        });
    </script>
@stop