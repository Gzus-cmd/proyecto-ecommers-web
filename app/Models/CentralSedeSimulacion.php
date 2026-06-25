<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CentralSede extends Model {
    protected $table = 'central_sedes_simulacion';
    
    public function lotes() {
        return $this->hasMany(CentralLoteSimulacion::class, 'sede_id');
    }
}