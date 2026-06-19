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
    Schema::create('central_productos_maestro', function (Blueprint $table) {
       
        $table->string('sku')->primary(); 
        $table->string('nombre_tecnico');
        $table->string('principio_activo');
        $table->string('categoria');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('central_productos_maestro_simulacion');
    }
};
