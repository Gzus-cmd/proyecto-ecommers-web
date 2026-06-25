<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CentralMockSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('central_sedes_simulacion')->truncate();
        DB::table('central_productos_maestro_simulacion')->truncate();
        DB::table('central_lotes_simulacion')->truncate();
        Schema::enableForeignKeyConstraints();


        $sedes = [
            ['id' => 1, 'codigo' => 'SEDE-CENTRO', 'nombre' => 'PharmaVictoria - Lima Centro'],
            ['id' => 2, 'codigo' => 'SEDE-NORTE', 'nombre' => 'PharmaVictoria - Los Olivos'],
        ];
        DB::table('central_sedes_simulacion')->insert($sedes);


        $productos = [
            ['sku' => 'ANA-001', 'nom' => 'Paracetamol', 'cat' => 'Analgésicos'],
            ['sku' => 'ANA-002', 'nom' => 'Aspirina', 'cat' => 'Analgésicos'],
            ['sku' => 'ANA-003', 'nom' => 'Tramadol', 'cat' => 'Analgésicos'],
            ['sku' => 'ANT-001', 'nom' => 'Amoxicilina', 'cat' => 'Antibióticos'],
            ['sku' => 'ANT-002', 'nom' => 'Azitromicina', 'cat' => 'Antibióticos'],
            ['sku' => 'ANT-003', 'nom' => 'Ciprofloxacino', 'cat' => 'Antibióticos'],
            ['sku' => 'AIN-001', 'nom' => 'Ibuprofeno', 'cat' => 'Antiinflamatorios'],
            ['sku' => 'AIN-002', 'nom' => 'Naproxeno', 'cat' => 'Antiinflamatorios'],
            ['sku' => 'AIN-003', 'nom' => 'Diclofenaco', 'cat' => 'Antiinflamatorios'],
            ['sku' => 'VIT-001', 'nom' => 'Ácido Ascórbico', 'cat' => 'Vitaminas'],
            ['sku' => 'VIT-002', 'nom' => 'Magnesio', 'cat' => 'Vitaminas'],
            ['sku' => 'VIT-003', 'nom' => 'Multivitamínico', 'cat' => 'Vitaminas'],
            ['sku' => 'VIT-004', 'nom' => 'Complejo B', 'cat' => 'Vitaminas'],
            ['sku' => 'DER-001', 'nom' => 'Protector Solar', 'cat' => 'Dermatológicos'],
            ['sku' => 'DER-002', 'nom' => 'Crema Hidratante', 'cat' => 'Dermatológicos'],
            ['sku' => 'DER-003', 'nom' => 'Óxido de Zinc', 'cat' => 'Dermatológicos'],
        ];

        foreach ($productos as $p) {
            DB::table('central_productos_maestro_simulacion')->insert([
                'sku' => $p['sku'],
                'nombre_tecnico' => '[SIMULACIÓN] ' . $p['nom'],
                'principio_activo' => $p['nom'],
                'categoria' => $p['cat'],
                'created_at' => now()
            ]);


            foreach ([1, 2] as $sedeId) {
                DB::table('central_lotes_simulacion')->insert([
                    'sku' => $p['sku'],
                    'sede_id' => $sedeId,
                    'numero_lote' => 'L-' . ($sedeId == 1 ? 'CEN' : 'NOR') . '-' . rand(100, 999),
                    'cantidad_actual' => rand(0, 100),
                    'fecha_vencimiento' => now()->addMonths(rand(6, 24)),
                    'created_at' => now()
                ]);
            }
        }
    }
}