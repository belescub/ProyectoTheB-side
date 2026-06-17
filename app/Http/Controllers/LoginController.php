<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function procesar(Request $request)
    {
        // 1. Tomamos las credenciales del formulario
        $credenciales = $request->only('email', 'password');

        // 2. Intentamos autenticar al usuario
        if (Auth::attempt($credenciales)) {
            // Regenerar la sesión por seguridad
            $request->session()->regenerate();

            // 3. Obtenemos al usuario que acaba de iniciar sesión
            $usuario = Auth::user();

            // 4. Redirigimos según su rol
            if ($usuario->rol_id == 1) { 
                // Si es Administrador, lo enviamos al dashboard
                return redirect('admin'); 
            } else {
                // Si es Cliente (o cualquier otro rol), lo enviamos a la página principal
                return redirect('/'); 
            }
        }

        // 5. Si la autenticación falla, regresamos con error
        return back()->withErrors([
            'login_error' => 'El correo o la contraseña son incorrectos.',
        ])->withInput($request->only('email')); // Mantenemos solo el correo para que no lo vuelva a escribir
    }
}

