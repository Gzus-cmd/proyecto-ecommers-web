<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class WebCliente extends Model
{
    protected $table = 'web_clientes';
    
    protected $fillable = [
        'user_id', 
        'nombres', 
        'apellidos', 
        'dni', 
        'telefono', 
        'activo'
    ];

    protected $hidden = ['password_hash'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pedidos() {
        return $this->hasMany(WebPedido::class, 'cliente_id');
    }

    public function direcciones() {
        return $this->hasMany(WebDireccionCliente::class, 'cliente_id');
    }
}