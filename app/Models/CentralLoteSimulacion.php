<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentralLoteSimulacion extends Model
{
    protected $table = 'central_lotes_simulacion';
    protected $fillable = ['sku', 'numero_lote', 'cantidad_actual', 'fecha_vencimiento'];

    public function sede() {
        return $this->belongsTo(CentralSede::class, 'sede_id');
    }
}
