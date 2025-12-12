@extends('adminlte::page')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h3>Formularios de Entrevista</h3>

        <a href="{{ route('entrevistas.create') }}" class="btn btn-primary">
            Nuevo Formulario
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Número Control</th>
                <th>Nombre</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($formularios as $form)
                <tr>
                    <td>{{ $form->id }}</td>
                    <td>{{ $form->numero_control }}</td>
                    <td>{{ $form->nombre_completo }}</td>
                    <td>{{ $form->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('entrevistas.show', $form->id) }}" class="btn btn-sm btn-info">Ver</a>


                        <form action="{{ route('entrevistas.destroy', $form->id) }}" 
                              method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay registros.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $formularios->links() }}

</div>
@endsection
