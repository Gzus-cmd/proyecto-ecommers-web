<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebPedido;
use App\Models\WebEstadoPedido;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WebPedidoController extends Controller
{
    public function index(Request $request)
    {
        $pedidos = WebPedido::with(['cliente', 'estado', 'sede'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Pedidos/Index', [
            'pedidos' => $pedidos
        ]);
    }

    public function show(WebPedido $pedido)
    {

        $pedido->load([
            'cliente.direcciones', 
            'estado', 
            'sede', 
            'detalles.producto.maestro'
        ]);

        $estados = WebEstadoPedido::all();

        return Inertia::render('Admin/Pedidos/Show', [
            'pedido' => $pedido,
            'estados' => \App\Models\WebEstadoPedido::all()
        ]);
    }

    public function updateStatus(Request $request, WebPedido $pedido)
    {
        $request->validate([
            'estado_id' => 'required|exists:web_estados_pedido,id'
        ]);

        $pedido->update(['estado_id' => $request->estado_id]);

        return redirect()->back()->with('success', 'Estado del pedido actualizado.');
    }
}