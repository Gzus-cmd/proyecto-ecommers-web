<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class WebCliente extends Authenticatable
{
    use Notifiable;

    protected $table = 'web_clientes';

    protected $fillable = [
        'nombres', 'apellidos', 'dni', 'email', 'telefono', 'password_hash', 'activo'
    ];

    protected $hidden = ['password_hash'];

    public function pedidos() {
        return $this->hasMany(WebPedido::class, 'cliente_id');
    }

    public function direcciones() {
        return $this->hasMany(WebDireccionCliente::class, 'cliente_id');
    }
}