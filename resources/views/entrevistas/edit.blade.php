@extends('adminlte::page')

@section('title', 'Editar Formulario')

@section('content_header')
    <h1>Editar Formulario de Entrevista</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('entrevistas.update', $form->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Datos Generales</h4>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-md-4">
                    <label>Carrera</label>
                    <input type="text" name="carrera" class="form-control" value="{{ $form->carrera }}" required>
                </div>

                <div class="col-md-4">
                    <label>Número de Control</label>
                    <input type="text" name="numero_control" class="form-control" value="{{ $form->numero_control }}" required>
                </div>

                <div class="col-md-4">
                    <label>Nombre Completo</label>
                    <input type="text" name="nombre_completo" class="form-control" value="{{ $form->nombre_completo }}" required>
                </div>

            </div>

            <div class="row mt-3">

                <div class="col-md-2">
                    <label>Edad</label>
                    <input type="number" name="edad" class="form-control" value="{{ $form->edad }}" required>
                </div>

                <div class="col-md-3">
                    <label>Género</label>
                    <select name="genero" class="form-control">
                        <option value="masculino" {{ $form->genero=='masculino'?'selected':'' }}>Masculino</option>
                        <option value="femenino" {{ $form->genero=='femenino'?'selected':'' }}>Femenino</option>
                        <option value="otro" {{ $form->genero=='otro'?'selected':'' }}>Otro</option>
                        <option value="prefiero_no_decir" {{ $form->genero=='prefiero_no_decir'?'selected':'' }}>Prefiero no decir</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Estado Civil</label>
                    <select name="estado_civil" class="form-control">
                        <option value="soltero" {{ $form->estado_civil=='soltero'?'selected':'' }}>Soltero</option>
                        <option value="casado" {{ $form->estado_civil=='casado'?'selected':'' }}>Casado</option>
                        <option value="union_libre" {{ $form->estado_civil=='union_libre'?'selected':'' }}>Unión Libre</option>
                        <option value="divorciado" {{ $form->estado_civil=='divorciado'?'selected':'' }}>Divorciado</option>
                        <option value="viudo" {{ $form->estado_civil=='viudo'?'selected':'' }}>Viudo</option>
                        <option value="otro" {{ $form->estado_civil=='otro'?'selected':'' }}>Otro</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ $form->fecha_nacimiento }}">
                </div>

            </div>

            <div class="row mt-3">

                <div class="col-md-6">
                    <label>Lugar de Nacimiento</label>
                    <input type="text" name="lugar_nacimiento" class="form-control" value="{{ $form->lugar_nacimiento }}">
                </div>

                <div class="col-md-3">
                    <label>Teléfono Celular</label>
                    <input type="text" name="telefono_celular" class="form-control" value="{{ $form->telefono_celular }}">
                </div>

                <div class="col-md-3">
                    <label>Teléfono Hogar</label>
                    <input type="text" name="telefono_hogar" class="form-control" value="{{ $form->telefono_hogar }}">
                </div>

            </div>

        </div>
    </div>

    <button class="btn btn-success mt-3">Actualizar</button>
</form>

@stop
