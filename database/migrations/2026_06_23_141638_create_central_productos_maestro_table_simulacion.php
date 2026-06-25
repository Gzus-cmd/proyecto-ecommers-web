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
    Schema::create('central_productos_maestro_simulacion', function (Blueprint $table) {
        
        $table->string('sku')->primary(); 
        $table->string('nombre_tecnico'); 
        $table->string('principio_activo'); 
        $table->string('categoria'); 
        $table->string('laboratorio')->nullable();
        $table->string('presentacion')->nullable(); 
        $table->boolean('requiere_receta')->default(false);
        $table->timestamps();
        $table->comment('TABLA DE SIMULACIÓN: Catálogo Maestro del Almacén Central');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('central_productos_maestro_table_simulacion');
    }
};
