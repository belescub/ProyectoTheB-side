<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Models\Rol;

class UsuarioController extends Controller{
    public function index() {
    // with('rol') carga la relación y evita el problema de consultas N+1
        $usuarios = Usuario::with('rol')->get();
        return view('usuarios.index', compact('usuarios'));
    }


    public function create() {
        $roles = Rol::all();         // necesario para el <select> del formulario
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request) {
        $request->validate([
                'nombre'   => 'required|string|max:100',
                'email'    => 'required|email|unique:usuarios',
                'password' => 'required|min:8|confirmed', // busca campo password_confirmation
                'rol_id'   => 'required|exists:roles,id',
            ], [
                'nombre.required'    => 'Debe completar este campo.',
                'email.required'     => 'Debe completar este campo.',
                'email.email'        => 'Por favor, ingresa un correo electrónico válido.',
                'email.unique'       => 'Ya existe una cuenta con este correo.',
                'password.required'  => 'Debe completar este campo.',
                'password.min'       => 'La contraseña debe contar al menos con :min caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
            ]);


        Usuario::create($request->only(['nombre', 'email', 'password', 'rol_id']));
        return redirect()->route('usuarios.index')->with('exito', 'Usuario registrado.');
    }

    public function destroy(Usuario $usuario) {
        $usuario->delete();                   // borrado lógico
        return redirect()->route('usuarios.index')->with('exito', 'Usuario dado de baja.');
    }
}
