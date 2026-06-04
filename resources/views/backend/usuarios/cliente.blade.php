@extends('plantilla')
@section('contenido')
    <h1> Bienvenido a la sección de clientes </h1>
    <!--CARDS-->
<div class="container mt-5">
    <div class="row g-4">
         <div class="col-md-4">
            <div class="card custom-card text-white border-0 h-100">
                <img src="{{ asset('assets/img/img-4.jpg') }}" class="card-img">
                <div class="card-img-overlay overlay-centrado">
                    <h3 class="card-title text-center">Historial de compras</h3>
                    <a href="/historial-compras" class="stretched-link"></a> 
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card custom-card text-white border-0 h-100">
                <img src="{{ asset('assets/img/img-5.jpg') }}" class="card-img">
                <div class="card-img-overlay overlay-centrado">
                    <h3 class="card-title text-center">Carrito</h3>
                    <a href="/carrito" class="stretched-link"></a>
                </div>
            </div>
        </div>

@endsection