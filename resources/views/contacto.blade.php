@extends('plantilla')
@section('contenido')

<div class="contacto">
    {{-- Si es un usuario autenticado, ve el formulario normalmente --}}
    @auth
    <form action="{{ url('/contacto') }}" method="POST">
        @csrf
        <h2>Contacto</h2>

        <div class="input-group">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="nombre" placeholder="Nombre" required>

            <label for="phone">Teléfono</label>
            <input type="text" id="phone" name="telefono" placeholder="Telefono">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <label for="message">Mensaje</label>
            <textarea id="message" name="mensaje" rows="5" placeholder="Mensaje" required></textarea>

            <div class="form-text">
                <a href="/privacidad">Política de privacidad</a>
                <a href="/terminosdeuso">Términos y condiciones</a>
            </div>

            <input class="btn" type="submit" value="Enviar">
        </div>
    </form>
    @endauth
</div>

{{-- Script de SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Alerta 1: ¡Consulta enviada con éxito! --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Consulta enviada!',
        text: "{{ session('success') }}",
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#77c040' {{-- Tu color verde personalizado si querés --}}
    });
</script>
@endif

{{-- Alerta 2: El usuario no está logueado (Invitado) --}}
@guest
<script>
    Swal.fire({
        icon: 'warning',
        title: '¡Atención!',
        text: 'Debes iniciar sesión para poder realizar una consulta.',
        confirmButtonText: 'Iniciar Sesión',
        confirmButtonColor: '#77c040',
        allowOutsideClick: false, {{-- Evita que cierren la alerta haciendo clic afuera --}}
        allowEscapeKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            {{-- Redirección automática al login al presionar el botón --}}
            window.location.href = "{{ url('/login') }}";
        }
    });
</script>
@endguest

@endsection