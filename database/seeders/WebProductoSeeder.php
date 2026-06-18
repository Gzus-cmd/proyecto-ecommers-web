<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            // ANALGÉSICOS
            ['sku' => 'ANA-001', 'nombre' => 'Panadol Niños', 'generico' => 'Paracetamol', 'conc' => '160mg/5ml', 'forma' => 'Jarabe', 'cat' => 'Analgésicos', 'precio' => 15.50, 'receta' => false],
            ['sku' => 'ANA-002', 'nombre' => 'Aspirina 100', 'generico' => 'Ácido Acetilsalicílico', 'conc' => '100mg', 'forma' => 'Tabletas', 'cat' => 'Analgésicos', 'precio' => 12.00, 'receta' => false],
            ['sku' => 'ANA-003', 'nombre' => 'Tramadol gotas', 'generico' => 'Tramadol Clorhidrato', 'conc' => '100mg/ml', 'forma' => 'Solución Oral', 'cat' => 'Analgésicos', 'precio' => 25.90, 'receta' => true],

            // ANTIBIÓTICOS
            ['sku' => 'ANT-001', 'nombre' => 'Amoxicilina MK', 'generico' => 'Amoxicilina', 'conc' => '500mg', 'forma' => 'Cápsulas', 'cat' => 'Antibióticos', 'precio' => 0.50, 'receta' => true],
            ['sku' => 'ANT-002', 'nombre' => 'Azitromicina Forte', 'generico' => 'Azitromicina', 'conc' => '500mg', 'forma' => 'Tabletas', 'cat' => 'Antibióticos', 'precio' => 4.50, 'receta' => true],
            ['sku' => 'ANT-003', 'nombre' => 'Ciprofloxacino Genfar', 'generico' => 'Ciprofloxacino', 'conc' => '500mg', 'forma' => 'Tabletas', 'cat' => 'Antibióticos', 'precio' => 1.20, 'receta' => true],

            // ANTIINFLAMATORIOS
            ['sku' => 'AIN-001', 'nombre' => 'Ibuprofeno 400', 'generico' => 'Ibuprofeno', 'conc' => '400mg', 'forma' => 'Tabletas', 'cat' => 'Antiinflamatorios', 'precio' => 0.30, 'receta' => false],
            ['sku' => 'AIN-002', 'nombre' => 'Naproxeno Sódico', 'generico' => 'Naproxeno', 'conc' => '550mg', 'forma' => 'Tabletas', 'cat' => 'Antiinflamatorios', 'precio' => 0.80, 'receta' => false],
            ['sku' => 'AIN-003', 'nombre' => 'Diclofenaco Gel', 'generico' => 'Diclofenaco Sódico', 'conc' => '1%', 'forma' => 'Gel Tópico', 'cat' => 'Antiinflamatorios', 'precio' => 18.50, 'receta' => false],

            // VITAMINAS
            ['sku' => 'VIT-001', 'nombre' => 'Redoxon Vitamina C', 'generico' => 'Ácido Ascórbico', 'conc' => '1g', 'forma' => 'Tabletas Efervescentes', 'cat' => 'Vitaminas', 'precio' => 22.00, 'receta' => false],
            ['sku' => 'VIT-002', 'nombre' => 'Magnesol Efervescente', 'generico' => 'Magnesio', 'conc' => '2g', 'forma' => 'Polvo', 'cat' => 'Vitaminas', 'precio' => 1.50, 'receta' => false],
            ['sku' => 'VIT-003', 'nombre' => 'Centrum Silver', 'generico' => 'Multivitamínico', 'conc' => 'N/A', 'forma' => 'Tabletas', 'cat' => 'Vitaminas', 'precio' => 85.00, 'receta' => false],
            ['sku' => 'VIT-004', 'nombre' => 'Complejo B Inyectable', 'generico' => 'Vitaminas B1, B6, B12', 'conc' => '2ml', 'forma' => 'Ampolla', 'cat' => 'Vitaminas', 'precio' => 12.50, 'receta' => true],

            // DERMATOLÓGICOS
            ['sku' => 'DER-001', 'nombre' => 'Eucerin Protector Solar', 'generico' => 'Filtro UV', 'conc' => 'SPF 50+', 'forma' => 'Crema', 'cat' => 'Dermatológicos', 'precio' => 95.00, 'receta' => false],
            ['sku' => 'DER-002', 'nombre' => 'La Roche Posay Effaclar', 'generico' => 'Limpiador Facial', 'conc' => '200ml', 'forma' => 'Gel Limpiador', 'cat' => 'Dermatológicos', 'precio' => 78.00, 'receta' => false],
            ['sku' => 'DER-003', 'nombre' => 'Hipoglós Pomada', 'generico' => 'Óxido de Zinc', 'conc' => 'N/A', 'forma' => 'Pomada', 'cat' => 'Dermatológicos', 'precio' => 14.20, 'receta' => false],
        ];

        foreach ($productos as $p) {
            DB::table('web_productos')->insert([
                'sku' => $p['sku'],
                'slug' => Str::slug($p['nombre'] . '-' . $p['conc']),
                'nombre_comercial' => $p['nombre'],
                'nombre_generico' => $p['generico'],
                'descripcion' => 'Medicamento indicado para el tratamiento en la categoría de ' . $p['cat'],
                'concentracion' => $p['conc'],
                'forma_farmaceutica' => $p['forma'],
                'precio_web' => $p['precio'],
                'requiere_receta' => $p['receta'],
                'disponible' => true,
                'imagen_url' => 'https://via.placeholder.com/400x400.png?text=' . urlencode($p['nombre']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}