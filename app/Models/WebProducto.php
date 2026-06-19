<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebProducto extends Model
{
    protected $table = 'web_productos';
    protected $fillable = [
        'sku', 'slug', 'nombre_comercial', 'nombre_generico', 
        'descripcion', 'concentracion', 'forma_farmaceutica', 
        'precio_web', 'requiere_receta', 'disponible', 'imagen_url'
    ];

    public function maestro()
    {
        return $this->belongsTo(CentralProductoMaestro::class, 'sku', 'sku');
    }


    public function stock()
    {
        return $this->hasMany(CentralLote::class, 'sku', 'sku');
    }
}