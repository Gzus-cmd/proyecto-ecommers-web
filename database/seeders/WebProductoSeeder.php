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


        $infoPorCategoria = [
            'Analgésicos' => [
                'dosificacion' => 'Adultos y niños mayores de 12 años: 1 a 2 tabletas cada 6 u 8 horas. No exceder de 6 tabletas al día.',
                'advertencias' => 'No usar en personas con hipersensibilidad al principio activo. Si los síntomas persisten, consulte a su médico.',
                'almacenamiento' => 'Mantener en un lugar fresco y seco, protegido de la luz directa, a temperatura no mayor a 30°C.',
                'presentacion' => 'Caja x 100 Tabletas'
            ],
            'Antibióticos' => [
                'dosificacion' => 'Tomar según prescripción médica estricta. Generalmente 1 cápsula cada 8 o 12 horas por un periodo de 7 a 10 días.',
                'advertencias' => 'Venta bajo receta médica. No suspenda el tratamiento antes del tiempo indicado, incluso si se siente mejor.',
                'almacenamiento' => 'Conservar bien cerrado en su envase original, lejos de la humedad y el alcance de los niños.',
                'presentacion' => 'Caja x 20 Cápsulas'
            ],
            'Antiinflamatorios' => [
                'dosificacion' => '1 tableta cada 8 horas, preferiblemente después de los alimentos para evitar irritación gástrica.',
                'advertencias' => 'Evitar en pacientes con gastritis activa o úlceras. No consumir junto con bebidas alcohólicas.',
                'almacenamiento' => 'Almacenar en ambiente seco y fresco. No requiere refrigeración.',
                'presentacion' => 'Caja x 50 Tabletas'
            ],
            'Vitaminas' => [
                'dosificacion' => 'Tomar 1 cápsula al día, preferiblemente por la mañana junto con el desayuno.',
                'advertencias' => 'No es un sustituto de una dieta equilibrada. No exceder la dosis recomendada.',
                'almacenamiento' => 'Mantener el frasco herméticamente cerrado en un lugar sin humedad y a temperatura ambiente.',
                'presentacion' => 'Frasco x 60 Cápsulas Blandas'
            ],
            'Dermatológicos' => [
                'dosificacion' => 'Aplicar una capa delgada sobre el área afectada 2 o 3 veces al día, previo lavado de manos.',
                'advertencias' => 'Solo para uso externo. Evitar el contacto con ojos y mucosas. Si observa irritación, suspenda su uso.',
                'almacenamiento' => 'No congelar. Mantener el tubo bien tapado después de cada uso.',
                'presentacion' => 'Tubo x 40g - Crema'
            ],
        ];

        foreach ($maestros as $m) {
            $nombreComercial = str_replace('[SIM] ', '', $m->nombre_tecnico);
            

            $extraInfo = $infoPorCategoria[$m->categoria] ?? [
                'dosificacion' => 'Consulte a su médico para las instrucciones de uso.',
                'advertencias' => 'Mantener fuera del alcance de los niños.',
                'almacenamiento' => 'Conservar en lugar fresco.',
                'presentacion' => 'Unidad Estándar'
            ];

            DB::table('web_productos')->insert([
                'sku' => $m->sku,
                'nombre_comercial' => $nombreComercial . ' - Genérico MK',
                'nombre_generico' => $m->principio_activo,
                'slug' => Str::slug($nombreComercial . '-' . $m->sku),
                'descripcion' => 'Medicamento farmacéutico certificado para el tratamiento de afecciones en la categoría ' . $m->categoria . '. Formulado con estándares internacionales de calidad.',
                

                'dosificacion' => $extraInfo['dosificacion'],
                'advertencias' => $extraInfo['advertencias'],
                'almacenamiento' => $extraInfo['almacenamiento'],
                'presentacion_web' => $extraInfo['presentacion'],
                
                'concentracion' => 'Concentración Estándar',
                'forma_farmaceutica' => (str_contains($m->categoria, 'Dermatológicos')) ? 'Crema Tópica' : 'Tabletada / Cápsula',
                'precio_web' => rand(15, 150) + 0.90,
                'requiere_receta' => in_array($m->categoria, ['Antibióticos']),
                'disponible' => true,
                'imagen_url' => "https://placehold.co/800x800/F8FAFC/072D44?text=" . urlencode($nombreComercial),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}