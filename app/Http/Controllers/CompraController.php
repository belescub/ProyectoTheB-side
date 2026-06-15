<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta_cabecera;

class CompraController extends Controller
{
    public function historial()
    {
        // Buscamos las cabeceras de venta que correspondan al usuario logueado
        $compras = Venta_cabecera::where('usuario_id', auth()->user()->id)
                                 ->whereNotNull('fecha_venta') // Solo consideramos las compras que ya fueron finalizadas
                                 ->where('total', '>', 0) // Nos aseguramos de que sean compras reales, no carritos abandonados
                                 ->orderBy('fecha_venta', 'desc')
                                 ->get();

        return view('backend.usuarios.historial_compras', compact('compras'));
    }
}
