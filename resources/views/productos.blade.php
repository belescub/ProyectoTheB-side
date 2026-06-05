@extends('plantilla')
@section('contenido')

<div class="row catalogo-row">
    @forelse($productos as $producto)
        <div class="col-md-4 mb-4">
            <div class="card h-100" style="background-color: rgba(10, 10, 10, 0.6); border: 1px solid #77c040;">
                <img src="{{ $producto->url_imagen ?? asset('img/default.png') }}" class="card-img-top" alt="{{ $producto->nombre }}">
                
                <div class="card-body text-white">
                    <h5 class="card-title" style="color: #77c040;">{{ $producto->nombre }}</h5>
                    <p class="card-text">{{ $producto->descripcion }}</p>
                    <p class="card-text fw-bold">Precio: ${{ number_format($producto->precio, 2, ',', '.') }}</p>
                    
                    <a href="#" class="btn btn-outline-success">Añadir al carrito</a>
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