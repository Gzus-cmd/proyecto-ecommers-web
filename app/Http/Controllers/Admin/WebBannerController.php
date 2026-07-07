<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebBanner;
use App\Models\WebProducto;
use App\Models\CentralCategoriaSimulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class WebBannerController extends Controller
{

    public function index()
    {
        return Inertia::render('Admin/Banners/Index', [
            'banners' => WebBanner::with('producto')->orderBy('fecha_fin', 'asc')->get(),
            'canCreate' => WebBanner::tieneEspacio()
        ]);
    }


    public function create()
    {
        $categorias = CentralCategoriaSimulacion::orderBy('nombre')->get();


        $productosGrouped = WebProducto::query()
            ->join('central_lotes_simulacion', 'web_productos.sku', '=', 'central_lotes_simulacion.sku')
            ->select(
                'web_productos.sku', 
                'web_productos.nombre_comercial', 
                DB::raw('MIN(central_lotes_simulacion.fecha_vencimiento) as fecha_vence'),
                DB::raw('SUM(central_lotes_simulacion.cantidad_actual) as stock_total')
            )
            ->where('central_lotes_simulacion.cantidad_actual', '>', 0)
            ->groupBy('web_productos.sku', 'web_productos.nombre_comercial')
            ->with('maestro.categoriaRelacion')
            ->get()
            ->groupBy(fn($i) => $i->maestro->categoriaRelacion->slug ?? 'sin-categoria');

        return Inertia::render('Admin/Banners/Create', [
            'categorias' => $categorias,
            'productosGrouped' => $productosGrouped
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'producto_sku' => 'required|exists:web_productos,sku',
            'titulo' => 'required|string|max:45',
            'descripcion' => 'required|string|max:120',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', 
            'fecha_fin' => 'required|date|after:today'
        ]);

        $path = $request->file('imagen')->store('banners', 'public');

        WebBanner::create([
            'producto_sku' => $request->producto_sku,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen_url' => '/storage/' . $path,
            'fecha_fin' => $request->fecha_fin,
            'activo' => true
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner publicado.');
    }


    public function edit(WebBanner $banner)
    {
        $categorias = CentralCategoriaSimulacion::orderBy('nombre')->get();
        
        $productosGrouped = WebProducto::query()
            ->join('central_lotes_simulacion', 'web_productos.sku', '=', 'central_lotes_simulacion.sku')
            ->select('web_productos.sku', 'web_productos.nombre_comercial', 
                DB::raw('MIN(central_lotes_simulacion.fecha_vencimiento) as fecha_vence'),
                DB::raw('SUM(central_lotes_simulacion.cantidad_actual) as stock_total'))
            ->where('central_lotes_simulacion.cantidad_actual', '>', 0)
            ->groupBy('web_productos.sku', 'web_productos.nombre_comercial')
            ->with('maestro.categoriaRelacion')->get()
            ->groupBy(fn($i) => $i->maestro->categoriaRelacion->slug ?? 'sin-categoria');

        return Inertia::render('Admin/Banners/Edit', [
            'banner' => $banner->load('producto'),
            'categorias' => $categorias,
            'productosGrouped' => $productosGrouped
        ]);
    }


    public function update(Request $request, WebBanner $banner)
    {
        $request->validate([
            'producto_sku' => 'required|exists:web_productos,sku',
            'titulo' => 'required|string|max:45',
            'descripcion' => 'required|string|max:120',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'fecha_fin' => 'required|date'
        ]);

        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            if ($banner->imagen_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $banner->imagen_url));
            }
            
            $path = $request->file('imagen')->store('banners', 'public');
            $data['imagen_url'] = '/storage/' . $path;
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner actualizado.');
    }


    public function destroy(WebBanner $banner)
    {
        if ($banner->imagen_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $banner->imagen_url));
        }

        $banner->delete();
        return back()->with('success', 'Promoción eliminada.');
    }
}