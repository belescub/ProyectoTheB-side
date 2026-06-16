<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta_cabecera;
use App\Models\Venta_detalle;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $carrito = Venta_cabecera::where('usuario_id', auth()->id())
                                  ->where('estado', 'carrito')
                                  ->first();

        if (!$carrito) {
            return redirect()->route('productos')->with('error', 'Tu carrito está vacío. Agrega productos antes de proceder al checkout.');
        }

        $items = Venta_detalle::with('producto')
                              ->where('venta_cabecera_id', $carrito->id)
                              ->get();

        return view('backend.usuarios.checkout', compact('items', 'carrito'));
    }

    public function process(Request $request)
    {
        // Agregamos localidad y código postal a la validación
        $validated = $request->validate([
            'telefono' => 'required',
            'direccion' => 'required',
            'provincia' => 'required',
            'localidad' => 'required',
            'codigo_postal' => 'required',
            'metodo_pago' => 'required',
            'metodo_entrega' => 'required'
        ]);

        $carrito = Venta_cabecera::where('usuario_id', auth()->id())
                                   ->where('estado', 'carrito')
                                   ->firstOrFail();

        $detalles = Venta_detalle::with('producto')
                                   ->where('venta_cabecera_id', $carrito->id)
                                   ->get();

        // 1. VALIDACIÓN PREVIA: Verificar stock de TODO
        foreach ($detalles as $detalle) {
            if ($detalle->producto->stock < $detalle->cantidad) {
                return back()->with(['error' => 'Stock insuficiente para ' . $detalle->producto->nombre]);
            }
        }

        // 2. PROCESAMIENTO SEGURO
        DB::beginTransaction();

        try {
            // Descontar stock
            foreach ($detalles as $detalle) {
                $producto = $detalle->producto;
                $producto->stock -= $detalle->cantidad;
                $producto->save();
            }

            // Calcular costo de envío
            if ($request->metodo_entrega == 'retiro') {
                $costoEnvio = 0;
            } elseif (
                strtolower($request->provincia) == 'corrientes' &&
                strtolower($request->localidad) == 'corrientes'
            ) {
                $costoEnvio = 1000;
            } elseif (strtolower($request->provincia) == 'corrientes') {
                $costoEnvio = 3000;
            } else {
                $costoEnvio = 9000;
            }
            
            // Calculamos el total final
            $totalFinal = $carrito->total + $costoEnvio;

            // Actualizar la cabecera de la venta
            $carrito->update([
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'provincia' => $request->provincia,
                'localidad' => $request->localidad,
                'codigo_postal' => $request->codigo_postal,
                'metodo_pago' => $request->metodo_pago,
                'metodo_entrega' => $request->metodo_entrega,
                'costo_envio' => $costoEnvio,
                'total' => $totalFinal,
                'estado' => 'confirmado',
                'fecha_venta' => now(),
            ]);

            // Guardar en la sesión el valor correcto para mostrar en la vista
            session(['total' => $totalFinal]);

            DB::commit();

            // CAMBIADO: 'compra.confirmada' por 'compras.historial' para que redirija bien
            return redirect()
                ->route('compras.historial')
                ->with([
                    'success' => '¡Compra realizada con éxito!',
                    'swal_title' => '¡Gracias por tu compra!',
                    'swal_icon' => 'success'
                ]);

        } catch (\Exception $e) {
            // Si algo falla internamente, deshacemos cualquier cambio en la BD
            DB::rollBack();
            return back()->with(['error' => 'Ocurrió un problema al procesar la orden. Inténtalo nuevamente.']);
        }
    }   
}