<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Venta_cabecera; 
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
         // Cuenta cantidad de clientes
        $totalClientes = Usuario::where('rol_id', 2)->count();
        // Cuenta categorías
        $totalCategorias = Categoria::count();
         // Cuenta productos
        $totalProductos = Producto::count();
        // Cuenta ventas del mes actual
        $totalVentas = Venta_cabecera::whereMonth('fecha_venta', now()->month)
                                    ->whereYear('fecha_venta', now()->year)
                                    ->count();

        // 1. Necesitamos traer todas las categorías para el select del formulario
        $categorias = Categoria::all(); 

        // Esto trae TODO el inventario, pero ordenado por el más reciente primero
        $productos = Producto::latest()->get();

        // Trae usuarios, incluso los eliminados (soft delete)
        $usuarios = Usuario::withTrashed()->get();

         // Trae ventas con detalles y usuario
        $queryVentas = Venta_cabecera::with(['venta_detalles.producto', 'usuario'])->latest();

        // Si estamos en la pestaña de ventas, aplicamos los filtros
        if (request()->has('ventas')) {
            $buscar = request('buscar');
            $criterio = request('criterio');
            $fecha = request('fecha');

            // 1. FILTRO DE TEXTO (Por Producto o Cliente)
            if (!empty($buscar)) {
                if ($criterio == 'cliente') {
                    // Buscamos dentro de la tabla de usuarios relacionados
                    $queryVentas->whereHas('usuario', function($q) use ($buscar) {
                        $q->where('nombre', 'LIKE', '%' . $buscar . '%');
                    });
                } elseif ($criterio == 'producto') {
                    // Buscamos en el nombre del producto, en su descripción o en su categoría
                    $queryVentas->whereHas('venta_detalles.producto', function($q) use ($buscar) {
                        $q->where('nombre', 'LIKE', '%' . $buscar . '%')
                          ->orWhere('descripcion', 'LIKE', '%' . $buscar . '%')
                          ->orWhereHas('categoria', function($catQuery) use ($buscar) {
                              $catQuery->where('nombre', 'LIKE', '%' . $buscar . '%');
                          });
                    });
                }
            }

            // 2. FILTRO DE FECHAS
            if (!empty($fecha) && $fecha != 'todas') {
                switch ($fecha) {
                    case 'hoy':
                        $queryVentas->whereDate('fecha_venta', Carbon::today());
                        break;
                    case 'semana':
                        $queryVentas->whereBetween('fecha_venta', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                        break;
                    case 'mes':
                        // Ventas de los últimos 30 días
                        $queryVentas->where('fecha_venta', '>=', Carbon::now()->subMonth());
                        break;
                    case 'anio':
                        // Ventas del último año
                        $queryVentas->where('fecha_venta', '>=', Carbon::now()->subYear());
                        break;
                    case 'mas_anio':
                        // Ventas anteriores a un año
                        $queryVentas->where('fecha_venta', '<', Carbon::now()->subYear());
                        break;
                }
            }
        }

        // Finalmente, ejecutamos la consulta y traemos los resultados
        $ventas = $queryVentas->get();
        // --- PARA EL MODO EDICION ---
        $productoEditar = null;
        if (request()->has('editar')) {
            $productoEditar = Producto::find(request('editar'));
        }
        // -------------------------------------------
        // Retorna dashboard admin con toda la info
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

    // 2. Nueva función para procesar el formulario y guardar el producto
public function store(Request $request)
    {
        // 1. Validamos los datos (Fijate que cambiamos la validación de categoría)
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required', // Quitamos el exists temporalmente porque puede llegar el string "nueva"
            'nueva_categoria_nombre' => 'required_if:categoria_id,nueva|nullable|string|max:255',
            'url_imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        // 2. NUEVA CATEGORÍA
        if ($request->categoria_id === 'nueva') {
            // Creamos la categoría primero
            $nuevaCategoria = Categoria::create([
                'nombre' => $request->nueva_categoria_nombre,
                'activo' => 1 // Asumimos que la creas activa por defecto
            ]);
            // Reemplazamos el string "nueva" por el ID real que se acaba de generar en la DB
            $data['categoria_id'] = $nuevaCategoria->id;
        } else {
            // Si eligió una existente, validamos por las dudas que el ID exista en la BD
            $request->validate(['categoria_id' => 'exists:categorias,id']);
        }

        // 3. Procesamos la imagen
        if ($request->hasFile('url_imagen')) {
            $path = $request->file('url_imagen')->store('productos', 'public');
            $data['url_imagen'] = $path; 
        }

        // 4. Creamos el producto final (ya con el categoria_id correcto)
        Producto::create($data);

        return redirect('/admin')->with('success', '¡Producto agregado con éxito!');
    }

    // Da de baja usuario (soft delete)
    public function darBaja($id){
    $usuario = Usuario::findOrFail($id);

    // evitar que el admin se elimine a sí mismo
    if(auth()->id() == $usuario->id){
        return redirect()->back()->with('error', 'No puedes darte de baja a ti mismo');
    }

    $usuario->delete(); // llena deleted_at

    return redirect()->back()->with('success', 'Usuario dado de baja');
}
    // Convierte usuario en admin 
    public function hacerAdmin($id){
        $usuario = Usuario::findOrFail($id);

        $usuario->rol_id = 1; 
        $usuario->save();

        return back()->with('success', 'Usuario ahora es administrador');
    }


    // --------------------------------------------------------
    // FUNCIONES PARA EL INVENTARIO (EDITAR, ACTUALIZAR Y ELIMINAR)
    // --------------------------------------------------------
     // Muestra formulario editar producto
    public function edit($id){
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        
        // Retornamos una vista para editar el producto. 
        return view('backend.admin.editar', compact('producto', 'categorias'));
    }
     // Actualiza producto existente
    public function update(Request $request, $id){
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'url_imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Es nullable porque puede que no quiera cambiar la foto
        ]);

        $data = $request->except(['url_imagen']);

        // Si se sube una imagen nueva, la guardamos y reemplazamos la anterior
        if ($request->hasFile('url_imagen')) {
            $path = $request->file('url_imagen')->store('productos', 'public');
            $data['url_imagen'] = $path; 
        }

        $producto->update($data);

        return redirect('/admin?inventario=1')->with('success', '¡Producto actualizado correctamente!');
    }
     // Elimina producto
    public function destroy($id){
        $producto = Producto::findOrFail($id);
        $producto->delete(); 

        return redirect('/admin?inventario=1')->with('success', '¡Producto eliminado del inventario!');
    }
}