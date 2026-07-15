<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('web_productos', function (Blueprint $table) {

            $table->text('dosificacion')->nullable()->after('descripcion');
            $table->text('advertencias')->nullable()->after('dosificacion');
            $table->text('almacenamiento')->nullable()->after('advertencias');
            
            $table->string('presentacion_web')->nullable()->after('forma_farmaceutica');
        });
    }

    public function down(): void
    {
        Schema::table('web_productos', function (Blueprint $table) {
            $table->dropColumn(['dosificacion', 'advertencias', 'almacenamiento', 'presentacion_web']);
        });
    }
};