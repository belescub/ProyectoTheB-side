<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta_cabecera extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'venta_cabeceras'; //a que tabla de la base de datos corresponde este modelo

    //lista blanca de campos que se pueden guardar masivamente
    protected $fillable = [
        'total', 
        'fecha_venta',
        'estado',
    ];

    /**
     * Relacion: 1 a muchos (has many)
     * Una venta (el ticket general) tiene muchos detalles
     */
    public function venta_detalles(){
        return $this->hasMany(Venta_detalle::class);
    }

    //Relacion: este ticket le pertenece a un usuario específico.
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    } 
}
