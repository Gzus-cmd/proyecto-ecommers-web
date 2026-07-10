<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\WebProducto;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function show(WebProducto $producto)
    {

        $producto->load(['maestro.categoriaRelacion']);

        $sugerencias = $producto->getSugerencias(4);

        return Inertia::render('Public/Product/Show', [
            'producto' => $producto,
            'relacionados' => $sugerencias
        ]);
    }
}