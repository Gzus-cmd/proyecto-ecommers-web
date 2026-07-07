<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentralProductoMaestroSimulacion extends Model
{
    protected $table = 'central_productos_maestro_simulacion';
    protected $primaryKey = 'sku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sku', 'categoria_id', 'nombre_tecnico', 'principio_activo', 
        'laboratorio', 'presentacion', 'requiere_receta'
    ];

    public function categoriaRelacion() {
        return $this->belongsTo(CentralCategoriaSimulacion::class, 'categoria_id');
    }

    public function lotes() {
        return $this->hasMany(CentralLoteSimulacion::class, 'sku', 'sku');
    }

    public function webConfig() {
        return $this->hasOne(WebProducto::class, 'sku', 'sku');
    }
}