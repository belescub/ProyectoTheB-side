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
use App\Models\Producto;


Route::get('/', function () {
    return view('TheB-Side'); //pagina princial
});

Route::get('/contacto', function () {
    return view('contacto'); 
});

Route::get('/terminosdeuso', function () {
    return view('terminosdeuso'); 
});

Route::get('/privacidad', function(){
    return view('privacidad');
});

Route::get('/quienessomos', function () {
    return view('quienes-somos'); 
});

/** Rutas de autenticación */
Route::get('/login', [AuthController::class, 'formularioLogin']) ->name('login');
Route::post('/login', [AuthController::class, 'autenticar']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Cierra sesión, solo para usuarios autenticados

Route::get('/registro', [AuthController::class, 'formularioRegistro']) ->name('registro');
Route::post('/registro', [AuthController::class, 'registrar']);

Route::get('/cliente', [ClienteController::class, 'index']);

Route::get('/admin', [AdminController::class, 'index']);
Route::post('/admin/productos', [AdminController::class, 'store'])->name('admin.productos.store');

Route::get('/productos/{categoria?}', function ($categoria = 'todos') {
    if ($categoria === 'todos') {
        // Trae todos los productos
        $productos = Producto::all(); 
    } else {
        // Trae solo los productos de la categoría seleccionada
        $productos = Producto::whereHas('categoria', function($query) use ($categoria) {
            $query->where('nombre', $categoria);
        })->get();
    }

    return view('productos', compact('productos', 'categoria'));
});



Route::middleware('auth')->group(function () {

    Route::get('/carrito', [CarritoController::class, 'index'])
        ->name('carrito.index');

    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])
        ->name('carrito.agregar');

    Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])
        ->name('carrito.eliminar');

    Route::post('/carrito/confirmar', [CarritoController::class, 'confirmar'])
        ->name('carrito.confirmar');
});

Route::put('/admin/usuario/{id}/baja', [AdminController::class, 'darBaja'])
      ->name('admin.usuario.baja');

Route::put('/admin/usuario/{id}/hacer-admin', [AdminController::class, 'hacerAdmin'])
      ->name('admin.usuario.hacerAdmin');

Route::get('/admin/productos/{id}/editar', [AdminController::class, 'edit'])
      ->name('admin.producto.editar');

Route::put('/admin/productos/{id}', [AdminController::class, 'update'])
      ->name('admin.producto.update');

Route::delete('/admin/productos/{id}', [AdminController::class, 'destroy'])
      ->name('admin.producto.eliminar');

      // Ruta para el buscador
Route::get('/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');

Route::post('/contacto', [ContactoController::class, 'procesar']);
Route::prefix('admin')->middleware(['auth'])->group(function () {
    
    Route::get('/consultas', [AdminConsultaController::class, 'index'])->name('admin.consultas.index');
    Route::post('/consultas/{consulta}/toggle-leido', [AdminConsultaController::class, 'toggleLeido'])->name('admin.consultas.leido');
    Route::post('/consultas/{consulta}/responder', [AdminConsultaController::class, 'responder'])->name('admin.consultas.responder');
    Route::delete('/consultas/{consulta}', [AdminConsultaController::class, 'destroy'])->name('admin.consultas.destroy');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/cliente', function () { return view('backend.usuarios.cliente'); })->name('cliente');
    Route::get('/cliente/consultas', [ContactoController::class, 'misConsultas'])->name('cliente.consultas');
    Route::get('/cliente/compras', [CompraController::class, 'historial'])->name('compras.historial');
    Route::get('/cliente/facturas', [FacturaController::class, 'index'])->name('facturas.index');
});