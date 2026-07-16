<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\WebDireccionCliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function profile()
    {
        $user = User::with(['cliente.direcciones'])->findOrFail(Auth::id());
        return Inertia::render('Public/Customer/Profile', [
            'cliente' => $user->cliente,
            'direcciones' => $user->cliente->direcciones ?? []
        ]);
    }

    public function orders()
    {
        // Traemos pedidos con su estado y los nombres de los productos
        $pedidos = Auth::user()->cliente->pedidos()
            ->with(['estado', 'detalles.webProducto'])
            ->latest()
            ->get();

        return Inertia::render('Public/Customer/Orders', [
            'pedidos' => $pedidos
        ]);
    }

    public function medicineCabinet()
    {

        $pedidosEntregados = Auth::user()->cliente->pedidos()
            ->where('estado_id', 4) 
            ->with('detalles.webProducto')
            ->get();


        $productos = $pedidosEntregados->flatMap->detalles
            ->pluck('webProducto')
            ->unique('sku');

        return Inertia::render('Public/Customer/Cabinet', [
            'productos' => $productos->values()
        ]);
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'alias' => 'required|string|max:50',
            'direccion_completa' => 'required|string',
            'distrito' => 'required|string',
            'ciudad' => 'required|string',
        ]);

        WebDireccionCliente::create([
            'cliente_id' => Auth::user()->cliente->id,
            'alias' => $request->alias,
            'direccion_completa' => $request->direccion_completa,
            'distrito' => $request->distrito,
            'ciudad' => $request->ciudad,
            'es_principal' => Auth::user()->cliente->direcciones()->count() === 0
        ]);

        return back();
    }
}