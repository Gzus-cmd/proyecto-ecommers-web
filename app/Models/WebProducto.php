<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebProducto extends Model
{
    protected $table = 'web_productos';
    protected $primaryKey = 'sku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sku', 'nombre_comercial', 'nombre_generico', 'descripcion', 
        'concentracion', 'forma_farmaceutica', 'precio_web', 
        'requiere_receta', 'disponible', 'slug', 'imagen_url'
    ];

    protected $casts = ['precio_web' => 'decimal:2', 'requiere_receta' => 'boolean', 'disponible' => 'boolean'];

    
    public function maestro() {
        return $this->belongsTo(CentralProductoMaestroSimulacion::class, 'sku', 'sku');
    }
}