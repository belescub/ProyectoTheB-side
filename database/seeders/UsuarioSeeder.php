<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            [
                'nombre' => 'belen',
                'email' => 'bel@gmail.com',
                'password' => Hash::make('password'), // Cambiala por la contraseña real que usabas
                'rol_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'micaela',
                'email' => 'micaela@gmail.com',
                'password' => Hash::make('micaela123'), 
                'rol_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
