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

        $maestros = DB::table('central_productos_maestro_simulacion')->get();

        foreach ($maestros as $m) {
            $nombreComercial = str_replace('[SIM] ', '', $m->nombre_tecnico);
            
            DB::table('web_productos')->insert([
                'sku' => $m->sku,
                'nombre_comercial' => $nombreComercial . ' - Genérico MK',
                'nombre_generico' => $m->principio_activo,
                'slug' => Str::slug($nombreComercial . '-' . $m->sku),
                'descripcion' => 'Medicamento certificado para el tratamiento de afecciones en la categoría ' . $m->categoria,
                'concentracion' => 'Según Ficha Técnica',
                'forma_farmaceutica' => 'Tabletas/Crema',
                'precio_web' => rand(15, 120) + 0.90,
                'requiere_receta' => in_array($m->categoria, ['Antibióticos']),
                'disponible' => true,
                'imagen_url' => "https://placehold.co/600x600/072D44/FFFFFF?text=" . urlencode($nombreComercial),
                'created_at' => now(),
            ]);
        }
    }
}