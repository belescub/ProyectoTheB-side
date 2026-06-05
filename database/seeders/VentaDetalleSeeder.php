<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VentaDetalle;

class VentaDetalleSeeder extends Seeder
{
    public function run(): void
    {
        
        VentaDetalle::create([
            'cantidad' => 1,
            'precio_unitario' => 45000.00,
            'subtotal' => 45000.00,
            'producto_id' => 1, // id del producto
            'venta_cabecera_id' => 1, // ID de la venta que creamos antes
        ]);

    
        VentaDetalle::create([
            'cantidad' => 1,
            'precio_unitario' => 12000.00,
            'subtotal' => 12000.00,
            'producto_id' => 2, // ID del producto 2
            'venta_cabecera_id' => 1, // Pertenece a la misma venta
        ]);
    }
}
