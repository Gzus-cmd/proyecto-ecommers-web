<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebDireccionCliente extends Model
{
    protected $table = 'web_direcciones_cliente';

    protected $fillable = [
        'cliente_id', 'alias', 'direccion_completa', 'referencia', 'distrito', 'ciudad', 'es_principal'
    ];

    public function cliente() {
        return $this->belongsTo(WebCliente::class, 'cliente_id');
    }
}