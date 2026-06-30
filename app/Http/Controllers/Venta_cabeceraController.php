<?php

namespace App\Http\Controllers;

use App\Models\Venta_cabecera;
use App\Models\Venta_detalle;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <--- ¡Importante! Necesitamos esto

class Venta_cabeceraController extends Controller
{
    /**
     * Muestra el historial de ventas.
     */
    public function index()
    {
        $ventas = Venta_cabecera::with(['venta_detalles', 'usuario'])->latest()->get();
        return view('venta_cabeceras.index', compact('ventas'));
    }

    /**
     * Procesa la venta final.
     */
    public function store(Request $request)
    {
        $request->validate([
            'productos' => 'required|array',
            'cantidades' => 'required|array',
        ]);

        // Usamos una transacción para garantizar integridad de datos
        DB::beginTransaction();

        try {
            $venta_cabecera = Venta_cabecera::create(['total' => 0, 'usuario_id' => auth()->id()]);
            $totalVenta = 0;

            foreach ($request->productos as $index => $producto_id) {
                $producto = Producto::findOrFail($producto_id);
                $cantidad = $request->cantidades[$index];

                // Validación de stock extra (seguridad backend)
                if ($producto->stock < $cantidad) {
                    throw new \Exception("Stock insuficiente para: {$producto->nombre}");
                }

                $subtotal = $producto->precio * $cantidad;
                $totalVenta += $subtotal;

                Venta_detalle::create([
                    'venta_cabecera_id' => $venta_cabecera->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotal
                ]);

                $producto->decrement('stock', $cantidad); // Método más limpio
            }

            $venta_cabecera->update(['total' => $totalVenta]);

            DB::commit(); // Si todo salió bien, guardamos todo
            return redirect()->route('venta_cabeceras.index')->with('success', '¡Venta registrada!');

        } catch (\Exception $e) {
            DB::rollBack(); // Si hubo error, deshacemos todo lo anterior
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function create(){
        // Para hacer una venta, se necesita conocer el precio del producto
        $productos = Producto::where('activo', true)->where('stock', '>', 0)->get();
        return view('venta_cabeceras.create', compact('productos'));
    }

    // Cambiamos "string $id" por "Venta $venta"
    public function show(Venta_cabecera $venta_cabecera)
    {
        // Cargamos los renglones y de paso, el producto de cada renglón
        $venta_cabecera->load('detalles.producto');
        return view('venta_cabeceras.show', compact('venta_cabecera'));
    }

    public function edit(Venta_cabecera $venta_cabecera)
    {
        // Por regla general contable, LAS venta_cabeceras NO SE EDITAN. 
        // Si hay un error, se anula (destroy) y se hace una nueva.
        return redirect()->route('venta_cabeceras.index')->with('error', 'Las ventas no pueden ser modificadas.');
    }

    public function update(Request $request, Venta_cabecera $venta_cabecera)
    {
        // Queda sin uso contable.
    }

    public function destroy(Venta_cabecera $venta_cabecera)
    {
        // Anula la venta (SoftDeletes). 
        $venta_cabecera->delete();
        return redirect()->route('venta_cabeceras.index')->with('success', '¡Venta anulada!');
    }
}