<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ClinicalSecurityScope implements Scope
{
    /**
     * Aplica el filtro global: Solo productos con stock en lotes
     * que vencen en más de 6 meses desde hoy.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereHas('maestro.lotes', function ($query) {
            $query->where('fecha_vencimiento', '>', now()->addMonths(6))
                  ->where('cantidad_actual', '>', 0);
        });
    }
}