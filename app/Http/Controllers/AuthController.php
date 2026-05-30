<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use App\Models\Usuario; 


class AuthController extends Controller
{
    /**
     * Muestra el formulario de registro
     */
    public function formularioRegistro()
    {
        return view('backend.usuarios.registro');
    }

    /**
     * Muestra el formulario de login
     */
    public function formularioLogin()
    {
        return view('backend.usuarios.login');
    }

    /**
     * Procesa el formulario de registro y valida los datos
     */
    public function registrar(Request $request)
    {
        /* Validacion: revisa que los datos del formulario sean correctos */
        $request->validate([
            'nombre' => 'required|string|max:255', 
            'email' => 'required|string|email|max:255|unique:usuarios', 
            'password' => 'required|string|min:8|confirmed', 
        ]);

        // CORRECCIÓN: Creamos y guardamos el usuario en tu base de datos
        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encripta la contraseña de forma segura
            'rol_id' => 2, // Todo usuario que se registre web es por defecto Cliente (rol_id = 2)
        ]);

        // Iniciamos sesión automáticamente al recién registrado
        Auth::login($usuario);

        // Redireccionamos a la pantalla del cliente
        return redirect('/cliente');
    }

    /**
     * Valida que lleguen el email y contraseña
     */
    public function autenticar(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Auth::attempt() busca el usuario en la BD y compara la contraseña
        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            // CORRECCIÓN: Adaptado a tu columna 'rol_id' (1 = Admin)
            if (Auth::user()->rol_id == 1) {
                return redirect('/admin');
            }

            // Si no es admin (1), asumimos que es cliente
            return redirect('/cliente');
        }

        // Si las credenciales son incorrectas, vuelve al login con error
        return back()->withErrors([ 'email' => 'Email o contraseña incorrectos' ]);
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
