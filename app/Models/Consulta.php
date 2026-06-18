<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consulta extends Model
{
    // Habilita factories y soft delete
    use HasFactory, SoftDeletes;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',      // nombre del cliente
        'telefono',    // teléfono del cliente
        'email',       // correo del cliente
        'mensaje',     // consulta enviada
        'leido',       // estado de lectura
        'respuesta'    // respuesta del administrador
    ];
}
