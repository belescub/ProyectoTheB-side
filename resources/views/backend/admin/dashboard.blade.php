@extends('plantilla')

@section('contenido')
<div class="container my-5 text-white">
    {{-- 1. HEADER: flex-column en móviles para que no se encime el título con el badge --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-2 border-bottom gap-3" style="border-color: rgba(255, 255, 255, 0.1) !important;">
        <div>
            <h1 class="fw-bold" style="color: #77c040; text-shadow: 0 0 10px rgba(119, 192, 64, 0.3);">
                Panel de Administración
            </h1>
             <p class="mb-0 text-white">Bienvenido de nuevo, <span class="fw-bold">{{ auth()->user()->nombre ?? 'Administrador' }}</span>. Aquí está el resumen de hoy.</p>
        </div>
        <div>
            <span class="badge p-2" style="background-color: rgba(119, 192, 64, 0.2); color: #77c040; border: 1px solid rgba(119, 192, 64, 0.4);">
                <i class="fas fa-user-shield me-1"></i> Rol: Admin
            </span>
        </div>
    </div>

    {{-- Tarjetas de resumen --}}
    <div class="row g-4 mb-5">
        @php
            $tarjetas = [
                ['titulo' => 'Productos', 'valor' => $totalProductos, 'icono' => 'fa-box'],
                ['titulo' => 'Ventas Totales', 'valor' => $totalVentas, 'icono' => 'fa-shopping-cart'],
                ['titulo' => 'Categorías', 'valor' => $totalCategorias, 'icono' => 'fa-tags'],
                ['titulo' => 'Clientes', 'valor' => $totalClientes, 'icono' => 'fa-users'],
            ];
        @endphp

        @foreach($tarjetas as $tarjeta)
        {{-- 2. GRILLAS: col-12 para celu, col-sm-6 para tablet, col-md-3 para PC --}}
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3" style="background-color: rgba(119, 192, 64, 0.1); color: #77c040;">
                        <i class="fas {{ $tarjeta['icono'] }} fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-light mb-1 text-uppercase font-monospace" style="font-size: 0.8rem; letter-spacing: 1px;">{{ $tarjeta['titulo'] }}</h6>
                        <h3 class="card-text fw-bold mb-0 text-white">{{ $tarjeta['valor'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Acciones y Tabla --}}
    <div class="row g-4">
        {{-- 3. SIDEBAR: col-12 como base para móviles --}}
        <div class="col-12 col-lg-4">
            <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.4); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                <div class="card-header border-0 bg-transparent pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-white">Acciones Rápidas</h5>
                </div>
                <div class="card-body px-4">
                    <div class="d-grid gap-3">
                        <a href="?nuevo=1" class="btn d-flex align-items-center justify-content-between p-3 text-start transition" style="background-color: rgba(119, 192, 64, 0.1); color: #ffffff; border: 1px solid rgba(119, 192, 64, 0.3); border-radius: 8px;">
                            <span><i class="fas fa-plus-circle me-2" style="color: #023d0c;"></i> Agregar Nuevo Producto</span>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 0.8rem;"></i>
                        </a>
                        <a href="?inventario=1" class="btn d-flex align-items-center justify-content-between p-3 text-start transition" style="background-color: rgba(255, 255, 255, 0.03); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px;">
                            <span><i class="fas fa-boxes me-2" style="color: #023d0c;"></i> Administrar Inventario</span>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 0.8rem;"></i>
                        </a>
                        <a href="?ventas=1" class="btn d-flex align-items-center justify-content-between p-3 text-start transition" style="background-color: rgba(255, 255, 255, 0.03); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px;">
                            <span><i class="fas fa-receipt me-2" style="color: #023d0c;"></i> Historial de Ventas</span>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 0.8rem;"></i>
                        </a>
                        <a href="?clientes=1" class="btn d-flex align-items-center justify-content-between p-3 text-start transition" style="background-color: rgba(255, 255, 255, 0.03); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px;">
                            <span><i class="fas fa-receipt me-2" style="color: #023d0c;"></i> Historial de Clientes</span>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 0.8rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: DINÁMICA (FORMULARIO O TABLA) --}}
        <div class="col-12 col-lg-8">
            
            @if(request()->has('nuevo'))
                {{-- MODO FORMULARIO NUEVO PRODUCTO --}}
                <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.4); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                    {{-- 4. FLEX-WRAP: Para que el botón de volver baje si no hay espacio --}}
                    <div class="card-header border-0 bg-transparent d-flex flex-wrap justify-content-between align-items-center gap-2 pt-4 px-4">
                        <h5 class="fw-bold mb-0" style="color: #77c040;">Registrar Nuevo Producto</h5>
                        <a href="?" class="text-decoration-none font-monospace text-light" style="font-size: 0.85rem;"><i class="fas fa-arrow-left me-1"></i> Volver a la tabla</a>
                    </div>
                    <div class="card-body px-4">
                        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">NOMBRE DEL PRODUCTO</label>
                                <input type="text" name="nombre" class="form-control text-white" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">DESCRIPCIÓN</label>
                                <textarea name="descripcion" class="form-control text-white" rows="2" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);"></textarea>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">PRECIO ($)</label>
                                    <input type="number" name="precio" step="0.01" class="form-control text-white" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">CANTIDAD EN STOCK</label>
                                    <input type="number" name="stock" class="form-control text-white" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">CATEGORÍA</label>
                                <select name="categoria_id" id="categoria_select" class="form-select text-white" style="background-color: rgba(20, 20, 20, 0.9); border: 1px solid rgba(255, 255, 255, 0.1);" required onchange="mostrarNuevaCategoria()">
                                    <option value="" disabled selected style="color: #aaa;">Seleccioná una categoría...</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" style="background-color: #111;">{{ $categoria->nombre }}</option>
                                    @endforeach
                                    <option value="nueva" style="background-color: #1a3a1a; color: #77c040; font-weight: bold;">+ Añadir nueva categoría...</option>
                                </select>
                            </div>
                            <div class="mb-3 d-none p-3 rounded" id="div_nueva_categoria" style="background-color: rgba(119, 192, 64, 0.05); border: 1px dashed rgba(119, 192, 64, 0.4);">
                                <label class="form-label font-monospace fw-bold" style="font-size: 0.8rem; color: #77c040;">NOMBRE DE LA NUEVA CATEGORÍA</label>
                                <input type="text" name="nueva_categoria_nombre" id="input_nueva_categoria" class="form-control text-white" style="background-color: rgba(10, 10, 10, 0.8); border: 1px solid rgba(119, 192, 64, 0.3);" placeholder="Ej: Indumentaria de Verano">
                            </div>

                            <script>
                                function mostrarNuevaCategoria() {
                                    var select = document.getElementById('categoria_select');
                                    var divNueva = document.getElementById('div_nueva_categoria');
                                    var inputNueva = document.getElementById('input_nueva_categoria');

                                    if (select.value === 'nueva') {
                                        divNueva.classList.remove('d-none');
                                        inputNueva.required = true;
                                    } else {
                                        divNueva.classList.add('d-none');
                                        inputNueva.required = false;
                                        inputNueva.value = ''; 
                                    }
                                }
                            </script>

                            <div class="mb-4">
                                <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">IMAGEN DEL PRODUCTO</label>
                                <input type="file" name="url_imagen" class="form-control text-white" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn fw-bold text-white px-4" style="background-color: #77c040; box-shadow: 0 0 10px rgba(119, 192, 64, 0.3);">
                                    <i class="fas fa-save me-2"></i>Guardar Producto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @elseif(request()->has('clientes'))
                {{-- HISTORIAL DE CLIENTES --}}
                <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.4); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <div class="card-header border-0 bg-transparent d-flex flex-wrap justify-content-between align-items-center gap-2 pt-4 px-4">
                        <h5 class="fw-bold mb-0" style="color: #77c040;">Historial de Clientes</h5>
                        <a href="?" class="text-decoration-none font-monospace text-light"><i class="fas fa-arrow-left me-1"></i> Volver</a>
                    </div>
                    <div class="card-body px-4">
                        <p>Total de clientes: <strong>{{ $usuarios->count() }}</strong></p>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover text-white">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios as $usuario)
                                        <tr>
                                            <td>{{ $usuario->id }}</td>
                                            <td>{{ $usuario->nombre }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>{{ $usuario->rol->nombre }}</td>
                                            <td>
                                                @if($usuario->deleted_at)
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @else
                                                    <span class="badge bg-success">Activo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.usuario.baja', $usuario->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-danger btn-sm mb-1 mb-md-0">Dar de baja</button>
                                                </form>
                                                @if($usuario->rol != 'admin')
                                                    <form action="{{ route('admin.usuario.hacerAdmin', $usuario->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-success btn-sm">Hacer Admin</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @elseif(request()->has('ventas'))
                {{-- TABLA DE VENTAS --}}
                <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.4); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <div class="card-header border-0 bg-transparent d-flex flex-wrap justify-content-between align-items-center gap-2 pt-4 px-4">
                        <h5 class="fw-bold mb-0" style="color: #77c040;">Historial de Ventas</h5>
                        <a href="?" class="text-decoration-none font-monospace text-light"><i class="fas fa-arrow-left me-1"></i> Volver</a>
                    </div>
                    <div class="card-body px-4">
                        <form method="GET" action="">
                            <input type="hidden" name="ventas" value="1">
                            <div class="row g-2 align-items-end mb-3">
                                <div class="col-12 col-md-4">
                                    <label class="form-label text-light font-monospace" style="font-size: 0.75rem;">BÚSQUEDA</label>
                                    <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control text-white" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" placeholder="Ej: Taylor Swift, CD, Sabrina...">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label text-light font-monospace" style="font-size: 0.75rem;">FILTRAR POR</label>
                                    <select name="criterio" class="form-select text-white" style="background-color: rgba(20, 20, 20, 0.9); border: 1px solid rgba(255, 255, 255, 0.1);">
                                        <option value="producto" {{ request('criterio') == 'producto' ? 'selected' : '' }} style="background-color: #111;">Producto / Artista</option>
                                        <option value="cliente" {{ request('criterio') == 'cliente' ? 'selected' : '' }} style="background-color: #111;">Cliente</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label text-light font-monospace" style="font-size: 0.75rem;">FECHA</label>
                                    <select name="fecha" class="form-select text-white" style="background-color: rgba(20, 20, 20, 0.9); border: 1px solid rgba(255, 255, 255, 0.1);">
                                        <option value="todas" {{ request('fecha') == 'todas' ? 'selected' : '' }} style="background-color: #111;">Todas las fechas</option>
                                        <option value="hoy" {{ request('fecha') == 'hoy' ? 'selected' : '' }} style="background-color: #111;">Ventas de hoy</option>
                                        <option value="semana" {{ request('fecha') == 'semana' ? 'selected' : '' }} style="background-color: #111;">Esta semana</option>
                                        <option value="mes" {{ request('fecha') == 'mes' ? 'selected' : '' }} style="background-color: #111;">Hace un mes</option>
                                        <option value="anio" {{ request('fecha') == 'anio' ? 'selected' : '' }} style="background-color: #111;">Hace un año</option>
                                        <option value="mas_anio" {{ request('fecha') == 'mas_anio' ? 'selected' : '' }} style="background-color: #111;">Hace más de un año</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn w-100 fw-bold text-uppercase" style="background-color: #64c23a; color: #111; border-radius: 20px; font-size: 0.85rem; padding: 8px 12px; border: none;">Filtrar</button>
                                    <a href="{{ url('/admin?ventas=1') }}" class="btn w-100 fw-bold text-uppercase d-flex align-items-center justify-content-center" style="background-color: #4a4a4a; color: #fff; border-radius: 20px; font-size: 0.85rem; padding: 8px 12px; text-decoration: none; border: none;">Ver Todo</a>
                                </div>
                            </div>
                        </form>

                        <p>Total ventas: {{ $ventas->count() }}</p>

                        {{-- 5. ACÁ ESTABA EL ERROR: Agregado div.table-responsive --}}
                        <div class="table-responsive">
                            <table class="table table-dark table-hover text-white">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Productos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ventas as $venta)
                                        <tr>
                                            <td>{{ $venta->id }}</td>
                                            <td>{{ $venta->usuario->nombre ?? 'Desconocido' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}</td>
                                            <td>${{ number_format($venta->total, 2) }}</td>
                                            <td>
                                                <ul class="mb-0">
                                                    @foreach($venta->venta_detalles as $detalle)
                                                        <li>{{ $detalle->producto->nombre }} - Cantidad: {{ $detalle->cantidad }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No se encontraron ventas con estos filtros.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @elseif(request()->has('inventario'))
                {{-- ADMINISTRAR INVENTARIO --}}
                <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.4); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2 pt-4 px-4">
                        <h5 class="fw-bold mb-0" style="color: #77c040;">Administrar Inventario</h5>
                        <a href="?" class="text-decoration-none font-monospace text-light"><i class="fas fa-arrow-left me-1"></i> Volver</a>
                    </div>
                    <div class="card-body px-4">
                        {{-- 6. OTRA TABLA REPARADA --}}
                        <div class="table-responsive">
                            <table class="table table-dark table-hover text-white" style="--bs-table-bg: transparent;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Stock</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productos as $producto)
                                        <tr>
                                            <td>{{ $producto->id }}</td>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>{{ $producto->categoria->nombre }}</td>
                                            <td>{{ $producto->stock }}</td>
                                            <td>${{ $producto->precio }}</td>
                                            <td>
                                                @if($producto->stock > 0)
                                                    <span class="badge bg-success">Disponible</span>
                                                @else
                                                    <span class="badge bg-danger">Sin stock</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="?editar={{ $producto->id }}" class="btn btn-warning btn-sm mb-1 mb-md-0">Editar</a>
                                                <form action="{{ route('admin.producto.eliminar', $producto->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @elseif(request()->has('editar') && $productoEditar)
                {{-- EDICIÓN DE PRODUCTO --}}
                <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.4); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                    <div class="card-header border-0 bg-transparent d-flex flex-wrap justify-content-between align-items-center gap-2 pt-4 px-4">
                        <h5 class="fw-bold mb-0" style="color: #77c040;">Editar Producto: {{ $productoEditar->nombre }}</h5>
                        <a href="?inventario=1" class="text-decoration-none font-monospace text-light" style="font-size: 0.85rem;"><i class="fas fa-arrow-left me-1"></i> Cancelar y volver</a>
                    </div>
                    <div class="card-body px-4">
                        <form action="{{ route('admin.producto.update', $productoEditar->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">NOMBRE DEL PRODUCTO</label>
                                <input type="text" name="nombre" value="{{ $productoEditar->nombre }}" class="form-control text-white" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">DESCRIPCIÓN</label>
                                <textarea name="descripcion" class="form-control text-white" rows="2" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">{{ $productoEditar->descripcion }}</textarea>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">PRECIO ($)</label>
                                    <input type="number" name="precio" value="{{ $productoEditar->precio }}" step="0.01" class="form-control text-white" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">CANTIDAD EN STOCK</label>
                                    <input type="number" name="stock" value="{{ $productoEditar->stock }}" class="form-control text-white" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">CATEGORÍA</label>
                                <select name="categoria_id" class="form-select text-white" style="background-color: rgba(20, 20, 20, 0.9); border: 1px solid rgba(255, 255, 255, 0.1);" required>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ $productoEditar->categoria_id == $categoria->id ? 'selected' : '' }} style="background-color: #111;">
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">IMAGEN DEL PRODUCTO (Opcional)</label>
                                <input type="file" name="url_imagen" class="form-control text-white" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn fw-bold text-white px-4" style="background-color: #77c040; box-shadow: 0 0 10px rgba(119, 192, 64, 0.3);">
                                    <i class="fas fa-save me-2"></i>Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                {{-- VISTA POR DEFECTO (ÚLTIMOS PRODUCTOS) --}}
                <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.4); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                    <div class="card-header border-0 bg-transparent d-flex flex-wrap justify-content-between align-items-center gap-2 pt-4 px-4">
                        <h5 class="fw-bold mb-0 text-white">Últimos Productos Agregados</h5>
                        <a href="/productos" class="text-decoration-none font-monospace" style="color: #77c040; font-size: 0.85rem;">Ver catálogo &rarr;</a>
                    </div>
                    <div class="card-body px-4">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle mb-0 text-white" style="--bs-table-bg: transparent;">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-light font-monospace" style="font-size: 0.8rem;">ID</th>
                                        <th scope="col" class="text-light font-monospace" style="font-size: 0.8rem;">PRODUCTO</th>
                                        <th scope="col" class="text-light font-monospace" style="font-size: 0.8rem;">CATEGORÍA</th>
                                        <th scope="col" class="text-light font-monospace" style="font-size: 0.8rem;">PRECIO</th>
                                        <th scope="col" class="text-light font-monospace" style="font-size: 0.8rem; text-align: center;">ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productos as $producto)
                                        <tr style="border-color: rgba(255, 255, 255, 0.05);">
                                            <td class="font-monospace text-white">#{{ $producto->id }}</td>
                                            <td class="fw-semibold text-white">{{ $producto->nombre }}</td>
                                            <td><span class="badge bg-light text-dark">{{ $producto->categoria->nombre ?? 'N/A' }}</span></td>
                                            <td class="text-white fw-bold">${{ number_format($producto->precio, 2) }}</td>
                                            <td class="text-center">...</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center">Sin productos</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection