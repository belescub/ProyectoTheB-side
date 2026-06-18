<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta_cabecera;

class FacturaController extends Controller
{
    // Muestra todas las facturas del usuario logueado
    public function index(){

        // Traemos solo compras finalizadas
        $facturas = Venta_cabecera::where('usuario_id', auth()->user()->id)
                                 ->whereNotNull('fecha_venta') // Solo compras confirmadas
                                 ->where('total', '>', 0) // Evita carritos vacíos o abandonados
                                 ->orderBy('fecha_venta', 'desc') // Ordena de la más nueva a la más vieja
                                 ->get();

        // Retorna la vista con todas las facturas
        return view('backend.usuarios.facturas', compact('facturas'));
    }

    // Muestra el detalle de una factura específica
    public function show($id){

        // Cargamos la compra junto con sus detalles y productos relacionados
        $compra = Venta_cabecera::with('venta_detalles.producto')
                                 ->where('usuario_id', auth()->user()->id) // Seguridad: solo puede ver sus propias facturas
                                 ->whereNotNull('fecha_venta') // Solo compras confirmadas
                                 ->where('total', '>', 0)
                                 ->findOrFail($id); // Si no existe, tira error 404

        // Retorna la vista del detalle de factura
        return view('backend.usuarios.factura_detalle', compact('compra'));
    }
}
