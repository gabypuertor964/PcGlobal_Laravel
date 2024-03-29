<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla: Tipos de PQRS
     */
    public function up(): void
    {
        Schema::create('pqrs_types', function (Blueprint $table) {

            //Llave primaria
            $table->unsignedInteger('id',true)->comment("Llave Primaria");

            /* Campos personalizados */
                $table->string("name",30)->unique()->comment("Nombre del tipo de PQRS");
            //

            //Campos create_at y update_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pqrs_types');
    }
};
