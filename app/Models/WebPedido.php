<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebPedido extends Model
{
    protected $table = 'web_pedidos';

    protected $fillable = [
        'cliente_id', 'sede_recojo_id', 'direccion_envio_id', 
        'estado_id', 'fecha_pedido', 'subtotal', 'impuesto', 'total'
    ];


    public function detalles()
    {
        return $this->hasMany(WebDetallePedido::class, 'pedido_id');
    }
}