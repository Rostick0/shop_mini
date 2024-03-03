<?php

namespace App\Utils;
use Illuminate\Database\Eloquent\builder;

class FilterHasUtil
{
    public static function template($request, Builder $builder, array $fillable_block = [], $type = '='): Builder
    {
        collect($request)->each(function ($value, $key) use ($builder, $fillable_block, $type) {
            if (FilterTypeUtil::check($key)) return;

            if (!empty($fillable_block) && array_search($key, $fillable_block) !== false) return;
            
            if (!isset($value)) {
            } else {
                $builder->has($key, $type, $value);
            }
        });

        return $builder;
    }

    public static function all($request, Builder $builder, array $fillable_block = []): Builder
    {
        $data = $builder;

        if ($request->hasEQ) $data = FilterHasUtil::template($request->hasEQ, $builder, $fillable_block, '=');
        if ($request->hasNEQ) $data = FilterHasUtil::template($request->hasNEQ, $builder, $fillable_block, '!=');

        if ($request->hasGEQ) $data = FilterHasUtil::template($request->hasGEQ, $builder, $fillable_block, '>=');
        if ($request->hasLEQ) $data = FilterHasUtil::template($request->hasLEQ, $builder, $fillable_block, '<=');
        if ($request->hasCE) $data = FilterHasUtil::template($request->hasCE, $builder, $fillable_block, '>');
        if ($request->hasLE) $data = FilterHasUtil::template($request->hasLE, $builder, $fillable_block, '<');

        return $data;
    }
}