<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Venta_cabecera; 

class AdminController extends Controller
{
    public function index()
    {
        $totalClientes = Usuario::where('rol_id', 2)->count();
        $totalCategorias = Categoria::count();
        $totalProductos = Producto::count();
        $totalVentas = Venta_cabecera::whereMonth('fecha_venta', now()->month)
                                    ->whereYear('fecha_venta', now()->year)
                                    ->count();

        // 1. Necesitamos traer todas las categorías para el select del formulario
        $categorias = Categoria::all(); 

        $productos = Producto::with('categoria')->latest()->take(5)->get();

        $usuarios = Usuario::withTrashed()->get();

        $ventas = Venta_cabecera::with(['venta_detalles.producto', 'usuario'])
            ->latest()
            ->get();
        
        // --- PARA EL MODO EDICION ---
        $productoEditar = null;
        if (request()->has('editar')) {
            $productoEditar = Producto::find(request('editar'));
        }
        // -------------------------------------------

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

        // 2. LA MAGIA DE LA NUEVA CATEGORÍA
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

    public function darBaja($id){
        $usuario = Usuario::findOrFail($id);

        $usuario->delete(); // llena deleted_at

        return redirect()->back()->with('success', 'Usuario dado de baja');
    }

    public function hacerAdmin($id){
        $usuario = Usuario::findOrFail($id);

        $usuario->rol_id = 1; 
        $usuario->save();

        return back()->with('success', 'Usuario ahora es administrador');
    }


    // --------------------------------------------------------
    // FUNCIONES PARA EL INVENTARIO (EDITAR, ACTUALIZAR Y ELIMINAR)
    // --------------------------------------------------------

    public function edit($id){
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        
        // Retornamos una vista para editar el producto. 
        return view('backend.admin.editar', compact('producto', 'categorias'));
    }

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

    public function destroy($id){
        $producto = Producto::findOrFail($id);
        $producto->delete(); 

        return redirect('/admin?inventario=1')->with('success', '¡Producto eliminado del inventario!');
    }
}