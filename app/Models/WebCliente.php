<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class WebCliente extends Authenticatable
{
    use Notifiable;

    protected $table = 'web_clientes';

    protected $fillable = [
        'nombres',
        'apellidos',
        'dni',
        'email',
        'telefono',
        'password_hash',
        'activo',
    ];

    protected $hidden = [
        'password_hash',
    ];

    // Este método le dice a Laravel que tu contraseña está en 'password_hash'
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}