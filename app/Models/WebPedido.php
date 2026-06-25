<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebPedido extends Model
{
    use HasFactory;

    protected $table = 'web_pedidos';

    protected $fillable = [
        'cliente_id', 
        'sede_recojo_id', 
        'direccion_envio_id', 
        'estado_id', 
        'subtotal', 
        'impuesto', 
        'total'
    ];



    public function estado()
    {

        return $this->belongsTo(WebEstadoPedido::class, 'estado_id');
    }

    public function sede()
    {

        return $this->belongsTo(WebSede::class, 'sede_recojo_id');
    }

    public function cliente()
    {
        return $this->belongsTo(WebCliente::class, 'cliente_id');
    }

    public function detalles()
    {
        return $this->hasMany(WebDetallePedido::class, 'pedido_id');
    }
}