<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * crea la tabla ventas en la base de datos cuando corremos el migrate
     */
    public function up(): void
    {
        Schema::create('venta_cabeceras', function (Blueprint $table) {
            $table->id(); //clave primaria autoincremental (ejemplo: ticket #1, #2)
            //guarda el monto total de la venta. Permite 10 digitos en total, 2 osn decimales
            $table->decimal('total', 10, 2)->default(0); 
            $table->dateTime('fecha_venta');
            $table->string('estado')->default('pendiente');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     * destruye la tabla si necesitamos revertir los cambios
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_cabeceras');
    }
};
