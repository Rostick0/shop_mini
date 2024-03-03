<?php

namespace App\Utils;

use Exception;
use Illuminate\Database\Eloquent\Builder;

class OrderByUtil
{
    private static function checkMinus(string $name): bool
    {
        return $name[0] == '-';
    }

    private static function type(string $name): string
    {
        if (OrderByUtil::checkMinus($name)) return 'ASC';

        return 'DESC';
    }

    private static function removeMinus(string $name): string
    {
        if (OrderByUtil::checkMinus($name)) return substr($name, 1);

        return $name;
    }

    public static function set(?string $name, Builder $builder): Builder
    {
        if (!$name) return $builder->orderByDesc('id');

        $table = $builder->getModel()->getTable();
        $builder->select($table . '.*');
        // $builder->distinct("$table.id");
        $sort_name = '';

        $name_array = explode('.', $name);
        $my_relat = $builder;
        // dd($relat = $builder->getRelation('user')->getRelation('company')->getOwnerKeyName());

        if (count($name_array) > 1) {
            foreach ((array_slice($name_array, 1)) as $key => $value) {
                $relat = $my_relat->getRelation(OrderByUtil::removeMinus($name_array[$key]));
                $relat_table = $relat->getModel()->getTable();

                $relat_parent = null;
                $relat_child = null;

                try {
                    $relat_parent = $relat->getOwnerKeyName();
                    $relat_child = $relat->getForeignKeyName();
                } catch (Exception $e) {
                    $relat_child = $relat->getLocalKeyName();
                    $relat_parent = $relat->getForeignKeyName();
                }

                $builder->join(
                    $relat_table,
                    $my_relat->getModel()->getTable() . '.' . $relat_child,
                    '=',
                    $relat_table . '.' . $relat_parent
                );

                $sort_name = $relat_table . '.';
                $my_relat = $relat;
            }
        }

        $sort_name .= end($name_array);
        // $builder->distinct();
        // $builder->select([
        //     "$table.id",
        //     OrderByUtil::removeMinus(
        //         $sort_name
        //     ) ?? 'id'
        // ]);

        // dd($sort_name);

        // dd($name);
        // dd($sort_name);

        return $builder->orderBy(
            OrderByUtil::removeMinus(
                $sort_name
            ) ?? 'id',
            OrderByUtil::type($name)
        );
    }
}
