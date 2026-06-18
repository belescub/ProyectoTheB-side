<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;

class AdminConsultaController extends Controller
{
    // Muestra todas las consultas hechas por los clientes
    public function index()
    {
        // Trae las consultas ordenadas desde la más nueva a la más vieja
        $consultas = Consulta::orderBy('created_at', 'desc')->get();
        
        // Retorna la vista del panel admin con las consultas
        return view('backend.admin.consultas', compact('consultas'));
    }

    // Cambia el estado de leída/no leída
    public function toggleLeido(Consulta $consulta)
    {
        // Invierte el valor actual (true pasa a false y viceversa)
        $consulta->leido = !$consulta->leido; 
        $consulta->save();

        // Redirige atrás con mensaje
        return redirect()->back()->with('success', 'Estado de la consulta actualizado.');
    }

    // Guarda la respuesta del administrador
    public function responder(Request $request, Consulta $consulta)
    {
        // Valida que la respuesta no esté vacía
        $request->validate([
            'respuesta' => 'required|string'
        ]);

        // Guarda la respuesta en la consulta
        $consulta->respuesta = $request->input('respuesta');

        // La marcamos como leída automáticamente
        $consulta->leido = true; 
        $consulta->save();

        return redirect()->back()->with('success', 'Respuesta guardada con éxito.');
    }

    // Elimina una consulta (Soft Delete)
    public function destroy(Consulta $consulta)
    {
        $consulta->delete(); 

        return redirect()->back()->with('success', 'Consulta movida a la papelera.');
    }
}