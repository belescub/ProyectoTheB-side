@extends('plantilla')
@section('contenido')
<div class="cuenta d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="card-box w-100 mx-3">
        <h2 class="text-center mb-4">Crear cuenta</h2>
        <form action="{{ url('/registro') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nombre Completo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="nombre" class="form-control" placeholder="Tu nombre completo" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="ejemplo@gmail.com" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Confirmar Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirma tu contraseña" required>
                </div>
            </div>
            
            <button type="submit" class="btn w-100 py-2">Registrarse</button>
        </form>

        <div class="form-text mt-4 d-flex justify-content-center">
            <p class="mb-0 text-white">¿Ya tienes una cuenta? <a href="/login" style="color: #77c040; text-decoration: none; font-weight: 600;">Iniciar sesión</a></p>
        </div>
    </div>
</div>
@endsection