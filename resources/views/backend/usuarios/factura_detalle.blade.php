@extends('plantilla')
@section('contenido')

<div class="container my-5 text-white" id="seccion-factura">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <h2 style="color: #77c040;">Detalle del Comprobante</h2>
        <div>
            <button onclick="window.print();" class="btn btn-success btn-sm me-2">
                <i class="bi bi-printer-fill"></i> Descargar / Imprimir
            </button>
            <a href="{{ route('facturas.index') }}" class="btn btn-sm btn-outline-secondary">Volver</a>
        </div>
    </div>

    <div class="bg-white text-dark p-5 rounded shadow invoice-box">
        <div class="row mb-4">
            <div class="col-6">
                <h3 class="fw-bold mb-0">THE B-SIDE</h3>
                <p class="text-muted small mb-0">Tienda Oficial de Música & Merch</p>
            </div>
            <div class="col-6 text-end">
                <h4 class="text-muted">COMPROBANTE</h4>
                <p class="mb-0"><strong>Nro de Venta:</strong> #0001-0000{{ $compra->id }}</p>
                <p class="mb-0"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($compra->fecha_venta)->format('d/m/Y') }}</p>
            </div>
        </div>

        <hr class="border-secondary">

        <div class="row mb-4">
            <div class="col-6">
                <h6 class="fw-bold text-muted">DATOS DEL CLIENTE:</h6>
                <p class="mb-1"><strong>Nombre:</strong> {{ auth()->user()->nombre }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ auth()->user()->email }}</p>
            </div>
            <div class="col-6 text-end">
                <h6 class="fw-bold text-muted">ESTADO DEL PAGO:</h6>
                <span class="badge text-capitalize {{ $compra->estado == 'pagado' ? 'bg-success text-white' : 'bg-warning text-dark' }} px-3 py-2">
                    {{ $compra->estado }}
                </span>
            </div>
        </div>

        <table class="table align-middle mt-4">
            <thead class="table-light">
                <tr>
                    <th>Descripción del Producto</th>
                    <th class="text-center">Cant.</th>
                    <th class="text-end">Precio Unit.</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                {{-- Iteración real sobre la relación del modelo Venta_cabecera --}}
                @foreach($compra->venta_detalles as $detalle)
                <tr>
                    {{-- Acceso al nombre del producto relacionado desde el detalle --}}
                    <td>{{ $detalle->producto->nombre }}</td> 
                    <td class="text-center">{{ $detalle->cantidad }}</td>
                    <td class="text-end">${{ number_format($detalle->precio_unitario, 2, '.', ',') }}</td>
                    <td class="text-end">${{ number_format($detalle->subtotal, 2, '.', ',') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td class="text-end fw-bold fs-5">TOTAL:</td>
                    <td class="text-end fw-bold fs-5 text-success">${{ number_format($compra->total, 2, '.', ',') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="text-center mt-5 pt-4 border-top text-muted small">
            Gracias por tu compra en The B-Side. Si tienes alguna consulta, recuerda usar nuestro formulario de contacto.
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #seccion-factura, #seccion-factura * {
            visibility: visible;
        }
        #seccion-factura {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>

@endsection