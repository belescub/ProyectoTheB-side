<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
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
Route::get('/quienessomos', function () { return view('quienes-somos'); });

// --- Autenticación ---
Route::get('/login', [AuthController::class, 'formularioLogin'])->name('login');
// OJO: Dejé solo AuthController. Si tu lógica está en LoginController, cambiá la clase.
Route::post('/login', [AuthController::class, 'autenticar']); 

Route::get('/registro', [AuthController::class, 'formularioRegistro'])->name('registro');
Route::post('/registro', [RegistroController::class, 'procesar']);

// --- Catálogo y Buscador ---
Route::get('/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');

Route::get('/productos/{categoria?}', function ($categoria = 'todos') {
    if ($categoria === 'todos') {
    
        $productos = Producto::where('stock', '>', 0)->get(); 
    } else {
        $productos = Producto::whereHas('categoria', function($query) use ($categoria) {
            $query->where('nombre', $categoria);
        })->where('stock', '>', 0)->get();
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
   3. RUTAS DE ADMINISTRADOR (Requiere Auth y Rol Admin)
   ========================================= */

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Panel y Gestión General
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/store', [AdminController::class, 'store']);
    
    // Gestión de Productos
    Route::post('/productos', [AdminController::class, 'store'])->name('admin.productos.store');
    Route::get('/productos/{id}/editar', [AdminController::class, 'edit'])->name('admin.producto.editar');
    Route::put('/productos/{id}', [AdminController::class, 'update'])->name('admin.producto.update');
    Route::delete('/productos/{id}', [AdminController::class, 'destroy'])->name('admin.producto.eliminar');

    // Gestión de Usuarios
    Route::put('/usuario/{id}/baja', [AdminController::class, 'darBaja'])->name('admin.usuario.baja');
    Route::delete('/usuario/{id}', [AdminController::class, 'darBaja']); 
    Route::put('/usuario/{id}/hacer-admin', [AdminController::class, 'hacerAdmin'])->name('admin.usuario.hacerAdmin');
    Route::put('/hacer-admin/{id}', [AdminController::class, 'hacerAdmin']); 

    // Gestión de Consultas
    Route::get('/consultas', [AdminConsultaController::class, 'index'])->name('admin.consultas.index');
    Route::post('/consultas/{consulta}/toggle-leido', [AdminConsultaController::class, 'toggleLeido'])->name('admin.consultas.leido');
    Route::post('/consultas/{consulta}/responder', [AdminConsultaController::class, 'responder'])->name('admin.consultas.responder');
    Route::delete('/consultas/{consulta}', [AdminConsultaController::class, 'destroy'])->name('admin.consultas.destroy');
});