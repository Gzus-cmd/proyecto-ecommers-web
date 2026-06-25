<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebProducto;
use App\Models\CentralProductoMaestroSimulacion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class WebProductoController extends Controller
{
    public function index(Request $request)
    {
        $productos = WebProducto::with(['maestro' => function($query) {
                $query->withSum('lotes as stock_total', 'cantidad_actual');
            }])
            ->when($request->search, function($query, $search) {
                $query->where('nombre_comercial', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            })
            ->get();

        return Inertia::render('Admin/Productos/Index', [
            'productos' => $productos,
            'filters' => $request->only(['search']) 
        ]);
    }

    public function create()
    {
        
        $maestrosDisponibles = CentralProductoMaestroSimulacion::whereNotIn('sku', WebProducto::pluck('sku'))
            ->whereHas('lotes', function($query) {
                $query->where('cantidad_actual', '>', 0);
            })
            ->withSum('lotes as stock_disponible', 'cantidad_actual')
            ->get();

        return Inertia::render('Admin/Productos/Create', [
            'maestros' => $maestrosDisponibles
    ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|exists:central_productos_maestro_simulacion,sku|unique:web_productos,sku',
            'nombre_comercial' => 'required|string|max:255',
            'nombre_generico' => 'required|string|max:255',
            'precio_web' => 'required|numeric|min:0.1',
            'requiere_receta' => 'required|boolean',
            'disponible' => 'required|boolean',
            'imagen' => 'nullable|image|max:2048', 
            'descripcion' => 'nullable|string',
            'concentracion' => 'nullable|string',
            'forma_farmaceutica' => 'nullable|string',
        ]);

        $data = $validated;
        $data['slug'] = Str::slug($request->nombre_comercial);

        
        if ($request->hasFile('imagen')) {
            
            $path = $request->file('imagen')->store('productos', 'public');
            
            $data['imagen_url'] = Storage::url($path);
        }

        WebProducto::create($data);

        return redirect()->route('admin.productos.index');
    }

    public function edit(WebProducto $producto)
    {
        
        $producto->load('maestro');
        
        
        return Inertia::render('Admin/Productos/Edit', [
            'producto' => $producto
        ]);
    }

    public function update(Request $request, WebProducto $producto)
    {
        $validated = $request->validate([
            'nombre_comercial' => 'required|string|max:255',
            'nombre_generico' => 'required|string|max:255',
            'precio_web' => 'required|numeric|min:0.1',
            'requiere_receta' => 'required|boolean',
            'disponible' => 'required|boolean',
            'imagen' => 'nullable|image|max:2048',
            'descripcion' => 'nullable|string',
            'concentracion' => 'nullable|string',
            'forma_farmaceutica' => 'nullable|string',
        ]);

        $data = $validated;
        $data['slug'] = Str::slug($request->nombre_comercial);

        if ($request->hasFile('imagen')) {
            
            if ($producto->imagen_url) {
                $oldPath = str_replace('/storage/', '', $producto->imagen_url);
                Storage::disk('public')->delete($oldPath);
            }
            
            
            $path = $request->file('imagen')->store('productos', 'public');
            $data['imagen_url'] = Storage::url($path);
        }

        $producto->update($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado');
    }

    public function destroy(WebProducto $producto)
    {

        if ($producto->imagen_url) {
            $path = str_replace('/storage/', '', $producto->imagen_url);
            Storage::disk('public')->delete($path);
        }


        $producto->delete();


        return redirect()->route('admin.productos.index')
            ->with('success', 'El producto ha sido retirado de la tienda.');
    }

    public function show(WebProducto $producto)
    {
        $producto->load(['maestro.lotes']);

        return Inertia::render('Admin/Productos/Show', [
            'producto' => $producto
        ]);
    }

}