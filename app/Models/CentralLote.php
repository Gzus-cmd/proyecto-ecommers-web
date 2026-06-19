<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentralLote extends Model
{
    protected $table = 'central_lotes';
    protected $fillable = ['sku', 'numero_lote', 'cantidad_actual', 'fecha_vencimiento'];
}