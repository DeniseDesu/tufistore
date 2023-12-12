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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // ID de la orden
            $table->unsignedBigInteger('articulo_id'); // ID del artículo
            $table->integer('cantidad'); // Cantidad comprada
            $table->decimal('precio', 8, 2); // Precio por unidad en el momento de la compra
            $table->timestamps();
        
            // Claves foráneas y restricciones
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('articulo_id')->references('id')->on('articulos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
