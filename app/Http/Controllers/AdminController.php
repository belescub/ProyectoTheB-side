<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Venta_cabecera;

class AdminController extends Controller
{
    /**
     * Muestra el dashboard del administrador.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | ESTADÍSTICAS
        |--------------------------------------------------------------------------
        */

        $totalClientes = Usuario::where('rol_id', 2)->count();

        $totalCategorias = Categoria::count();

        $totalProductos = Producto::count();

        $totalVentas = Venta_cabecera::whereMonth('fecha_venta', now()->month)
            ->whereYear('fecha_venta', now()->year)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | DATOS GENERALES
        |--------------------------------------------------------------------------
        */

        $categorias = Categoria::all();

        // Inventario paginado
        $productos = Producto::with('categoria')->paginate(5);

        // Clientes
        $usuarios = Usuario::withTrashed()->get();

        /*
        |--------------------------------------------------------------------------
        | CONSULTA DE VENTAS
        |--------------------------------------------------------------------------
        */

        $queryVentas = Venta_cabecera::with([
            'venta_detalles.producto',
            'usuario'
        ])->latest();

        /*
        |--------------------------------------------------------------------------
        | FILTRO DE BÚSQUEDA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('buscar')) {

            $texto = $request->buscar;

            $queryVentas->whereHas('venta_detalles.producto', function ($q) use ($texto) {
                $q->where('nombre', 'like', "%{$texto}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO POR FECHAS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {

            $queryVentas->whereBetween('fecha_venta', [
                $request->fecha_desde . ' 00:00:00',
                $request->fecha_hasta . ' 23:59:59'
            ]);

        } else {

            if ($request->filled('fecha_desde')) {

                $queryVentas->whereDate(
                    'fecha_venta',
                    '>=',
                    $request->fecha_desde
                );

            }

            if ($request->filled('fecha_hasta')) {

                $queryVentas->whereDate(
                    'fecha_venta',
                    '<=',
                    $request->fecha_hasta
                );

            }

        }

        /*
        |--------------------------------------------------------------------------
        | OBTENER VENTAS
        |--------------------------------------------------------------------------
        */

        $ventas = $queryVentas->get();

        /*
        |--------------------------------------------------------------------------
        | PRODUCTO A EDITAR
        |--------------------------------------------------------------------------
        */

        $productoEditar = null;

        if ($request->has('editar')) {
            $productoEditar = Producto::find($request->editar);
        }

        /*
        |--------------------------------------------------------------------------
        | RETORNAR VISTA
        |--------------------------------------------------------------------------
        */

        return view('backend.admin.dashboard', compact(
            'totalClientes',
            'totalCategorias',
            'totalProductos',
            'totalVentas',
            'productos',
            'categorias',
            'usuarios',
            'ventas',
            'productoEditar'
        ));
    }
}