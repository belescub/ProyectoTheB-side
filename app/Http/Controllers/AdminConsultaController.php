<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;

class AdminConsultaController extends Controller
{
    // Mostrar todas las consultas al admin
    public function index()
    {
        // Traemos las consultas ordenadas por las más nuevas
        $consultas = Consulta::orderBy('created_at', 'desc')->get();
        
        // Devolvemos UNA SOLA vista: la que está en views/backend/admin/consultas.blade.php
        return view('backend.admin.consultas', compact('consultas'));
    }

    // Cambiar estado Leído / No Leído
    public function toggleLeido(Consulta $consulta)
    {
        $consulta->leido = !$consulta->leido; 
        $consulta->save();

        return redirect()->back()->with('success', 'Estado de la consulta actualizado.');
    }

    // Guardar la respuesta del admin
    public function responder(Request $request, Consulta $consulta)
    {
        $request->validate([
            'respuesta' => 'required|string'
        ]);

        $consulta->respuesta = $request->input('respuesta');
        $consulta->leido = true; 
        $consulta->save();

        return redirect()->back()->with('success', 'Respuesta guardada con éxito.');
    }

    // Eliminar (Soft Delete)
    public function destroy(Consulta $consulta)
    {
        $consulta->delete(); 
        return redirect()->back()->with('success', 'Consulta movida a la papelera.');
    }
}