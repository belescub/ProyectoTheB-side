<?php

namespace App\Http\Controllers;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Se trae todas las categorias de la base de datos
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view ('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     * Solo se muestra el formulario vacio
     */
    public function create()
    {
        return view ('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Se valida que se ingrese verdaderamente un nombre
        $request->validate([
            'nombre'=>'requiered|string|max:255', 
            'descripcion' =>'nullable|string',
            ]);
        //Guardamos la categoria
        Categoria::create($request->all());
        return redirect()->route('categorias.index')->with('success', 'Categoria Creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['nombre'=>'required|string|max:255', 'descripcion'=>'nullable|string']);
        $categoria->update($request->all());
        return redirect()->route('categorias.index')->with('success', 'Categoria actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoria eliminada');
    }
}
