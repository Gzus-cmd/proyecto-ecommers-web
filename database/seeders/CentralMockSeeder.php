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
        DB::table('central_productos_maestro')->truncate();
        DB::table('central_lotes')->truncate();
        Schema::enableForeignKeyConstraints();

        // Los 16 productos técnicos (Base para Central)
        $productosBase = [
            ['sku' => 'ANA-001', 'nombre' => 'Paracetamol', 'cat' => 'Analgésicos'],
            ['sku' => 'ANA-002', 'nombre' => 'Ácido Acetilsalicílico', 'cat' => 'Analgésicos'],
            ['sku' => 'ANA-003', 'nombre' => 'Tramadol Clorhidrato', 'cat' => 'Analgésicos'],
            ['sku' => 'ANT-001', 'nombre' => 'Amoxicilina', 'cat' => 'Antibióticos'],
            ['sku' => 'ANT-002', 'nombre' => 'Azitromicina', 'cat' => 'Antibióticos'],
            ['sku' => 'ANT-003', 'nombre' => 'Ciprofloxacino', 'cat' => 'Antibióticos'],
            ['sku' => 'AIN-001', 'nombre' => 'Ibuprofeno', 'cat' => 'Antiinflamatorios'],
            ['sku' => 'AIN-002', 'nombre' => 'Naproxeno', 'cat' => 'Antiinflamatorios'],
            ['sku' => 'AIN-003', 'nombre' => 'Diclofenaco Sódico', 'cat' => 'Antiinflamatorios'],
            ['sku' => 'VIT-001', 'nombre' => 'Ácido Ascórbico', 'cat' => 'Vitaminas'],
            ['sku' => 'VIT-002', 'nombre' => 'Magnesio', 'cat' => 'Vitaminas'],
            ['sku' => 'VIT-003', 'nombre' => 'Multivitamínico', 'cat' => 'Vitaminas'],
            ['sku' => 'VIT-004', 'nombre' => 'Vitaminas B1, B6, B12', 'cat' => 'Vitaminas'],
            ['sku' => 'DER-001', 'nombre' => 'Filtro UV SPF 50+', 'cat' => 'Dermatológicos'],
            ['sku' => 'DER-002', 'nombre' => 'Limpiador Facial', 'cat' => 'Dermatológicos'],
            ['sku' => 'DER-003', 'nombre' => 'Óxido de Zinc', 'cat' => 'Dermatológicos'],
        ];

        foreach ($productosBase as $p) {
            // Insertar en Maestro Técnico
            DB::table('central_productos_maestro')->insert([
                'sku' => $p['sku'],
                'nombre_tecnico' => '[SIMULACION CENTRAL] ' . $p['nombre'], 
                'principio_activo' => $p['nombre'],
                'categoria' => $p['cat'],
                'created_at' => now(),
            ]);

            // Insertar Lotes de prueba (Stock aleatorio)
            // Simulamos que algunos NO tienen stock (como DER-002) para probar el CRUD
            $stock = ($p['sku'] === 'DER-002' || $p['sku'] === 'AIN-002') ? 0 : rand(10, 500);

            DB::table('central_lotes')->insert([
                'sku' => $p['sku'], 
                'numero_lote' => 'LOTE-SIM-' . rand(100, 999), 
                'cantidad_actual' => $stock, 
                'fecha_vencimiento' => now()->addMonths(rand(6, 24)),
                'created_at' => now()
            ]);
        }
    }
}