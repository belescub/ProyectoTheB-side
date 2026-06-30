<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra la lista de TODOS los productos (la pantalla principal)
     */
    public function index()
    {
        /**
         * Se trae todos los productos
         * Se usa with('categoria') para evitar el problema de N+1 
         * Esto hace que la consulta sea rapida
         * Se trae solo los productos que tengan stock mayor a 0.
         * Lo que tenga 0 o menos, simplemente no se envía a la vista.
         */
        $productos = Producto::with('categoria')
                             ->where('stock', '>', 0)
                             ->paginate(12);

        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     * Muestra el formulario vacio para crear un nuevo producto
     */
    public function create()
    {
        //Se necesitan todas las categorias activas para armar el <select> en el form
        $categorias = Categoria::where('activo', true)->get();

        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     * Recibe los datos del formulario de 'create' y los GUARDA en la base de datos.
     */
    public function store(Request $request)
    {
        //Validamos que el usuario no nos mande basura o campos vacios
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'precio'   => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id', //verifica que la categoria exista
            'url_imagen'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', //deja pasar la imagen
        ]);

        // 1. Guardamos todos los datos del formulario en una variable
        $datosProducto = $request->all();

        // 2. Verificamos si el usuario subió un archivo físico de imagen
        if ($request->hasFile('url_imagen')) {
            // Guarda la imagen en storage/app/public/productos y devuelve la ruta
            $rutaImagen = $request->file('url_imagen')->store('productos', 'public');
            // Reemplazamos la imagen temporal por la ruta final para la base de datos
            $datosProducto['url_imagen'] = $rutaImagen;
        }

        // 3. Guardamos el producto con la ruta de la imagen correcta
        Producto::create($datosProducto);
        
        //Redirigimos al usuario a la lista con un mensaje de exito
        return redirect()->route('admin.index', ['inventario' => 1])
                            ->with('success', 'Producto creado con éxito');
    }

    /**
     * Display the specified resource.
     * Muestra el detalle de Un solo producto
     */
    public function show(Producto $producto)
    {
        //Laravel ya buscó el $producto por las dependencias
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario para EDITAR, ya precargado con los datos del producto.
     */
    public function edit(Producto $producto)
    {
        //Esto nos permite tener las categorias para el desplegable
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     * Recibe los datos modificados del formulario 'edit' y ACTUALIZA la base de datos.
     */
    public function update(Request $request, Producto $producto)
    {
        // Validamos los datos nuevos
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'precio'       => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id', 
            'url_imagen'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 1. Guardamos todos los datos que vinieron del formulario edit
        $datosProducto = $request->all();

        // 2. Si el usuario subió una NUEVA imagen para reemplazar la vieja
        if ($request->hasFile('url_imagen')) {
            $rutaImagen = $request->file('url_imagen')->store('productos', 'public');
            $datosProducto['url_imagen'] = $rutaImagen;
        }

        // 3. Actualizamos el registro existente con los datos (y la posible nueva imagen)
        $producto->update($datosProducto);

        // Redirigimos a la lista
        return redirect()->route('admin.index', ['inventario' => 1])
                    ->with('success', '¡Producto actualizado correctamente!');
    }
    /**
     * Remove the specified resource from storage.
     * Elimina un producto de la base de datos
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('admin.index', ['inventario' => 1])
                        ->with('success', 'Producto eliminado correctamente');
    }
    public function buscar(Request $request){
        // Capturamos lo que el usuario ingresó en el input name="q"
        $query = $request->input('q');

        // Buscamos en el modelo Producto coincidencias asegurando que obligatoriamente el stock sea mayor a 0
        $productos = Producto::where('stock', '>', 0)
                             ->where(function($q) use ($query) {
                                 $q->where('nombre', 'LIKE', "%{$query}%")
                                   ->orWhere('descripcion', 'LIKE', "%{$query}%");
                             })
                             ->paginate(12);
        // Como productos.blade.php está en la raíz de views, solo ponemos 'productos'
        return view('productos', compact('productos', 'query'));
    }
}
