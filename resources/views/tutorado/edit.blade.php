@extends('adminlte::page')

@section('title', 'Editar Mi Perfil')

@section('content_header')
    <h1>Editar Mi Perfil</h1>
@stop

@section('content')
<div class="row">
    
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile text-center">
                <form action="{{ route('tutorado.updatePerfil') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <img id="preview-foto" class="profile-user-img img-fluid img-circle mb-3"
                         src="{{ $tutorado->foto ? asset('storage/' . $tutorado->foto) : asset('img/default-user.png') }}"
                         alt="Foto de {{ $tutorado->nombre }}">

                    <div class="form-group">
                        <label for="foto">Cambiar Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewFoto(event)">
                    </div>

                    <h3 class="profile-username text-center">{{ $tutorado->nombre }} {{ $tutorado->apellidos }}</h3>
                    <p class="text-muted text-center">{{ $tutorado->carrera }} - Semestre {{ $tutorado->semestre }}</p>

                    <ul class="list-group list-group-unbordered mb-3 text-left">
                        <li class="list-group-item"><b>Matrícula:</b> {{ $tutorado->matricula }}</li>
                        <li class="list-group-item"><b>CURP:</b> <input type="text" name="curp" value="{{ old('curp', $tutorado->curp) }}" class="form-control"></li>
                        <li class="list-group-item"><b>Género:</b>
                            <select name="genero" class="form-control">
                                <option value="">Selecciona</option>
                                <option value="masculino" {{ $tutorado->genero == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ $tutorado->genero == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ $tutorado->genero == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </li>
                        <li class="list-group-item"><b>Fecha de Nacimiento:</b> <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $tutorado->fecha_nacimiento) }}" class="form-control"></li>
                        <li class="list-group-item"><b>Estado:</b> {{ ucfirst($tutorado->estado) }}</li>
                        <li class="list-group-item"><b>Fecha de Ingreso:</b> {{ $tutorado->fecha_ingreso }}</li>
                        @if($tutorado->fecha_egreso)
                            <li class="list-group-item"><b>Fecha de Egreso:</b> {{ $tutorado->fecha_egreso }}</li>
                        @endif
                    </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Datos de Contacto y Académicos</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Domicilio</label>
                    <input type="text" name="domicilio" value="{{ old('domicilio', $tutorado->domicilio) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Teléfono Celular</label>
                    <input type="text" name="telefono_celular" value="{{ old('telefono_celular', $tutorado->telefono_celular) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Correo Institucional</label>
                    <input type="email" class="form-control" value="{{ $tutorado->correo_institucional }}" disabled>
                </div>
                <div class="form-group">
                    <label>Carrera</label>
                    <input type="text" class="form-control" value="{{ $tutorado->carrera }}" disabled>
                </div>
                <div class="form-group">
                    <label>Semestre</label>
                    <input type="text" class="form-control" value="{{ $tutorado->semestre }}" disabled>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <a href="{{ route('tutorado.perfil') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('js')
<script>
function previewFoto(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('preview-foto');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@stop
