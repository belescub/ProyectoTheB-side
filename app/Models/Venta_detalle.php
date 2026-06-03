<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venta_detalle extends Model
{
    use HasFactory;
    
    protected $table = 'venta_detalles';

    protected $fillable = [
        'cantidad', 
        'precio_unitario',
        'subtotal',
        'producto_id',
        'venta_cabecera_id',
    ];
    
    //Relacion: inversa de 1 a muchos
    //Este reglos del ticket pertenece a un producto especifico. 
    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    //Pertence a una sola venta especifica (para saber que ticket es)
    public function venta_cabecera(){
        return $this->belongsTo(Venta_cabecera::class);
    }
}
