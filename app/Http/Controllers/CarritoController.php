<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Venta_cabecera;
use App\Models\Venta_detalle;
use App\Models\Producto;

class CarritoController extends Controller
{
    private function obtenerCarrito() 
    {
        return Venta_cabecera::firstOrCreate(['usuario_id' => auth()->id(),'estado' => 'carrito'],['total' => 0, 'fecha_venta' => now()]);
    }
    public function index(){
        $carrito = $this->obtenerCarrito();
        $items = Venta_detalle::with('producto')->where('venta_cabecera_id', $carrito->id)->get();
        return view('backend.usuarios.carrito',compact('items', 'carrito'));
    }
    public function agregar(Producto $producto){
        $carrito = $this->obtenerCarrito();
        $item = Venta_detalle::where('venta_cabecera_id', $carrito->id)->where('producto_id', $producto->id)->first();
            if ($item) {
                $item->cantidad++;
                 $item->subtotal = $item->cantidad * $item->precio_unitario;
                 $item->save();
            } else {
                Venta_detalle::create(['venta_cabecera_id' => $carrito->id,'producto_id' => $producto->id,'cantidad' => 1,'precio_unitario' => $producto->precio,'subtotal' => $producto->precio]);
             }
             $this->recalcularTotal($carrito);
         return redirect()->back();
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
public function confirmar()
{
    $carrito = $this->obtenerCarrito();

    $carrito->update([
        'estado' => 'confirmado',
        'fecha_venta' => now()
    ]);

    session([
        'total' => $carrito->total
    ]);

    return redirect()
        ->route('compra.confirmada');
}
}
