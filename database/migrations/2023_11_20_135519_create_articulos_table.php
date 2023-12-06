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
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
            $table->integer('stock');
            $table->integer('precio');
            $table->text('img');
            $table->boolean('is_visible')->default(true); //dif entre borrado fisico y logico, entonces se debe borrar algo, pero debe seguirse viendo en la DB, pero en la view NO
            //Foreign key categorias.
            $table->unsignedBigInteger('categoria_id'); //defino el nombre de la columna q trae la info de categoria
            $table->foreign('categoria_id')->references('id')->on('categorias'); //definimos el nombre de la columna a joinear y tabla.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
