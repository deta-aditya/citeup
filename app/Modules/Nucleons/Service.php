<?php

namespace App\Modules\Nucleons;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class Service
{
    /**
     * Base configurations for select query string parsing.
     * 
     * @var array
     */
    protected $config = [
        
        'defaults' => [
            'select' => [],
            'sort' => ['id' => 'asc'],
            'where' => [],
            'skip' => 0,
            'take' => 25,

        ],

        'delimeters' => [
            'select' => ',',
            
            'sort' => [
                'per_field' => ',',
                'per_value' => ':',
            ],
            
            'criteria' => [
                'per_field' => ',',
                'per_value' => ':',
            ],
        ],

        'selectable' => ['id', 'created_at', 'updated_at'],
        'sortable' => ['id', 'created_at', 'updated_at'],
        'comparable' => ['id', 'created_at', 'updated_at'],
    ];

    /**
     * Default values for query string.
     * 
     * @var array
     */
    protected $defaults = [
        //
    ];

    /**
     * Attributes that are selectable for query (aside from ID and timestamps).
     *
     * @var array
     */
    protected $selectable = [
        //
    ];

    /**
     * Attributes that are sortable for query (aside from ID and timestamps).
     *
     * @var array
     */
    protected $sortable = [
        //
    ];

    /**
     * Attributes that are comparable for query (aside from ID and timestamps).
     *
     * @var array
     */
    protected $comparable = [
        //
    ];

    /**
     * Delimeters applied in the query params.
     * 
     * @var array
     */
    protected $delimeters = [
        //
    ];

    /**
     * Perform a select query.
     *
     * @param  Builder  $query
     * @param  array    $params
     * @return array
     */
    protected function selectQuery(Builder $query, array $params)
    {
        list($select, $sort, $criteria, $skip, $take) = $this->parseParams($params);


    }

    protected function parseParams(array $params)
    {
        return [
            array_has($params, 'select') 
                ? $this->parseSelectParams($params['select']) 
                : $this->getDefault('select'),
            array_has($params, 'sort') 
                ? $this->parseSortParams($params['sort']) 
                : $this->getDefault('sort'),
            array_has($params, 'criteria') 
                ? $this->parseCriteriaParams($params['criteria']) 
                : $this->getDefault('criteria'),
            array_has($params, 'skip') 
                ? $params['skip'] 
                : $this->getDefault('skip'),
            array_has($params, 'take') 
                ? $params['take'] 
                : $this->getDefault('take'),
        ];
    }

    protected function getDefault($attr) 
    {
        return array_has($this->defaults, $attr) 
            ? $this->defaults[$attr]
            : $this->config['defaults'][$attr];
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
