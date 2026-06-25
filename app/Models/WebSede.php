<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSede extends Model
{
    protected $table = 'web_sedes';
    protected $fillable = ['id','codigo', 'nombre', 'direccion', 'telefono', 'activo'];
}
