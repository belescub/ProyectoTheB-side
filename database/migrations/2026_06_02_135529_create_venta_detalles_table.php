<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('venta_detalles', function (Blueprint $table) {
            $table->id(); //clave primaria, unica para cada venta_detalle
            $table->integer('cantidad'); //cuantas cantidades se lleva del producto
            $table->decimal('precio_unitario', 8, 2); //precio del producto al momento de la venta
            $table->decimal('subtotal', 8, 2);//subtotal de la venta
            $table->foreignId('producto_id')->constrained('productos');//clave foranea que conecta a la clase venta_Detalle con la clase producto
            $table->foreignId('venta_cabecera_id')->constrained('venta_cabeceras'); //clave foranea de venta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_detalles');
    }
};
