<<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Crea la tabla 'venta_cabeceras' en la base de datos cuando ejecutamos 'php artisan migrate'
     */
    public function up(): void
    {
        Schema::create('venta_cabeceras', function (Blueprint $table) {
            // Clave primaria (ejemplo: número de ticket #1, #2, #3...)
            $table->id(); 
            
            // Guarda el monto total de la venta. 
            // Permite 10 dígitos en total, de los cuales 2 son decimales (ej: 99999999.99).
            // Si no le pasamos nada al crearla, por defecto arranca en 0.
            $table->decimal('total', 10, 2)->default(0); 
            
            // Registra la fecha y hora exacta en la que se realizó la venta
            $table->dateTime('fecha_venta');
            
            // Guarda el estado del ticket/pedido (ej: pendiente, pagado, despachado). 
            // Por defecto arranca en 'pendiente' apenas se crea la venta.
            $table->string('estado')->default('pendiente');
            
            // Clave foránea que relaciona este ticket con el cliente.
            // Le dice a Laravel: "El usuario_id de acá debe existir sí o sí en la tabla 'usuarios'".
            $table->foreignId('usuario_id')->constrained('usuarios');
            
            // Crea automáticamente las columnas 'created_at' y 'updated_at'.
            // Laravel las usa solito para saber cuándo se creó o se modificó el ticket.
            $table->timestamps();
            
            // Habilita el "borrado lógico"
            // Crea la columna 'deleted_at'. Si se borra la venta, no se pierde de la BD real, 
            // solo se le pone la fecha de borrado para mantener el historial.
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     * Destruye la tabla si necesitamos revertir los cambios 
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_cabeceras');
    }
};
