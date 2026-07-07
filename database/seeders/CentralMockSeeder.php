<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CentralMockSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('central_sedes_simulacion')->truncate();
        DB::table('central_categorias_simulacion')->truncate();
        DB::table('central_productos_maestro_simulacion')->truncate();
        DB::table('central_lotes_simulacion')->truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Sedes
        $sedes = [
            ['id' => 1, 'codigo' => 'SEDE-CENTRO', 'nombre' => 'PharmaVictoria - Lima Centro'],
            ['id' => 2, 'codigo' => 'SEDE-NORTE', 'nombre' => 'PharmaVictoria - Los Olivos'],
        ];
        DB::table('central_sedes_simulacion')->insert($sedes);

        // 2. Definición de Categorías con sus Logos de Lucide
        $categoriasData = [
            ['nombre' => 'Analgésicos', 'icono' => 'Pill'],
            ['nombre' => 'Antibióticos', 'icono' => 'FlaskConical'],
            ['nombre' => 'Antiinflamatorios', 'icono' => 'Activity'],
            ['nombre' => 'Vitaminas', 'icono' => 'Zap'],
            ['nombre' => 'Dermatológicos', 'icono' => 'Sparkles'],
            ['nombre' => 'Cardiovascular', 'icono' => 'HeartPulse'],
        ];

        $catMap = []; 
        foreach ($categoriasData as $c) {
            $id = DB::table('central_categorias_simulacion')->insertGetId([
                'nombre' => $c['nombre'],
                'slug' => Str::slug($c['nombre']),
                'icono_lucide' => $c['icono'],
                'created_at' => now(),
            ]);
            $catMap[$c['nombre']] = $id;
        }

        // 3. Definición de Productos
        $productos = [
            // ANALGÉSICOS
            ['sku' => 'ANA-001', 'nom' => 'Paracetamol 500mg', 'principio' => 'Paracetamol', 'cat' => 'Analgésicos'],
            ['sku' => 'ANA-002', 'nom' => 'Ácido Acetilsalicílico 100mg', 'principio' => 'Aspirina', 'cat' => 'Analgésicos'],
            ['sku' => 'ANA-003', 'nom' => 'Tramadol Clorhidrato 50mg', 'principio' => 'Tramadol', 'cat' => 'Analgésicos'],
            ['sku' => 'ANA-004', 'nom' => 'Clonixinato de Lisina 125mg', 'principio' => 'Dorixina', 'cat' => 'Analgésicos'],
            ['sku' => 'ANA-005', 'nom' => 'Metamizol Sódico 500mg', 'principio' => 'Antalgina', 'cat' => 'Analgésicos'],
            ['sku' => 'ANA-006', 'nom' => 'Ergotamina + Cafeína', 'principio' => 'Migradorixina', 'cat' => 'Analgésicos'],

            // ANTIBIÓTICOS
            ['sku' => 'ANT-001', 'nom' => 'Amoxicilina 500mg', 'principio' => 'Amoxicilina', 'cat' => 'Antibióticos'],
            ['sku' => 'ANT-002', 'nom' => 'Azitromicina 500mg', 'principio' => 'Azitromicina', 'cat' => 'Antibióticos'],
            ['sku' => 'ANT-003', 'nom' => 'Ciprofloxacino 500mg', 'principio' => 'Ciprofloxacino', 'cat' => 'Antibióticos'],
            ['sku' => 'ANT-004', 'nom' => 'Cefalexina 500mg', 'principio' => 'Cefalexina', 'cat' => 'Antibióticos'],
            ['sku' => 'ANT-005', 'nom' => 'Claritromicina 500mg', 'principio' => 'Claritromicina', 'cat' => 'Antibióticos'],
            ['sku' => 'ANT-006', 'nom' => 'Nitrofurantoína 100mg', 'principio' => 'Macrodantina', 'cat' => 'Antibióticos'],

            // ANTIINFLAMATORIOS
            ['sku' => 'AIN-001', 'nom' => 'Ibuprofeno 400mg', 'principio' => 'Ibuprofeno', 'cat' => 'Antiinflamatorios'],
            ['sku' => 'AIN-002', 'nom' => 'Naproxeno Sódico 550mg', 'principio' => 'Apronax', 'cat' => 'Antiinflamatorios'],
            ['sku' => 'AIN-003', 'nom' => 'Diclofenaco Sódico 50mg', 'principio' => 'Voltaren', 'cat' => 'Antiinflamatorios'],
            ['sku' => 'AIN-004', 'nom' => 'Meloxicam 15mg', 'principio' => 'Meloxicam', 'cat' => 'Antiinflamatorios'],
            ['sku' => 'AIN-005', 'nom' => 'Celecoxib 200mg', 'principio' => 'Celebrex', 'cat' => 'Antiinflamatorios'],
            ['sku' => 'AIN-006', 'nom' => 'Dexametasona 4mg', 'principio' => 'Dexametasona', 'cat' => 'Antiinflamatorios'],

            // VITAMINAS
            ['sku' => 'VIT-001', 'nom' => 'Ácido Ascórbico 1g', 'principio' => 'Vitamina C', 'cat' => 'Vitaminas'],
            ['sku' => 'VIT-002', 'nom' => 'Carbonato de Magnesio', 'principio' => 'Magnesol', 'cat' => 'Vitaminas'],
            ['sku' => 'VIT-003', 'nom' => 'Multivitamínico Completo', 'principio' => 'Centrum', 'cat' => 'Vitaminas'],
            ['sku' => 'VIT-004', 'nom' => 'Complejo B Inyectable', 'principio' => 'Vitamina B12', 'cat' => 'Vitaminas'],
            ['sku' => 'VIT-005', 'nom' => 'Vitamina D3 2000 UI', 'principio' => 'Vitamina D', 'cat' => 'Vitaminas'],
            ['sku' => 'VIT-006', 'nom' => 'Suplemento de Zinc 20mg', 'principio' => 'Zinc', 'cat' => 'Vitaminas'],

            // DERMATOLÓGICOS
            ['sku' => 'DER-001', 'nom' => 'Protector Solar SPF 50+', 'principio' => 'Eucerin Sun', 'cat' => 'Dermatológicos'],
            ['sku' => 'DER-002', 'nom' => 'Gel Limpiador Effaclar', 'principio' => 'La Roche-Posay', 'cat' => 'Dermatológicos'],
            ['sku' => 'DER-003', 'nom' => 'Crema Hidratante Facial', 'principio' => 'CeraVe', 'cat' => 'Dermatológicos'],
            ['sku' => 'DER-004', 'nom' => 'Óxido de Zinc Pomada', 'principio' => 'Hipoglós', 'cat' => 'Dermatológicos'],
            ['sku' => 'DER-005', 'nom' => 'Betametasona Crema 0.05%', 'principio' => 'Betametasona', 'cat' => 'Dermatológicos'],
            ['sku' => 'DER-006', 'nom' => 'Ketoconazol Champú 2%', 'principio' => 'Medicasp', 'cat' => 'Dermatológicos'],
        
            ['sku' => 'CRD-001', 'nom' => 'Atorvastatina 20mg', 'principio' => 'Atorvastatina', 'cat' => 'Cardiovascular'],
        ];

        foreach ($productos as $p) {
            DB::table('central_productos_maestro_simulacion')->insert([
                'sku' => $p['sku'],
                'categoria_id' => $catMap[$p['cat']], 
                'categoria' => $p['cat'], 
                'nombre_tecnico' => '[SIM] ' . $p['nom'],
                'principio_activo' => $p['principio'],
                'created_at' => now(),
            ]);

            foreach ([1, 2] as $sedeId) {
                DB::table('central_lotes_simulacion')->insert([
                    [
                        'sku' => $p['sku'],
                        'sede_id' => $sedeId,
                        'numero_lote' => 'LT-' . $p['sku'] . '-01',
                        'cantidad_actual' => rand(50, 100),
                        'fecha_vencimiento' => now()->addMonths(rand(1, 5)), 
                        'created_at' => now()
                    ],
                    [
                        'sku' => $p['sku'],
                        'sede_id' => $sedeId,
                        'numero_lote' => 'LT-' . $p['sku'] . '-02',
                        'cantidad_actual' => rand(100, 200),
                        'fecha_vencimiento' => now()->addMonths(rand(12, 24)), 
                        'created_at' => now()
                    ]
                ]);
            }
        }
    }
}