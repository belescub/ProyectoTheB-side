<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\UsuarioController; 
use App\Http\Controllers\ProductoController; 
use App\Http\Controllers\AdminConsultaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\CheckoutController;
use App\Models\Producto;

/* ==================
   1. RUTAS PÚBLICAS
   ================== */

Route::get('/', function () {
    $productosRandom = Producto::where('stock', '>', 0)->inRandomOrder()->take(3)->get();
    return view('TheB-Side', compact('productosRandom')); 
});

Route::get('/contacto', function () { return view('contacto'); });
Route::post('/contacto', [ContactoController::class, 'procesar']);
Route::get('/terminosdeuso', function () { return view('terminosdeuso'); });
Route::get('/privacidad', function() { return view('privacidad'); });

// --- Autenticación ---
Route::get('/login', [AuthController::class, 'formularioLogin'])->name('login');
Route::post('/login', [AuthController::class, 'autenticar']); 

Route::get('/registro', [AuthController::class, 'formularioRegistro'])->name('registro');

// --- Catálogo y Buscador ---
Route::get('/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');

Route::get('/quienessomos', function () {
    return view('quienes-somos'); 
});

/** Rutas de autenticación */

Route::post('/registro', [AuthController::class, 'registrar']);

Route::get('/productos/{categoria?}', function ($categoria = 'todos') {
    if ($categoria === 'todos') {
    
        $productos = Producto::where('stock', '>', 0)
                     ->paginate(5); 
    } else {
        $productos = Producto::whereHas('categoria', function($query) use ($categoria) {
                $query->where('nombre', $categoria);
            })->where('stock', '>', 0)
                ->paginate(12);
    }
    return view('productos', compact('productos', 'categoria'));
})->name('productos');


/* =====================
   2. RUTAS DE CLIENTES 
   ===================== */

Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Panel Cliente
    Route::get('/cliente', function () { return view('backend.usuarios.cliente'); })->name('cliente');
    Route::get('/cliente/consultas', [ContactoController::class, 'misConsultas'])->name('cliente.consultas');
    Route::get('/cliente/compras', [CompraController::class, 'historial'])->name('compras.historial');
    Route::get('/cliente/facturas', [FacturaController::class, 'index'])->name('facturas.index');
    Route::get('/cliente/facturas/{id}', [FacturaController::class, 'show'])->name('facturas.show');

    // Carrito y Checkout
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/confirmar', [CarritoController::class, 'confirmar'])->name('carrito.confirmar');
    
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});


/* =========================================
   3. RUTAS DE ADMINISTRADOR 
   ========================================= */

// Usamos ->prefix('admin') para que todas empiecen con /admin automáticamente
// Y ->middleware(['auth', 'admin']) para que no entre nadie que no sea administrador
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // AdminController solo maneja el dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    
    // ProductoController ahora maneja sus propios métodos
    Route::post('/productos', [ProductoController::class, 'store'])->name('admin.productos.store');
    Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])->name('admin.producto.editar');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('admin.producto.update');
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('admin.producto.eliminar');

    // UsuarioController ahora maneja sus propios métodos
    Route::put('/usuario/{id}/baja', [UsuarioController::class, 'destroy'])->name('admin.usuario.baja');
    Route::put('/usuario/{id}/hacer-admin', [UsuarioController::class, 'hacerAdmin'])->name('admin.usuario.hacerAdmin');
    
    // AdminConsultaController maneja las consultas
    Route::get('/consultas', [AdminConsultaController::class, 'index'])->name('admin.consultas.index');
    Route::post('/consultas/{consulta}/toggle-leido', [AdminConsultaController::class, 'toggleLeido'])->name('admin.consultas.leido');
    Route::post('/consultas/{consulta}/responder', [AdminConsultaController::class, 'responder'])->name('admin.consultas.responder');
    Route::delete('/consultas/{consulta}', [AdminConsultaController::class, 'destroy'])->name('admin.consultas.destroy');
});