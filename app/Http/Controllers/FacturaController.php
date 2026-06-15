<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta_cabecera;

class FacturaController extends Controller
{
    public function index(){
        $facturas = Venta_cabecera::where('usuario_id', auth()->user()->id)
                                 ->whereNotNull('fecha_venta') // Solo consideramos las compras que ya fueron finalizadas
                                 ->where('total', '>', 0) // Nos aseguramos de que sean compras reales, no carritos abandonados
                                 ->orderBy('fecha_venta', 'desc')
                                 ->get();

        return view('backend.usuarios.facturas', compact('facturas'));
    }

    public function show($id){
        // Cargamos la venta con su relación 'venta_detalles' y, a su vez, el 'producto' de cada detalle
        $compra = Venta_cabecera::with('venta_detalles.producto')
                                 ->where('usuario_id', auth()->user()->id)
                                 ->whereNotNull('fecha_venta')
                                 ->where('total', '>', 0)
                                 ->findOrFail($id);

        return view('backend.usuarios.factura_detalle', compact('compra'));
    }
}
