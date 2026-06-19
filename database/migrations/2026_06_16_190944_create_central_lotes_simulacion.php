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
    Schema::create('central_lotes', function (Blueprint $table) {
        $table->id();
        $table->string('sku');
        $table->string('numero_lote');
        $table->integer('cantidad_actual');
        $table->date('fecha_vencimiento');
        $table->timestamps();

        
        $table->foreign('sku')
              ->references('sku')
              ->on('central_productos_maestro')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('central_lotes_simulacion');
    }
};
