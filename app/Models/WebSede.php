<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSede extends Model
{
    protected $table = 'web_sedes';

    protected $fillable = ['codigo', 'nombre', 'direccion', 'telefono', 'activo'];

    public function pedidos() {
        return $this->hasMany(WebPedido::class, 'sede_recojo_id');
    }
}
