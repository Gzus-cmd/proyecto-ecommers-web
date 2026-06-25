<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebCliente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WebClienteController extends Controller
{
   
    public function index(Request $request)
    {
        $clientes = WebCliente::query()
            
            ->when($request->search, function ($query, $search) {
                $query->where('dni', 'like', "%{$search}%")
                      ->orWhere('apellidos', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            
            ->withCount('pedidos')
            ->orderBy('apellidos')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Clientes/Index', [
            'clientes' => $clientes,
            'filters' => $request->only(['search'])
        ]);
    }

   
    public function show(WebCliente $cliente)
    {
        
        $cliente->load([
            'direcciones', 
            'pedidos' => function($query) {
                $query->with(['estado', 'sede'])->latest();
            }
        ]);

        $cliente->fecha_formateada = $cliente->created_at->diffForHumans();

        return Inertia::render('Admin/Clientes/Show', [
            'cliente' => $cliente
        ]);
    }


    public function toggle(Request $request, WebCliente $cliente)
    {
        $request->validate([
            'activo' => 'required|boolean'
        ]);

        $cliente->update([
            'activo' => $request->activo
        ]);

        return redirect()->back()->with('success', 'Estado del cliente actualizado correctamente.');
    }

    public function update(Request $request, WebCliente $cliente)
    {
        $validated = $request->validate([
            'nombres'   => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni'       => 'required|string|size:8|unique:web_clientes,dni,' . $cliente->id, // Validación de unicidad
            'email'     => 'required|email|unique:web_clientes,email,' . $cliente->id,
            'telefono'  => 'nullable|string|max:20',
            'activo'    => 'required|boolean',
        ]);

        $cliente->update($validated);

        return redirect()->route('admin.clientes.index')
            ->with('success', 'Perfil de cliente actualizado con éxito.');
    }

    public function edit(WebCliente $cliente)
    {

        return Inertia::render('Admin/Clientes/Edit', [
            'cliente' => $cliente
        ]);
    }
}