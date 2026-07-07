<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\WebProducto;
use App\Models\CentralCategoriaSimulacion;
use App\Models\WebBanner; 
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {

        $categories = CentralCategoriaSimulacion::orderBy('nombre')->get();


        $banners = WebBanner::query()
            ->with(['producto.maestro.categoriaRelacion'])
            ->where('activo', true)
            ->where(function($query) {
                $query->whereNull('fecha_fin')
                      ->orWhere('fecha_fin', '>=', now()->startOfDay());
            })
            ->orderBy('fecha_fin', 'asc') 
            ->take(4)
            ->get();


        $featuredProducts = WebProducto::query()
            ->join('central_lotes_simulacion', 'web_productos.sku', '=', 'central_lotes_simulacion.sku')
            ->select('web_productos.*')
            ->where('web_productos.disponible', true)
            ->where('central_lotes_simulacion.cantidad_actual', '>', 0)
            ->where('central_lotes_simulacion.fecha_vencimiento', '>', now())
            ->groupBy('web_productos.sku')
            ->with(['maestro.categoriaRelacion']) 
            ->take(8)
            ->get()
            ->map(function($p) {
                $p->percentage = rand(20, 30);
                $p->old_price = round($p->precio_web * 1.25, 2);

                if (!$p->imagen_url || str_contains($p->imagen_url, 'via.placeholder.com')) {
                    $p->imagen_url = "https://placehold.co/600x600/F8FAFC/072D44?text=" . urlencode($p->nombre_comercial);
                }
                return $p;
            });

        return Inertia::render('Welcome', [
            'categories' => $categories,
            'banners' => $banners, 
            'featuredProducts' => $featuredProducts
        ]);
    }
}