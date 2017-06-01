<?php

namespace App\Modules\Nucleons;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class Service
{
    /**
     * Evaluate conditions on a select query.
     *
     * @param  array  $params
     * @return array
     */
    protected function evaluate(Builder $query, $params)
    {
        if (array_has($params, 'fields')) {
            $query->select();
        }
    }

    /**
     * Filter an array so it is eligible for insertion/updation.
     *
     * @param  array  $data
     * @return array
     */
    protected function clean(array $data)
    {
        return collect($data)->only($this->pure)->all();
    }
}
