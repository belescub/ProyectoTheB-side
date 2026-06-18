<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model {

    // Habilita factories y soft delete
    use HasFactory, SoftDeletes;

    // Nombre real de la tabla en la base de datos
    protected $table = 'roles';

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Relación: un rol tiene muchos usuarios
    // Ejemplo: $rol->usuarios
    public function usuarios() {
        return $this->hasMany(Usuario::class, 'rol_id');
    }
}
