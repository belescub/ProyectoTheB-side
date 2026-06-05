<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::create([
            'nombre' => 'Arirang',
            'descripcion' => 'Cd Arirang BTS',
            'precio' => 45000.00,
            'stock' => 15,
            'categoria_id' => 2, 
        ]);

        Producto::create([
            'nombre' => 'Wings',
            'descripcion' => 'Cd Wings BTS',
            'precio' => 12000.00,
            'stock' => 50,
            'categoria_id' => 2, // ID 2 = Kpop
        ]);
    }
}
