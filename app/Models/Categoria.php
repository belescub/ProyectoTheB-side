<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
   use HasFactory; //Permite usar datos falsos (fakers) para llenar la base de datos en etapa de pruebas

    protected $table = 'categorias'; //Le indica a laravel como se llama la tabla en la base de datos
    
    //Medida de seguridad: Define que columnas se pueden llenar masivamente desde un formulario
    protected $fillable = [ 
        'nombre', 
        'descripcion', 
        'activo',
    ]; 

    /**
     * RELACION: 1 a Muchos (one to many)
     * Una categoria puede tener muchos productos
     * Uso: $categoria->productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
