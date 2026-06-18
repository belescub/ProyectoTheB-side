<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Models\Rol;

class UsuarioController extends Controller{

    // Muestra todos los usuarios
    public function index() {

        // with('rol') evita consultas repetidas (N+1)
        $usuarios = Usuario::with('rol')->get();

        return view('usuarios.index', compact('usuarios'));
    }

    // Muestra formulario de creación de usuario
    public function create() {

        // Traemos roles para el select
        $roles = Rol::all();

        return view('usuarios.create', compact('roles'));
    }

    // Guarda un nuevo usuario
    public function store(Request $request) {

        // Validación de datos
        $request->validate([
                'nombre'   => 'required|string|max:100',
                'email'    => 'required|email|unique:usuarios',
                'password' => 'required|min:8|confirmed', // Busca password_confirmation
                'rol_id'   => 'required|exists:roles,id',
            ]);

        // Guarda usuario
        Usuario::create($request->only(['nombre', 'email', 'password', 'rol_id']));

        return redirect()->route('usuarios.index')->with('exito', 'Usuario registrado.');
    }

    // Elimina usuario (Soft Delete)
    public function destroy(Usuario $usuario) {

        // Baja lógica del usuario
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('exito', 'Usuario dado de baja.');
    }
}