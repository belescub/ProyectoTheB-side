@extends('plantilla')
@section('contenido')
<div class="cuenta d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="card-box w-100 mx-3">
        <h2 class="text-center mb-4">Iniciar sesión</h2>
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
            
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2" style="font-size: 0.9rem;">
                <label class="text-white d-flex align-items-center mb-0">
                    <input type="checkbox" class="me-2" style="accent-color: #77c040;"> Recordarme
                </label>
                <a href="#" style="color: #77c040; text-decoration: none; font-weight: 600;">¿Olvidaste tu contraseña?</a>
            </div>
            
            <button type="submit" class="btn w-100 py-2">Iniciar sesión</button>
        </form>

        <div class="form-text mt-4 d-flex justify-content-center">
            <p class="mb-0 text-white">¿No tienes una cuenta? <a href="/registro" style="color: #77c040; text-decoration: none; font-weight: 600;">Regístrate</a></p>
        </div>
    </div>
</div>
@endsection