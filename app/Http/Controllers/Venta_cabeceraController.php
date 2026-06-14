<?php

namespace App\Http\Controllers;

use App\Models\Venta_cabecera;
use App\Models\Venta_detalle; // Importamos el detalle
use App\Models\Producto;      // Importamos producto porque necesitamos saber los precios
use Illuminate\Http\Request;

class Venta_cabeceraController extends Controller
{
    public function index()
    {
        // Traemos las venta_cabeceras. 
        // Usamos with('detalles') para que traiga los renglones de una sola vez
        $ventas = Venta_cabecera::with(['venta_detalles', 'usuario'])
            ->latest()
            ->get();
        
        return view('venta_cabeceras.index', compact('ventas'));
        
    }

    public function create(){
        // Para hacer una venta, se necesita conocer el precio del producto
        $productos = Producto::where('activo', true)->where('stock', '>', 0)->get();
        return view('venta_cabeceras.create', compact('productos'));
    }

    public function store(Request $request){
        // Validamos que nos manden productos y cantidades
        // (Esto asume que el formulario manda arreglos: productos[] y cantidades[])
        $request->validate([
            'productos' => 'required|array',
            'cantidades' => 'required|array',
        ]);

        // Creamos la venta vacía primero (necesitamos que nazca para tener el venta_id)
        $venta_cabecera = Venta_cabecera::create([
            'total' => 0 // Arranca en 0, lo calculamos ahora
        ]);

        $totalVenta = 0;

        // 3. Recorremos los productos que eligió el cliente
        foreach ($request->productos as $index => $producto_id) {
            $cantidad = $request->cantidades[$index];
            $producto = Producto::find($producto_id);

            // Calculamos el subtotal de este renglón
            $subtotal = $producto->precio * $cantidad;
            $totalVenta += $subtotal;

            // ¡CREAMOS EL RENGLÓN (Venta_detalle)!
            Venta_detalle::create([
                'venta_cabecera_id' => $venta_cabecera->id, // Lo conectamos al ticket recién creado
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio, // Congelamos el precio actual
                'subtotal' => $subtotal
            ]);

            // EXTRA (Opcional pero recomendado): Restar el stock del producto
            $producto->stock = $producto->stock - $cantidad;
            $producto->save();
        }

        // 4. Actualizamos el total real de la venta
        $venta->total = $totalVenta;
        $venta->save();

        return redirect()->route('venta_cabeceras.index')->with('success', '¡Venta registrada con éxito!');
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