<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CentralCategoriaSimulacion extends Model
{
    protected $table = 'central_categorias_simulacion';
    
    protected $fillable = [
        'nombre',
        'slug',
        'icono_lucide'
    ];

    
    public function productosMaestros(): HasMany
    {
        return $this->hasMany(CentralProductoMaestroSimulacion::class, 'categoria_id');
    }
}