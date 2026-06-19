<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentralProductoMaestro extends Model
{
    protected $table = 'central_productos_maestro';
    protected $primaryKey = 'sku'; 
    public $incrementing = false;
    protected $keyType = 'string';

   
    public function lotes()
    {
        return $this->hasMany(CentralLote::class, 'sku', 'sku');
    }

  
    public function webProducto()
    {
        return $this->hasOne(WebProducto::class, 'sku', 'sku');
    }
}