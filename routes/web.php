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
use App\Models\Producto;


Route::get('/', function () {
    return view('TheB-Side'); //pagina princial
});

Route::get('/contacto', function () {
    return view('contacto'); 
});

Route::post('/contacto', [ContactoController::class, 'procesar']);

Route::get('/terminosdeuso', function () {
    return view('terminosdeuso'); 
});

Route::get('/privacidad', function(){
    return view('privacidad');
});

Route::get('/quienessomos', function () {
    return view('quienes-somos'); 
});

/**Route::get('/productos/{categoria?}', function ($categoria = 'todos') { 
    return view('productos', ['categoria' => $categoria]); 
});

/**Route::get('/productos/{categoria?}', function ($categoria = 'todos') { 
    return view('productos', ['categoria' => $categoria]); 
});*/

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
