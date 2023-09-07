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
        Schema::create('productos', function (Blueprint $table) {
            /* 
                Nombre campo: id
                Tipo: Llave Primaria
            */
            $table->increments('id')->comment("Llave Primaria");

            /* Campos Personalizados */

                // Llave foránea id_marca
                $table->unsignedInteger("id_marca")->comment("Fk Id Marca");

                $table->unsignedInteger("id_categoria")->comment("Fk Id Categoría");                      

                $table->string("modelo",255)->unique()->comment("Modelo del Producto");

                $table->text("imagen")->comment("Imágen del Producto");

                $table->text("descripcion_1")->unique()->comment("Descripcion Número 1 del Producto");

                $table->text("descripcion_2")->nullable()->comment("Descripcion Número 2 del Producto");

                $table->string("precio",10)->comment("Precio unitario del producto");

                $table->string("slug")->unique()->comment("Ruta Url");
            //

            //Campos Create_at y Update_at
            $table->timestamps();

            /* Llaves Foraneas */
                $table->foreign("id_marca")->references("id")->on("marcas");
                
                $table->foreign("id_categoria")->references("id")->on("categorias");
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
