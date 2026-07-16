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
        ->with(['maestro.categoriaRelacion', 'maestro.lotes'])
        ->where('disponible', true);


    if ($request->filled('categoria')) {
        $query->whereHas('maestro.categoriaRelacion', function ($q) use ($request) {
            $q->where('slug', $request->categoria);
        });
    }


    if ($request->filled('min_price')) $query->where('precio_web', '>=', $request->min_price);
    if ($request->filled('max_price')) $query->where('precio_web', '<=', $request->max_price);


    $sort = $request->input('sort', 'name_asc');
    match ($sort) {
        'price_asc'  => $query->orderBy('precio_web', 'asc'),
        'price_desc' => $query->orderBy('precio_web', 'desc'),
        default      => $query->orderBy('nombre_comercial', 'asc'),
    };

    $productos = $query->paginate(12)->withQueryString();

    return Inertia::render('Public/Catalog/Index', [
        'productos' => $productos,
        'filters'   => $request->only(['categoria', 'sort', 'min_price', 'max_price']),
        'categorias' => CentralCategoriaSimulacion::orderBy('nombre')->get(['nombre', 'slug'])
    ]);
}
}