<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class WebProductoSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('web_productos')->truncate();
        Schema::enableForeignKeyConstraints();

        $disponibles = DB::table('central_productos_maestro_simulacion')->limit(10)->get();

        foreach ($disponibles as $p) {
            $nombre = str_replace('[SIMULACIÓN] ', '', $p->nombre_tecnico);
            DB::table('web_productos')->insert([
                'sku' => $p->sku,
                'nombre_comercial' => $nombre . ' - Oferta Web',
                'nombre_generico' => $p->principio_activo,
                'slug' => Str::slug($nombre),
                'precio_web' => rand(10, 90) + 0.90,
                'disponible' => true,
                'imagen_url' => 'https://via.placeholder.com/400x400.png?text=' . urlencode($nombre),
                'created_at' => now()
            ]);
        }
    }
}