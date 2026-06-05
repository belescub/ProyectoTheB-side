<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria; // importamos el modelo

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        Categoria::create([
            'nombre' => 'Rock',
            'descripcion' => 'Cds y vinilos de rock',
        ]);

        Categoria::create([
            'nombre' => 'K-pop',
            'descripcion' => 'Cds y vinilos de K-pop',
        ]);
    }
}