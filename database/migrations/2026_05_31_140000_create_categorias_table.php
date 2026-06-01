<?php
 //se cambio la fecha de la tabla categorias. Ya que laravel ejecuta segun como se fueron creando, y como primero se creo la tabla de 
 //Productos cuando trate de buscar el aributo id_categoria no la va a encontrar, ya que esa tabla todavia no se ejecuto
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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id(); //clave primaria
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true); //estado de la categoria
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
