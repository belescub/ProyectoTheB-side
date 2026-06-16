@extends('plantilla')
@section('contenido')

{{-- El título del buscador solo se muestra si hay una consulta activa --}}
@if(isset($query))
    <h3 class="text-white mb-4" style="color: #77c040;">Resultados para: "{{ $query }}"</h3>
@endif

<div class="row catalogo-row">
    @forelse($productos as $producto)
        <div class="col-md-4 mb-4">
            {{-- Añadimos position-relative para que el cartel de "SIN STOCK" flote bien --}}
            <div class="card h-100 position-relative" style="background-color: rgba(10, 10, 10, 0.6); border: 1px solid #77c040;">
                
                {{-- 1. Cartel flotante ROJO si no hay stock --}}
                @if($producto->stock <= 0)
                    <span class="badge bg-danger position-absolute top-0 start-0 m-3 py-1 px-2.5" 
                          style="font-size: 0.85rem; letter-spacing: 0.5px; z-index: 10; border-radius: 5px;">
                        SIN STOCK
                    </span>
                @endif

                {{-- 2. Imagen con filtro gris y opacidad si el stock es 0 --}}
                <img src="{{ asset('storage/' . ($producto->url_imagen)) }}" 
                     class="card-img-top" 
                     alt="{{ $producto->nombre }}"
                     style="transition: all 0.3s ease; {{ $producto->stock <= 0 ? 'filter: grayscale(100%); opacity: 0.35;' : '' }}">

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
                        {{-- 3. Si es cliente, evaluamos si hay stock disponible --}}
                        @if($producto->stock > 0)
                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                                @csrf
                                <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}" class="form-control mb-2">
                                
                                <button type="submit" class="catalog-cart-icon bg-transparent border-0">
                                    <i class="bi bi-cart-dash-fill"></i>
                                </button>
                            </form>
                        @else
                            {{-- Si no hay stock, ocultamos el formulario y mostramos aviso discreto --}}
                            <div class="text-center mt-3 py-2" style="background-color: rgba(255,255,255,0.05); color: #888; border-radius: 5px; font-size: 0.9rem; border: 1px dashed #444;">
                                <i class="bi bi-exclamation-circle me-1"></i> temporalmente agotado
                            </div>
                        @endif
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