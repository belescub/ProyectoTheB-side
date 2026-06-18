<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]

class User extends Authenticatable
{
    // Modelo User por defecto de Laravel
    use HasFactory, Notifiable;

    /**
     * Define conversiones automáticas de atributos
     */
    protected function casts(): array
    {
        return [
            // Convierte fecha de verificación en datetime
            'email_verified_at' => 'datetime',

            // Hashea automáticamente la contraseña
            'password' => 'hashed',
        ];
    }
}
