<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Este metodo se ejecuta cuando corremos 'php artisan migrate' 
     * Su funcion es CREAR la estructura de la tabla en la base de datos 
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) { //Le dice a laravel que cree una tabla nueva
            $table->id(); //es una clave primaria: es unica para cada producto
            $table->string('nombre'); //textos cortos: VARCHAR(255) en la base
            $table->text('descripcion')->nullable(); //El `nullable()` permite que ese campo quede vacio.
            $table->decimal('precio', 8, 2);      // Numeros decimales, 8 digitos en total, 2 de ellos son los decimales. hasta 99999
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('activo')->default(true); //Por defecto los productor nacen activos(true)
            $table->string('url_imagen')->nullable(); //Ruta de la imagen. Puede quedar vacia si el prooducto aun no tiene foto
            $table->foreignId('categoria_id')->constrained('categorias');//CLAVE FORANEA: Conecta este producto con un id que debe existir en la tabla de categoria
            $table->timestamps(); //Crea automaticamente las columnas "created_at" y "update_at". Los timestamps siempre se dejan al final de todo, si se quiere agregar atributos nuevos. 
            $table->softDeletes();//Crea la columna delete_at
        });
    }

    /**
     * Reverse the migrations.
     * Este método se ejecuta cuando hace un 'rollback' o 'migrate:fresh'.
     * Su función es DESTRUIR la tabla si necesitamos revertir los cambios.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
