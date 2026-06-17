<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario; 
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function procesar(Request $request)
    {
        // Agregamos la validación con mensajes personalizados
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email', 
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);
        Usuario::create([
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            // Encriptamos la contraseña obligatoriamente para que el login funcione
            'password' => Hash::make($request->input('password')), 
            // Asignamos un rol por defecto para los clientes nuevos (ej: 2)
            'rol_id' => 2 
        ]);

        return view('backend.usuarios.login', [
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email')
        ]);
    }
    
}
