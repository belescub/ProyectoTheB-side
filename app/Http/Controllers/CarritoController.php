<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Venta_cabecera;
use App\Models\Venta_detalle;
use App\Models\Producto;

class CarritoController extends Controller
{
public function index()
{
    if (
        auth()->check() &&
        auth()->user()->rol &&
        strtolower(auth()->user()->rol->nombre) === 'admin'
    ) {
        return redirect('/')
            ->with('error', 'Los administradores no tienen acceso al carrito.');
    }

    $carrito = $this->obtenerCarrito();

    $items = Venta_detalle::with('producto')
        ->where('venta_cabecera_id', $carrito->id)
        ->get();

    return view('backend.usuarios.carrito', compact('items', 'carrito'));
}
    private function obtenerCarrito() 
    {
        return Venta_cabecera::firstOrCreate(['usuario_id' => auth()->id(),'estado' => 'carrito'],['total' => 0, 'fecha_venta' => now()]);
    }
public function agregar(Request $request, Producto $producto)
{
    // 0.Accedemos al nombre del rol mediante la relación
    if (auth()->check() && auth()->user()->rol && strtolower(auth()->user()->rol->nombre) === 'admin') {
        return redirect()->back()->with('error', '¡Los administradores no pueden realizar compras en la tienda!');
    }

    // 1. Capturamos la cantidad que viene del formulario
    $cantidadSolicitada = $request->input('cantidad', 1);
    
    $carrito = $this->obtenerCarrito();
    
    // 2. Buscamos si el producto ya está en el carrito
    $item = Venta_detalle::where('venta_cabecera_id', $carrito->id)
                         ->where('producto_id', $producto->id)
                         ->first();

    // 3. Calculamos cuánto habría en total si permitimos esta acción
    $cantidadActualEnCarrito = $item ? $item->cantidad : 0;
    $cantidadTotalProyectada = $cantidadActualEnCarrito + $cantidadSolicitada;

    // 4. ¡EL FILTRO DE SEGURIDAD! Comparamos contra el stock real
    if ($cantidadTotalProyectada > $producto->stock) {
       return redirect()->back()->with([
    'error' => '¡Ups! Lo sentimos pero no contamos con esa cantidad en stock.',
    'swal_title' => '¡Sin stock!',
    'swal_icon' => 'info' 
]);
    }

    // 5. Si pasó el filtro, guardamos o actualizamos normal
    if ($item) {
        $item->cantidad = $cantidadTotalProyectada;
        $item->subtotal = $item->cantidad * $item->precio_unitario;
        $item->save();
    } else {
        Venta_detalle::create([
            'venta_cabecera_id' => $carrito->id,
            'producto_id'       => $producto->id,
            'cantidad'          => $cantidadSolicitada,
            'precio_unitario'   => $producto->precio,
            'subtotal'          => $producto->precio * $cantidadSolicitada
        ]);
    }

    $this->recalcularTotal($carrito);
    
    return redirect()->back()->with('success', '¡Producto agregado al carrito con éxito!');
}
    private function recalcularTotal($carrito)
{
    $total = Venta_detalle::where(
        'venta_cabecera_id',
        $carrito->id
    )->sum('subtotal');

    $carrito->update([
        'total' => $total
    ]);
}
public function eliminar($id)
{
    $carrito = $this->obtenerCarrito();

    $item = Venta_detalle::where(
        'venta_cabecera_id',
        $carrito->id
    )->findOrFail($id);

    $item->delete();

    $this->recalcularTotal($carrito);

    return back();
}
public function confirmar(){
    $carrito = $this->obtenerCarrito();

    if ($carrito->total <= 0) {
        return redirect()->back()->with([
            'error' => 'Debe cargar al menos un producto al carrito para finalizar la compra.',
            'swal_title' => '¡Carrito Vacío!',
            'swal_icon' => 'warning'
        ]);
    }

    return redirect()->route('checkout.index');
}
}
