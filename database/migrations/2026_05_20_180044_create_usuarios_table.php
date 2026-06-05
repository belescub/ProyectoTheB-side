<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('usuarios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('email')->unique();
        $table->string('password');

        $table->foreignId('rol_id')
              ->constrained('roles')
              ->onDelete('restrict');

        $table->rememberToken();
        $table->timestamps();
        $table->softDeletes(); // Habilita el borrado lógico (SoftDeletes) 
                            // Agrega la columna 'deleted_at'. Si se borra al usuario, no se elimina de la base de datos real, 
                            // solo se le marca la fecha de borrado para mantener el historial intacto.
        });
    }
};
