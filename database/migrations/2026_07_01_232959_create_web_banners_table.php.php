<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('web_banners', function (Blueprint $table) {
            $table->id();
            

            $table->string('producto_sku');
            $table->foreign('producto_sku')
                  ->references('sku')
                  ->on('web_productos')
                  ->onDelete('cascade');


            $table->string('titulo', 45); 
            $table->string('descripcion', 120); 
            

            $table->string('imagen_url'); 
            
            $table->integer('orden')->default(0); 
            $table->boolean('activo')->default(true);
            

            $table->date('fecha_fin')->nullable(); 

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('web_banners');
    }
};