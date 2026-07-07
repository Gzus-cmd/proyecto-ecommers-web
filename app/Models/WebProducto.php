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

    protected $casts = [
        'precio_web' => 'decimal:2', 
        'requiere_receta' => 'boolean', 
        'disponible' => 'boolean'
    ];


    protected $appends = ['categoria_nombre', 'categoria_icono', 'categoria_slug'];

    public function maestro() {
        return $this->belongsTo(CentralProductoMaestroSimulacion::class, 'sku', 'sku');
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

    public function banner()
    {
        return $this->hasOne(WebBanner::class, 'producto_sku', 'sku');
    }
}