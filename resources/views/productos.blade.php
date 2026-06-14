@extends('plantilla')
@section('contenido')

<div class="row catalogo-row">
    @forelse($productos as $producto)
        <div class="col-md-4 mb-4">
            <div class="card h-100" style="background-color: rgba(10, 10, 10, 0.6); border: 1px solid #77c040;">
                <img src="{{asset('storage/' . ($producto->url_imagen)) }}" class="card-img-top" alt="{{ $producto->nombre }}">

                <div class="card-body text-white">
                    <h5 class="card-title" style="color: #77c040;">{{ $producto->nombre }}</h5>
                    <p class="card-text">{{ $producto->descripcion }}</p>
                    <p class="card-text fw-bold">Precio: ${{ number_format($producto->precio, 2, ',', '.') }}</p>
                    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="number" name="cantidad" class="form-control" value="1" min="1" max="{{ $producto->stock }}">
                            <form action="/carrito/agregar" method="POST">
                                @csrf
                                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                <input type="hidden" name="cantidad" value="1">
                            <button class="btn btn-success" type="submit">Agregar al carrito</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-white mt-5">
            <h4 style="color: #77c040;">No hay productos disponibles en esta categoría.</h4>
        </div>
    @endforelse
</div>
@endsection