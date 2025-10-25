@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('auth_header', 'Registrar nueva cuenta')

@section('auth_body')
<form action="{{ route('register.store') }}" method="POST">
    @csrf

    {{-- Nombre --}}
    <div class="input-group mb-3">
        <input type="text" name="name" class="form-control" placeholder="Nombre completo" value="{{ old('name') }}" required autofocus>
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-user"></span></div>
        </div>
    </div>

    {{-- Email --}}
    <div class="input-group mb-3">
        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ old('email') }}" required>
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
        </div>
    </div>

    {{-- Contraseña --}}
    <div class="input-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
        </div>
    </div>

    {{-- Confirmar contraseña --}}
    <div class="input-group mb-3">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña" required>
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
        </div>
    </div>

        <div class="mb-3">
            <label for="rol_id" class="form-label">Rol del usuario</label>
            <select name="rol_id" id="rol_id" class="form-control" required>
                <option value="">Seleccione un rol</option>
                @foreach ($roles as $rol)
                    <option value="{{ $rol->id }}">{{ ucfirst($rol->nombre) }}</option>
                @endforeach
            </select>
        </div>


    <button type="submit" class="btn btn-primary btn-block">Registrar</button>
</form>
@endsection

@section('auth_footer')
<p class="my-0">
    <a href="{{ route('login') }}">Ya tengo una cuenta</a>
</p>
@endsection
