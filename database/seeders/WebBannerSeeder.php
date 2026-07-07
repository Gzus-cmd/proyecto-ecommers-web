<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebBanner;
use App\Models\WebProducto;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema; 

class WebBannerSeeder extends Seeder
{
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();
        WebBanner::truncate();
        Schema::enableForeignKeyConstraints();


        $productos = WebProducto::take(4)->get();

        foreach ($productos as $index => $prod) {
            

            $tituloBruto = '¡OFERTA EN ' . strtoupper($prod->nombre_comercial) . '!';
            $tituloFinal = Str::limit($tituloBruto, 40, '...');
            $descBruta = 'Aprovecha el descuento exclusivo en ' . $prod->nombre_comercial . ' antes de agotar stock.';
            $descFinal = Str::limit($descBruta, 110, '...');

            WebBanner::create([
                'producto_sku' => $prod->sku,
                'titulo' => $tituloFinal,
                'descripcion' => $descFinal,
                'imagen_url' => "https://placehold.co/1200x500/072D44/FFFFFF?text=OFERTA+" . ($index + 1),
                'orden' => $index,
                'activo' => true,
                'fecha_fin' => now()->addDays(($index + 1) * 7)
            ]);
        }

        $this->command->info('✅ Banners reiniciados: Se han creado exactamente ' . $productos->count() . ' promociones.');
    }
}