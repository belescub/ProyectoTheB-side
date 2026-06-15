@extends('plantilla')
@section('contenido')

<div class="container my-5 text-white">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #77c040;">Historial de Mis Compras</h2>
        <a href="{{ route('cliente') }}" class="btn btn-sm btn-outline-secondary">Volver al Panel</a>
    </div>

    <div class="table-responsive bg-dark p-4 rounded border border-secondary">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr class="text-success border-secondary">
                    <th># Compra</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compras as $compra)
                    <tr class="border-secondary">
                        <td class="fw-bold">#{{ $compra->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($compra->fecha_venta)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-opacity-25 text-capitalize {{ $compra->estado == 'pagado' ? 'bg-success text-success' : 'bg-warning text-warning' }}">
                                {{ $compra->estado }}
                            </span>
                        </td>
                        <td class="fw-bold text-success">${{ number_format($compra->total, 2, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="{{ route('facturas.show', $compra->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-file-earmark-text"></i> Ver Factura
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Todavía no has realizado ninguna compra en nuestro sitio.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection