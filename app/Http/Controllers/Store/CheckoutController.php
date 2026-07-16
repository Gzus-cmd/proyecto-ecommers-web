<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\WebPedido;
use App\Models\WebDetallePedido;
use App\Models\WebSede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::with(['cliente.direcciones'])
            ->findOrFail(\Illuminate\Support\Facades\Auth::id());

        $sedes = \App\Models\WebSede::where('activo', true)->get();

        return Inertia::render('Public/Checkout/Index', [
            'direcciones' => $user->cliente->direcciones ?? [],
            'sedes' => $sedes
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_entrega' => 'required|in:delivery,recojo',
            'cart' => 'required|array|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            $cliente = Auth::user()->cliente;


            $pedido = WebPedido::create([
                'cliente_id' => $cliente->id,
                'estado_id' => 1, 
                'direccion_id' => $request->tipo_entrega === 'delivery' ? $request->direccion_id : null,
                'sede_recojo_id' => $request->tipo_entrega === 'recojo' ? $request->sede_id : null,
                'subtotal' => $request->total / 1.18,
                'impuesto' => $request->total - ($request->total / 1.18),
                'total' => $request->total,
            ]);

            foreach ($request->cart as $item) {
                WebDetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'sku_producto' => $item['sku'],
                    'cantidad' => $item['quantity'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['precio'] * $item['quantity']
                ]);
            }

            return redirect()->route('store.orders');
        });
    }
}