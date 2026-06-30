<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model{

    //Habilita las fabricas de datos de prueba y activa el borrado logico
    use HasFactory, SoftDeletes;

    protected $table    = 'productos'; //Nombre exacto de la tabla en la base de datos
    //Lista blanca de atributos que el administrador puede guardad desde un formulario 
    protected $fillable = [ 
            'nombre', 
            'descripcion', 
            'precio', 
            'stock', 
            'url_imagen', 
            'activo', 
            'categoria_id', //Permite que laravel guarde la relacion
    ]; 

    //Transforma automaticamente los tipos de datos cuando los traemos de la base de datos
    protected $casts = [ 
            'precio' => 'decimal:2',  //asegura que siempre tenga dos decimales
            'stock' => 'integer',  //lo convierte a numero entero
            'activo' => 'boolean', //lo convierte a true/false (en la BD se guarda como 1 o 0)
    ]; 

    /**
     * Relacion: inversa de 1 a muchos (belongs to)
     * Un producto PERTENECE A UNA sola categoría
     * uso: $producto->categoria->nombre
     */ 
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    /**
     * Funcion para los decimales, formatea el precio
     */ 
    public function getPrecioFormateadoAttribute(){
    // number_format(número, decimales, separador_decimal, separador_miles)
    return number_format($this->precio, 2, ',', '.');
}
}
