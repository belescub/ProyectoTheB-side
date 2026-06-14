<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta; 

class ContactoController extends Controller
{
    public function procesar(Request $request) 
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        // 1. Validamos los datos que llegan del formulario
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email'    => 'required|email|max:255',
            'mensaje'  => 'required|string'
        ]);

        // 2. Guardamos en la Base de Datos
        Consulta::create([
            'nombre'   => $request->input('nombre'),
            'telefono' => $request->input('telefono'),
            'email'    => $request->input('email'),
            'mensaje'  => $request->input('mensaje')
        ]);

        // 3. Redirigimos.
        return redirect()->back()->with('success', '¡Tu mensaje ha sido enviado! Te contactaremos pronto.');
    }
    public function misConsultas(){
        // Buscamos solo las consultas hechas con el correo del cliente que inició sesión
        $consultas = \App\Models\Consulta::where('email', auth()->user()->email)
                                         ->orderBy('created_at', 'desc')
                                         ->get();

        return view('backend.usuarios.mis_consultas', compact('consultas'));
    }
}