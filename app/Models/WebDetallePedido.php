<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebDetallePedido extends Model
{
    protected $table = 'web_detalle_pedidos';
    public $timestamps = false;
    protected $fillable = ['pedido_id', 'sku_producto', 'cantidad', 'precio_unitario', 'subtotal'];

    public function producto() {
        return $this->belongsTo(WebProducto::class, 'sku_producto', 'sku');
    }
}
