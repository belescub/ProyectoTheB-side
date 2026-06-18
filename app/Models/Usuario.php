<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable {

    // Habilita factories, notificaciones y borrado lógico
    use HasFactory, Notifiable, SoftDeletes;

    // Nombre de la tabla
    protected $table = 'usuarios';

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol_id'
    ];

    // Campos ocultos (no visibles en JSON)
    protected $hidden = [
        'password',
        'remember_token'
    ];

    // Conversión automática de atributos
    protected function casts(): array {
        return [
            // Laravel hashea automáticamente la contraseña
            'password' => 'hashed',
        ];
    }

    // Relación: un usuario pertenece a un rol
    // Ejemplo: $usuario->rol
    public function rol() {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    // Relación: un usuario tiene muchas ventas
    // Ejemplo: $usuario->ventas
    public function ventas(){
        return $this->hasMany(VentaCabecera::class, 'usuario_id');
    }
}