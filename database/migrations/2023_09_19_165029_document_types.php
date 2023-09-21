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
        Schema::create('document_types', function (Blueprint $table) {

            //Llave primaria
            $table->integerIncrements('id')->comment("Llave Primaria");

            /* Campos Personalizados */
                $table->string("name",50)->unique()->comment("nombre del tipo de documento");

                $table->string("abbreviation",10)->unique()->comment("abreviatura del tipo de documento");
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
        Schema::dropIfExists('document_types');
    }
};
