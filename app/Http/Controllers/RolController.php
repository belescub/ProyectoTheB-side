<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    // Muestra todos los roles
 public function index() {
    // SoftDelete filtra automáticamente los eliminados
    $roles = Rol::all();                  // SoftDelete filtra deleted_at automáticamente
    return view('roles.index', compact('roles'));
}
 // Guarda un nuevo rol
public function store(Request $request) {
    $request->validate([
        'nombre'      => 'required|string|max:50|unique:roles',
        'descripcion' => 'nullable|string|max:255',
    ]);
    // Crea el rol usando fillable
    Rol::create($request->only(['nombre', 'descripcion'])); // usa $fillable del Model
    return redirect()->route('roles.index')->with('exito', 'Rol creado.');
}
// Elimina un rol (Soft Delete)
public function destroy(Rol $rol) {
    $rol->delete();                       // SoftDelete: setea deleted_at, no borra la fila
    return redirect()->route('roles.index')->with('exito', 'Rol eliminado.');
}
}
