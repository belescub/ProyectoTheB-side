@extends('plantilla')
@section('contenido')
<div class="cuenta d-flex justify-content-center align-items-center cuenta">
<div class="card-box">
    <h2 class="text-center mb-4"> Iniciar sesión </h2>
    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Tu correo electrónico" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4" style="font-size: 0.9rem;">
                <label class="text-white d-flex align-items-center mb-0">
                    <input type="checkbox" class="me-2" style="accent-color: #77c040;"> Recordarme
                </label>
                <a href="#" style="color: #77c040; text-decoration: none; font-weight: 600;">¿Olvidaste tu contraseña?</a>
            </div>
        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
    </form>

    <p class="mt-3">¿No tienes una cuenta? <a href="/registro">Regístrate</a></p>
</div>
@endsection