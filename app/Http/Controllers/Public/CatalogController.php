<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\WebProducto;
use App\Models\CentralCategoriaSimulacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CatalogController extends Controller
{
    /**
     * @query categoria string
     * @query sort string
     * @query min_price number
     * @query max_price number
     * @query in_stock boolean
     */
    public function index(Request $request)
    {
        $query = WebProducto::query()
            ->with(['maestro.categoriaRelacion', 'maestro' => function($q) {
                $q->withSum('lotes as stock_total', 'cantidad_actual');
            }])
            ->where('disponible', true);


        if ($request->filled('categoria')) {
            $query->whereHas('maestro.categoriaRelacion', function ($q) use ($request) {
                $q->where('slug', $request->categoria);
            });
        }


        if ($request->filled('min_price')) $query->where('precio_web', '>=', $request->min_price);
        if ($request->filled('max_price')) $query->where('precio_web', '<=', $request->max_price);


        if ($request->boolean('in_stock', true)) {
            $query->whereHas('maestro.lotes', function ($q) {
                $q->where('cantidad_actual', '>', 0)
                ->where('fecha_vencimiento', '>=', now()->addMonths(6));
            });
        }


        $sort = $request->input('sort', 'name_asc');
        
        if ($sort === 'price_asc') {
            $query->orderBy('precio_web', 'asc'); 
        } elseif ($sort === 'price_desc') {
            $query->orderBy('precio_web', 'desc'); 
        } else {
            $query->orderBy('nombre_comercial', 'asc'); 
        }

        $productos = $query->paginate(12)->withQueryString();


        $productos->getCollection()->transform(function($p) {
            if (!$p->imagen_url || str_contains($p->imagen_url, 'via.placeholder.com')) {
                $p->imagen_url = "https://placehold.co/600x600/F8FAFC/072D44?text=" . urlencode($p->nombre_comercial);
            }
            return $p;
        });

        return Inertia::render('Public/Catalog/Index', [
            'productos' => $productos,
            'filters'   => $request->all(),
            'categorias' => CentralCategoriaSimulacion::orderBy('nombre')->get(['nombre', 'slug'])
        ]);
    }
}