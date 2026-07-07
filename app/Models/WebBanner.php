<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebBanner extends Model
{
    protected $table = 'web_banners';

    protected $fillable = [
        'producto_sku',
        'titulo',
        'descripcion',
        'imagen_url',
        'orden',
        'activo',
        'fecha_fin'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_fin' => 'date'
    ];


    public function producto(): BelongsTo
    {
        return $this->belongsTo(WebProducto::class, 'producto_sku', 'sku');
    }


    public static function tieneEspacio(): bool
    {
        return self::where('activo', true)->count() < 4;
    }
}