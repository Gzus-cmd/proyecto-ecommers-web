<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebDireccionCliente extends Model
{
    use HasFactory;


    protected $table = 'web_direcciones_cliente';


    protected $fillable = [
        'cliente_id',
        'alias',
        'direccion_completa',
        'referencia',
        'distrito',
        'ciudad',
        'es_principal'
    ];


    protected $casts = [
        'es_principal' => 'boolean',
    ];


    public function cliente()
    {
        return $this->belongsTo(WebCliente::class, 'cliente_id');
    }
}