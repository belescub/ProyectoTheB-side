@extends('plantilla')

@section('contenido')
{{-- Aplicamos text-white a todo el contenedor principal para herencia global --}}
<div class="container my-5 text-white">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: rgba(255, 255, 255, 0.1) !important;">
        <div>
            <h1 class="fw-bold" style="color: #77c040; text-shadow: 0 0 10px rgba(119, 192, 64, 0.3);">
                Panel de Administración
            </h1>
            {{-- Cambiado a text-white para mayor visibilidad --}}
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
            /** Definimos un array para simplificar las tarjetas y asegurar el color blanco*/ 
            $tarjetas = [
                ['titulo' => 'Productos', 'valor' => $totalProductos, 'icono' => 'fa-box'],
                ['titulo' => 'Ventas Totales', 'valor' => $totalVentas, 'icono' => 'fa-shopping-cart'],
                ['titulo' => 'Categorías', 'valor' => $totalCategorias, 'icono' => 'fa-tags'],
                ['titulo' => 'Clientes', 'valor' => $totalClientes, 'icono' => 'fa-users'],
            ];
        @endphp

        @foreach($tarjetas as $tarjeta)
        <div class="col-md-3">
            <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3" style="background-color: rgba(119, 192, 64, 0.1); color: #77c040;">
                        <i class="fas {{ $tarjeta['icono'] }} fa-2x"></i>
                    </div>
                    <div>
                        {{-- Cambiado de text-muted a text-light para que sea blanco --}}
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
        <div class="col-lg-4">
            <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.4); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                <div class="card-header border-0 bg-transparent pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-white">Acciones Rápidas</h5>
                </div>
                <div class="card-body px-4">
                    <div class="d-grid gap-3">
                        {{-- Estilos ajustados para que el texto del botón sea blanco puro --}}
                        <a href="?nuevo=1" class="btn d-flex align-items-center justify-content-between p-3 text-start transition" 
                           style="background-color: rgba(119, 192, 64, 0.1); color: #ffffff; border: 1px solid rgba(119, 192, 64, 0.3); border-radius: 8px;">
                            <span><i class="fas fa-plus-circle me-2" style="color: #023d0c;"></i> Agregar Nuevo Producto</span>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 0.8rem;"></i>
                        </a>
                        <a href="#" class="btn d-flex align-items-center justify-content-between p-3 text-start transition" style="background-color: rgba(255, 255, 255, 0.03); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px;">
                            <span><i class="fas fa-boxes me-2" style="color: #023d0c;"></i> Administrar Inventario</span>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 0.8rem;"></i>
                        </a>
                        <a href="#" class="btn d-flex align-items-center justify-content-between p-3 text-start transition" 
                           style="background-color: rgba(255, 255, 255, 0.03); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px;">
                            <span><i class="fas fa-receipt me-2" style="color: #023d0c;"></i> Historial de Ventas</span>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 0.8rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
{{-- COLUMNA DERECHA: DINÁMICA (FORMULARIO O TABLA) --}}
        <div class="col-lg-8">
            @if(request()->has('nuevo'))
                {{-- MODO FORMULARIO --}}
                <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.4); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                    <div class="card-header border-0 bg-transparent d-flex justify-content-between align-items-center pt-4 px-4">
                        <h5 class="fw-bold mb-0" style="color: #77c040;">Registrar Nuevo Producto</h5>
                        {{-- Al hacer click en 'Volver', limpia la URL y regresa a la tabla --}}
                        <a href="?" class="text-decoration-none font-monospace text-light" style="font-size: 0.85rem;"><i class="fas fa-arrow-left me-1"></i> Volver a la tabla</a>
                    </div>
                    <div class="card-body px-4">
                        {{-- IMPORTANTE: enctype para permitir subida de archivos --}}
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
                                <div class="col-md-6">
                                    <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">PRECIO ($)</label>
                                    <input type="number" name="precio" step="0.01" class="form-control text-white" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">CANTIDAD EN STOCK</label>
                                    <input type="number" name="stock" class="form-control text-white" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-light font-monospace" style="font-size: 0.8rem;">CATEGORÍA</label>
                                {{-- Agregamos un ID (categoria_select) y el evento onchange --}}
                                <select name="categoria_id" id="categoria_select" class="form-select text-white" style="background-color: rgba(20, 20, 20, 0.9); border: 1px solid rgba(255, 255, 255, 0.1);" required onchange="mostrarNuevaCategoria()">
                                    <option value="" disabled selected style="color: #aaa;">Seleccioná una categoría...</option>
                                        @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" style="background-color: #111;">{{ $categoria->nombre }}</option>
                                        @endforeach
                                            {{-- NUEVA OPCIÓN --}}
                                            <option value="nueva" style="background-color: #1a3a1a; color: #77c040; font-weight: bold;">+ Añadir nueva categoría...</option>
                                </select>
                            </div>
                                {{-- ESTE ES EL CAMPO QUE SE DESPLIEGA OCULTO POR DEFECTO (d-none) --}}
                                <div class="mb-3 d-none p-3 rounded" id="div_nueva_categoria" style="background-color: rgba(119, 192, 64, 0.05); border: 1px dashed rgba(119, 192, 64, 0.4);">
                                    <label class="form-label font-monospace fw-bold" style="font-size: 0.8rem; color: #77c040;">NOMBRE DE LA NUEVA CATEGORÍA</label>
                                    <input type="text" name="nueva_categoria_nombre" id="input_nueva_categoria" class="form-control text-white" style="background-color: rgba(10, 10, 10, 0.8); border: 1px solid rgba(119, 192, 64, 0.3);" placeholder="Ej: Indumentaria de Verano">
                                </div>
{{-- Mini script para hacer el efecto de despliegue --}}
<script>
    function mostrarNuevaCategoria() {
        var select = document.getElementById('categoria_select');
        var divNueva = document.getElementById('div_nueva_categoria');
        var inputNueva = document.getElementById('input_nueva_categoria');

        if (select.value === 'nueva') {
            // Mostramos el campo y lo hacemos obligatorio
            divNueva.classList.remove('d-none');
            inputNueva.required = true;
        } else {
            // Lo ocultamos, le sacamos lo obligatorio y lo limpiamos
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
            @else
        <div class="col-lg-8">
            <div class="card h-100 text-white" style="background-color: rgba(10, 10, 10, 0.4); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                <div class="card-header border-0 bg-transparent d-flex justify-content-between align-items-center pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-white">Últimos Productos Agregados</h5>
                    <a href="/productos" class="text-decoration-none font-monospace" style="color: #77c040; font-size: 0.85rem;">Ver catálogo &rarr;</a>
                </div>
                <div class="card-body px-4">
                    <div class="table-responsive">
                        {{-- Aseguramos que el texto de la tabla sea blanco --}}
                        <table class="table table-dark table-hover align-middle mb-0 text-white" style="--bs-table-bg: transparent;">
                            <thead>
                                <tr>
                                    {{-- Cambiado text-muted a text-light --}}
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