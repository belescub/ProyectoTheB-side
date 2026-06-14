@extends('plantilla')
@section('contenido')

<div class="container my-5 text-white">
    <div class="text-center mb-5">
        <h2 style="color: #77c040;">¡Hola, {{ auth()->user()->nombre }}!</h2>
        <p class="text-secondary">Bienvenido a tu cuenta. Desde aquí puedes gestionar toda tu actividad.</p>
    </div>

    <div class="row g-4 justify-content-center">
        
        {{-- Tarjeta 1: Mis Compras --}}
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card h-100 bg-dark border-secondary text-center p-3 hover-card">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="mb-3">
                        <i class="bi bi-bag-check-fill text-success" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Mis Compras</h5>
                    <p class="card-text text-secondary small">Revisa tu historial completo de pedidos, productos adquiridos y totales.</p>
                    <a href="{{ route('compras.historial') }}" class="btn btn-outline-success btn-sm w-100 mt-3">Ver historial</a>
                </div>
            </div>
        </div>

        {{-- Tarjeta 2: Factura Detalle --}}
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card h-100 bg-dark border-secondary text-center p-3 hover-card">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-text-fill text-info" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Detalle de Facturas</h5>
                    <p class="card-text text-secondary small">Visualiza y descarga los comprobantes de tus compras.</p>
                    <a href="{{ route('facturas.index') }}" class="btn btn-outline-info btn-sm w-100 mt-3">Ver comprobantes</a>
                </div>
            </div>
        </div>

        {{-- Tarjeta 3: Mi Carrito --}}
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card h-100 bg-dark border-secondary text-center p-3 hover-card">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="mb-3">
                        <i class="bi bi-cart-fill text-warning" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Mi Carrito</h5>
                    <p class="card-text text-secondary small">¿Dejaste algo pendiente? Accede directamente a tu bolsa de compras para finalizar.</p>
                    <a href="{{ url('/carrito') }}" class="btn btn-outline-warning btn-sm w-100 mt-3">Ir al carrito</a>
                </div>
            </div>
        </div>

        {{-- Tarjeta 4: Mis Consultas --}}
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card h-100 bg-dark border-secondary text-center p-3 hover-card">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="mb-3">
                        <i class="bi bi-chat-dots-fill text-danger" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Mis Consultas</h5>
                    <p class="card-text text-secondary small">Sigue el estado de tus dudas y revisa las respuestas enviadas por los administradores.</p>
                    <a href="{{ route('cliente.consultas') }}" class="btn btn-outline-danger btn-sm w-100 mt-3">Ver respuestas</a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, border-color 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        border-color: #77c040 !important;
    }
</style>

@endsection