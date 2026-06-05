<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;

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

Route::get('/productos/{categoria?}', function ($categoria = 'todos') { 
    return view('productos', ['categoria' => $categoria]); 
});

Route::get('/carrito', function () { 
    return view('en-construccion'); 
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