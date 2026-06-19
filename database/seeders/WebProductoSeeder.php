<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebProductoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('web_productos')->truncate();

        $productosComerciales = [
            ['sku' => 'ANA-001', 'nombre' => 'Panadol Niños', 'conc' => '160mg/5ml', 'forma' => 'Jarabe', 'precio' => 15.50, 'receta' => false],
            ['sku' => 'ANA-002', 'nombre' => 'Aspirina 100', 'conc' => '100mg', 'forma' => 'Tabletas', 'precio' => 12.00, 'receta' => false],
            ['sku' => 'ANA-003', 'nombre' => 'Tramadol gotas', 'conc' => '100mg/ml', 'forma' => 'Solución Oral', 'precio' => 25.90, 'receta' => true],
            ['sku' => 'ANT-001', 'nombre' => 'Amoxicilina MK', 'conc' => '500mg', 'forma' => 'Cápsulas', 'precio' => 0.50, 'receta' => true],
            ['sku' => 'ANT-002', 'nombre' => 'Azitromicina Forte', 'conc' => '500mg', 'forma' => 'Tabletas', 'precio' => 4.50, 'receta' => true],
            ['sku' => 'ANT-003', 'nombre' => 'Ciprofloxacino Genfar', 'conc' => '500mg', 'forma' => 'Tabletas', 'precio' => 1.20, 'receta' => true],
            ['sku' => 'AIN-001', 'nombre' => 'Ibuprofeno 400', 'conc' => '400mg', 'forma' => 'Tabletas', 'precio' => 0.30, 'receta' => false],
            ['sku' => 'AIN-002', 'nombre' => 'Naproxeno Sódico', 'conc' => '550mg', 'forma' => 'Tabletas', 'precio' => 0.80, 'receta' => false],
            ['sku' => 'AIN-003', 'nombre' => 'Diclofenaco Gel', 'conc' => '1%', 'forma' => 'Gel Tópico', 'precio' => 18.50, 'receta' => false],
            ['sku' => 'VIT-001', 'nombre' => 'Redoxon Vitamina C', 'conc' => '1g', 'forma' => 'Tabletas Efervescentes', 'precio' => 22.00, 'receta' => false],
            ['sku' => 'VIT-002', 'nombre' => 'Magnesol Efervescente', 'conc' => '2g', 'forma' => 'Polvo', 'precio' => 1.50, 'receta' => false],
            ['sku' => 'VIT-003', 'nombre' => 'Centrum Silver', 'conc' => 'N/A', 'forma' => 'Tabletas', 'precio' => 85.00, 'receta' => false],
            ['sku' => 'VIT-004', 'nombre' => 'Complejo B Inyectable', 'conc' => '2ml', 'forma' => 'Ampolla', 'precio' => 12.50, 'receta' => true],
            ['sku' => 'DER-001', 'nombre' => 'Eucerin Protector Solar', 'conc' => 'SPF 50+', 'forma' => 'Crema', 'precio' => 95.00, 'receta' => false],
            ['sku' => 'DER-002', 'nombre' => 'La Roche Posay Effaclar', 'conc' => '200ml', 'forma' => 'Gel Limpiador', 'precio' => 78.00, 'receta' => false],
            ['sku' => 'DER-003', 'nombre' => 'Hipoglós Pomada', 'conc' => 'N/A', 'forma' => 'Pomada', 'precio' => 14.20, 'receta' => false],
        ];

        // Solo insertamos los primeros 10 para dejar 6 libres y probar tu CRUD de vinculación
        $productosAMigrar = array_slice($productosComerciales, 0, 10);

        foreach ($productosAMigrar as $p) {
            DB::table('web_productos')->insert([
                'sku' => $p['sku'],
                'slug' => Str::slug($p['nombre'] . '-' . $p['conc']),
                'nombre_comercial' => $p['nombre'],
                'nombre_generico' => 'Ver Maestro Central', // Trazabilidad
                'descripcion' => 'Producto de simulación para PharmaVictoria Web.',
                'concentracion' => $p['conc'],
                'forma_farmaceutica' => $p['forma'],
                'precio_web' => $p['precio'],
                'requiere_receta' => $p['receta'],
                'disponible' => true,
                'imagen_url' => 'https://via.placeholder.com/400x400.png?text=' . urlencode($p['nombre']),
                'created_at' => now(),
            ]);
        }
    }
}