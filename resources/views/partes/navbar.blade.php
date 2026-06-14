<!--navbar donde se encuentra logo, busqueda e inicio de sesion-->
<div class="container-fluid navbar-custom pt-3 pb-2 border-bottom position-relative" style="z-index: 1020;">
    <div class="row align-items-center px-4 gy-3">
        <!--busqueda--> 
        <div class="col-12 col-md-4 order-2 order-md-1 d-flex justify-content-center justify-content-md-start">
            <div class="search-container">
            <input type="text" class="search-input" placeholder="Buscar...">
            <button class="search-btn">
            <i class="bi bi-search"></i>
            </button>
        </div>
    </div>
    <!--logo-->
        <div class="col-12 col-md-4 order-1 order-md-2 text-center">
            <a href="/">
                <img src="{{ asset('assets/img/logo1.png') }}" alt="The B-Side Logo" width="200" class="logo-glow">
            </a>
        </div>
    <!--inicio de sesion-->
        <div class="col-12 col-md-4 order-3 d-flex justify-content-center justify-content-md-end">
@auth
    @if(auth()->user()->rol->nombre === 'admin')
        <a href="/admin" class="nav-action">Panel Admin</a>
    @else
         <a href="/cliente" class="nav-action">Mi Cuenta</a>
    @endif
    <span class="mx-2 text-secondary">|</span>
    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
        @csrf
    <button type="submit" class="nav-action border-0 bg-transparent p-0"> Cerrar Sesión </button>
    </form>
@else
    <a href="/registro" class="nav-action">Crear Cuenta</a>
    <span class="mx-2 text-secondary">|</span>
    <a href="/login" class="nav-action">Iniciar Sesión</a>
@endauth
        </div>
    </div>
</div>
<!--navbar movil donde está carrito de compra, productos(dropdown), inicio, etc-->
<nav class="navbar navbar-expand-lg navbar-custom py-2 sticky-top">
    <div class="container d-flex justify-content-center">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-4">
                <li class="nav-item">
                    <a class="nav-link nav-custom-link" href="/">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-custom-link" href="#" role="button" data-bs-toggle="dropdown">
                        Productos
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/productos/todos">Ver todos los productos</a>
                        </li>
        
                        <li><hr class="dropdown-divider"></li>

                        @foreach(\App\Models\Categoria::all() as $categoria)
                        <li>
                            <a class="dropdown-item" href="/productos/{{ strtolower($categoria->nombre) }}">
                                {{ $categoria->nombre }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-custom-link" href="/contacto">Contacto</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-custom-link" href="/quienessomos">Quiénes somos</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link nav-custom-link" href="/carrito">
                        <i class="bi bi-cart-dash-fill"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>