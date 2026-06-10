@extends('plantilla')
@section('contenido')
<table class="table table-dark">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th></th>
        </tr>
    </thead>

    <tbody>

    @foreach($items as $item)

        <tr>

            <td>{{ $item->producto->nombre }}</td>

            <td>{{ $item->cantidad }}</td>

            <td>${{ $item->precio_unitario }}</td>

            <td>${{ $item->subtotal }}</td>

            <td>

                <form
                    action="{{ route('carrito.eliminar', $item->id) }}"
                    method="POST">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger">
                        Eliminar
                    </button>

                </form>

            </td>

        </tr>

    @endforeach

    </tbody>

</table>

<h3>Total: ${{ $carrito->total }}</h3>

<form
    action="{{ route('carrito.confirmar') }}"
    method="POST">

    @csrf

    <button class="btn btn-success">
        Confirmar compra
    </button>

</form>
@endsection