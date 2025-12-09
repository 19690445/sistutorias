@extends('adminlte::page')


@section('content')
<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Importar Estudiantes al Grupo: {{ $grupo->nombre_grupo }}</h3>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('grupos.import.excel', $grupo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="archivo">Selecciona el archivo Excel (.xlsx, .xls, .csv)</label>
                    <input type="file" name="archivo" id="archivo" class="form-control" required>
                    @error('archivo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-file-import"></i> Importar Estudiantes
                </button>
                <a href="{{ route('grupos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </form>

            <hr>
            <p><strong>Nota:</strong> El archivo Excel debe tener las columnas: <em>nombre, apellido, email, matricula</em> en la primera fila.</p>
        </div>
    </div>
</div>
@endsection
