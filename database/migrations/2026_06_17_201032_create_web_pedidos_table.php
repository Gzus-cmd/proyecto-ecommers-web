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
    Schema::create('web_pedidos', function (Blueprint $table) {
        $table->id();
        // Relaciones (Asegúrate de que estas tablas existan o se creen antes)
        $table->foreignId('cliente_id')->constrained('web_clientes')->onDelete('cascade');
        $table->integer('sede_recojo_id')->nullable(); 
        $table->integer('direccion_envio_id')->nullable(); 
        $table->integer('estado_id')->default(1); 
        
        $table->timestamp('fecha_pedido')->useCurrent();
        $table->decimal('subtotal', 10, 2);
        $table->decimal('impuesto', 10, 2);
        $table->decimal('total', 10, 2);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_pedidos');
    }
};
