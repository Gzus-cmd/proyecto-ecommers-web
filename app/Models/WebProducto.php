<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WebProducto extends Model
{
    protected $table = 'web_productos';
    protected $primaryKey = 'sku';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'sku', 
        'nombre_comercial', 
        'nombre_generico', 
        'descripcion', 
        'dosificacion',     
        'advertencias',      
        'almacenamiento',    
        'concentracion', 
        'forma_farmaceutica', 
        'presentacion_web',  
        'precio_web', 
        'requiere_receta', 
        'disponible', 
        'slug', 
        'imagen_url'
    ];

    protected $casts = [
        'precio_web' => 'decimal:2', 
        'requiere_receta' => 'boolean', 
        'disponible' => 'boolean'
    ];

    protected $appends = [
        'categoria_nombre', 
        'categoria_icono', 
        'categoria_slug',
        'stock_total',       
        'disponible_recojo'  
    ];



    public function maestro() {
        return $this->belongsTo(CentralProductoMaestroSimulacion::class, 'sku', 'sku');
    }

    public function banner() {
        return $this->hasOne(WebBanner::class, 'producto_sku', 'sku');
    }


    public function getCategoriaNombreAttribute() {
        return $this->maestro?->categoriaRelacion?->nombre ?? 'General';
    }

    public function getCategoriaIconoAttribute() {
        return $this->maestro?->categoriaRelacion?->icono_lucide ?? 'Package';
    }

    public function getCategoriaSlugAttribute() {
        return $this->maestro?->categoriaRelacion?->slug ?? '';
    }


    public function getStockTotalAttribute() {

        return DB::table('central_lotes_simulacion')
            ->where('sku', $this->sku)
            ->where('fecha_vencimiento', '>', now())
            ->sum('cantidad_actual');
    }


    public function getDisponibleRecojoAttribute() {
        $stockSedePrincipal = DB::table('central_lotes_simulacion')
            ->where('sku', $this->sku)
            ->where('sede_id', 1)
            ->where('fecha_vencimiento', '>', now())
            ->sum('cantidad_actual');

        return $stockSedePrincipal > 0;
    }


    public function getSugerencias($limit = 4) {
        return self::where('sku', '!=', $this->sku)
            ->where('disponible', true)
            ->whereHas('maestro.categoriaRelacion', function($q) {
                $q->where('id', $this->maestro?->categoria_id);
            })
            ->take($limit)
            ->get();
    }
}