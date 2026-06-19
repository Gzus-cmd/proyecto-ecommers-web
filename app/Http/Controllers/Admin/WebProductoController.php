<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebProducto;
use App\Models\CentralProductoMaestro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;

class WebProductoController extends Controller
{
   
    public function index()
    {
        
        $productos = WebProducto::with('maestro')->get();

        return Inertia::render('Admin/Productos/Index', [
            'productos' => $productos
        ]);
    }

    
    public function create()
    {
        
        $productosDisponibles = CentralProductoMaestro::whereNotIn('sku', function($query) {
                $query->select('sku')->from('web_productos');
            })
            ->whereHas('lotes', function($query) {
                $query->where('cantidad_actual', '>', 0);
            })
            ->get();

        return Inertia::render('Admin/Productos/Create', [
            'maestros' => $productosDisponibles
        ]);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|exists:central_productos_maestro,sku',
            'nombre_comercial' => 'required|string|max:255',
            'precio_web' => 'required|numeric|min:0.1',
        ]);

        WebProducto::create([
            'sku' => $request->sku,
            'nombre_comercial' => $request->nombre_comercial,
            'slug' => Str::slug($request->nombre_comercial),
            'precio_web' => $request->precio_web,
            'disponible' => true,
        
        ]);

        return redirect()->route('admin.productos.index');
    }
}