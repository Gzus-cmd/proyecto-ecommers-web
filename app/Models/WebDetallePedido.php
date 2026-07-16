<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebDetallePedido extends Model
{
    protected $table = 'web_detalle_pedidos';
    public $timestamps = false; 

    protected $fillable = [
        'pedido_id',
        'sku_producto',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];


    public function webProducto(): BelongsTo
    {
        return $this->belongsTo(WebProducto::class, 'sku_producto', 'sku');
    }


    public function producto(): BelongsTo
    {
        return $this->belongsTo(WebProducto::class, 'sku_producto', 'sku');
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(WebPedido::class, 'pedido_id');
    }
}