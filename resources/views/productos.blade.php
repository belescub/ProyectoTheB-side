@extends('plantilla')
@section('contenido')

{{-- El título del buscador solo se muestra si hay una consulta activa --}}
@if(isset($query))
    <h3 class="text-white mb-4" style="color: #77c040;">Resultados para: "{{ $query }}"</h3>
@endif

<div class="row catalogo-row">
    @forelse($productos as $producto)
        @if(isset($query))
            <h3 class="text-white mb-4" style="color: #77c040;">Resultados para: "{{ $query }}"</h3>
        @endif
        <div class="col-md-4 mb-4">
            <div class="card h-100" style="background-color: rgba(10, 10, 10, 0.6); border: 1px solid #77c040;">
                <img src="{{asset('storage/' . ($producto->url_imagen)) }}" class="card-img-top" alt="{{ $producto->nombre }}">

                <div class="card-body text-white">
                    <h5 class="card-title" style="color: #77c040;">{{ $producto->nombre }}</h5>
                    <p class="card-text">{{ $producto->descripcion }}</p>
                    <p class="card-text fw-bold">Precio: ${{ number_format($producto->precio, 2, ',', '.') }}</p>

{{-- Verificamos si el nombre del rol es admin --}}
@if(auth()->check() && auth()->user()->rol && strtolower(auth()->user()->rol->nombre) === 'admin')
    <div class="alert alert-warning p-2 text-center mt-2 mb-0" style="font-size: 0.9rem;">
        Modo Admin: Compras deshabilitadas
    </div>
@else
    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
        @csrf
        <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}" class="form-control mb-2">
        
        <button type="submit" class="catalog-cart-icon bg-transparent border-0">
            <i class="bi bi-cart-dash-fill"></i>
        </button>
    </form>
@endif
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