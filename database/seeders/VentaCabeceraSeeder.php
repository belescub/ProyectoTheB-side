<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VentaCabecera;
use Carbon\Carbon; // Para manejar la fecha actual

class VentaCabeceraSeeder extends Seeder
{
    public function run(): void
    {
        // Creamos una venta que en total sumará 57.000 (45.000 + 12.000)
        VentaCabecera::create([
            'total' => 57000.00,
            'fecha_venta' => Carbon::now(),
            'estado' => 'pagado',
        ]);
    }
}
