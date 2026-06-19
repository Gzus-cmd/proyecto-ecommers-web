<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebEstadoPedido extends Model
{
    protected $table = 'web_estados_pedido';

    protected $fillable = ['nombre'];

    public function pedidos() {
        return $this->hasMany(WebPedido::class, 'estado_id');
    }
}