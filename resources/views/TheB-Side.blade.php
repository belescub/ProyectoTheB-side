@extends('plantilla')
@section('fullwidth')
<div class="TheB-Side">
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('assets/img/imagen1.jpg') }}" alt="First slide" style="height: 60vh; object-fit: cover; filter: brightness(0.4);">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('assets/img/imagen2.jpg') }}" alt="Second slide" style="height: 60vh; object-fit: cover; filter: brightness(0.4);">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('assets/img/imagen3.jpg') }}" alt="Third slide" style="height: 60vh; object-fit: cover; filter: brightness(0.4);">
            </div>
        </div> <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
@endsection
@section('contenido')
<!--CARDS-->
<div class="container mt-5">
    <div class="row g-4">
         <div class="col-md-4">
            <div class="card custom-card text-white border-0 h-100">
                <img src="{{ asset('assets/img/img-4.jpg') }}" class="card-img">
                <div class="card-img-overlay overlay-centrado">
                    <h3 class="card-title text-center">CDS</h3>
                    <a href="/productos/cds" class="stretched-link"></a> 
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card custom-card text-white border-0 h-100">
                <img src="{{ asset('assets/img/img-5.jpg') }}" class="card-img">
                <div class="card-img-overlay overlay-centrado">
                    <h3 class="card-title text-center">VINILOS</h3>
                    <a href="/productos/vinilos" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card custom-card text-white border-0 h-100">
                <img src="{{ asset('assets/img/img-6.jpg') }}" class="card-img">
                <div class="card-img-overlay overlay-centrado">
                    <h3 class="card-title text-center">REPRODUCTORES</h3>
                    <a href="/productos/reproductores" class="stretched-link"></a>
                </div>
            </div>
        </div>

    </div>
</div>
<!--PRODUCTOS-->

<div class="container my-5 pt-3"> 
    <div class="row catalogo-row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        
@foreach($productosRandom as $producto)
<div class="col">
    <div class="catalog-item">
        
        {{-- INICIO DE LA IMAGEN INTELIGENTE --}}
        @php
            $rutaEnAssets = public_path('assets/img/' . $producto->url_imagen);
        @endphp

        @if($producto->url_imagen && file_exists($rutaEnAssets))
            <img src="{{ asset('assets/img/' . $producto->url_imagen) }}" class="card-img-fluid catalog-img" alt="{{ $producto->nombre }}">
        @else
            <img src="{{ asset('storage/' . $producto->url_imagen) }}" class="card-img-fluid catalog-img" alt="{{ $producto->nombre }}">
        @endif
        {{-- FIN DE LA IMAGEN INTELIGENTE --}}

        <div class="catalog-info mt-2">
            <h5 class="card-title">{{ $producto->nombre }}</h5>
            
            <p class="product-price mb-1">${{ number_format($producto->precio, 0, ',', '.') }}</p>
            
            <a href="/carrito" class="catalog-cart-icon">
                <i class="bi bi-cart-dash-fill"></i>
            </a>
        </div>
    </div>
</div>
@endforeach

    </div>
</div>
@endsection