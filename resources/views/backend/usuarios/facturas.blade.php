@extends('plantilla')
@section('contenido')

<div class="container my-5 text-white">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #77c040;">Mis Comprobantes y Facturas</h2>
        <a href="{{ route('cliente') }}" class="btn btn-sm btn-outline-secondary">Volver al Panel</a>
    </div>

    <div class="row g-3">
        @forelse($facturas as $factura)
            <div class="col-12 col-md-6">
                <div class="bg-dark p-3 rounded border border-secondary d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 text-info">Factura Electrónica #{{ $factura->id }}</h6>
                        <small class="text-secondary">Emitida el {{ \Carbon\Carbon::parse($factura->fecha_venta)->format('d/m/Y') }}</small>
                        <p class="mb-0 mt-2 fw-bold">Total: <span class="text-success">${{ number_format($factura->total, 2, '.', ',') }}</span></p>
                    </div>
                    <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-sm btn-outline-light">
                        Visualizar y Descargar
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5 bg-dark rounded border border-secondary">
                No hay comprobantes disponibles para mostrar.
            </div>
        @endforelse
    </div>
</div>

@endsection