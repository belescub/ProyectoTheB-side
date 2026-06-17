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
            // 3. Si la autenticación es exitosa, redirigimos a la página de éxito
            $request->session()->regenerate();
        return view('exito-login', [
            'email' => $request->input('email')
        ]);
    }
        // 4. Si la autenticación falla, redirigimos de vuelta al formulario con un mensaje de error
        return back()->withErrors([
            'login_error' => 'El correo o la contraseña son incorrectos.',
        ])->withInput();
    }
}

