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
            'random' => false,
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
                'per_subvalue' => ';',
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
     * Perform a complete selection query.
     *
     * @param  Builder  $query
     * @param  array    $params
     * @return array
     */
    protected function query(Builder $query, array $params)
    {
        $query = $this->queryRaw($query, $params);
    }

    /**
     * Perform a select query and returns the query builder.
     *
     * @param  Builder  $query
     * @param  array    $params
     * @return Builder
     */
    protected function queryRaw(Builder $query, array $params)
    {
        list(
            $select, $sort, $criteria, $skip, $take, $random
        ) = $this->parseParams($params);

        $this->processSelectQuery($query, $select);

        // Sort and random can't exists at the same time
        $random 
            ? $this->processRandomQuery($query)
            : $this->processSortQuery($query, $sort);

        $this->processCriteriaQuery($query, $criteria);

        $this->processSkipQuery($query, $skip);

        $this->processTakeQuery($query, $take);

        return $query;
    }

    /**
     * Parse all query string params into array.
     *
     * @param  array  $params
     * @return array
     */
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
            array_has($params, 'random') 
                ? ($params['random'] === "true") 
                : $this->getDefault('random'),
        ];
    }

    /**
     * Parse a select query params.
     *
     * @param  string  $select
     * @return array
     */
    protected function parseSelectParams(string $select) 
    {
        $select = array_only($select, $this->getSelectable());

        return explode($this->getDelimeter('select'), $select);
    }

    /**
     * Parse a sort query params.
     *
     * @param  string  $sort
     * @return array
     */
    protected function parseSortParams(string $sort) 
    {
        $items = explode($this->getDelimeter('sort.per_field'), $sort);
        $sortable = $this->getSortable();
        $arrSort = [];
        
        foreach ($items as $item) {
            
            list($field, $direction) = explode(
                $this->getDelimeter('sort.per_value'), $item);

            if (! array_has($sortable, $field)) {
                continue;
            }

            $arrSort[$field] = $direction;

        }

        return $arrSort;
    }

    /**
     * Parse a criteria query params.
     *
     * @param  string  $criteria
     * @return array
     */
    protected function parseCriteriaParams(string $criteria) 
    {
        $items = explode($this->getDelimeter('criteria.per_field'), $criteria);
        $comparable = $this->getComparable();
        $arrWhere = [];
        
        foreach ($items as $item) {
            
            list(
                $field, $command, $values
            ) = explode($this->getDelimeter('criteria.per_value'), $item);

            if (! array_has($comparable, $field)) {
                continue;
            }

            switch ($command) {

                case 'between': case 'notbetween': case 'in': case 'notin':
                case 'column':
                    $values = explode(
                        $this->getDelimeter('criteria.per_subvalue'), $values
                    );
                    break;

                case 'is':
                    if ($values === 'notnull') {
                        $command = 'isnot';
                    }

                    $values = null;
                    break;

            }

            array_push($arrWhere, [$field, $command, $values]);
            
        }

        return $arrWhere;
    }

    /**
     * Get the default value of certain query params.
     *
     * @param  string  $attr
     * @return array|int
     */
    protected function getDefault($attr) 
    {
        return array_has($this->defaults, $attr) 
            ? $this->defaults[$attr]
            : $this->config['defaults'][$attr];
    }

    /**
     * Get the delimeter value of certain query params.
     *
     * @param  string  $attr
     * @return string
     */
    protected function getDelimeter($attr) 
    {
        return array_has($this->delimeters, $attr) 
            ? array_get($this->delimeters, $attr)
            : array_get($this->config, 'delimeters.'. $attr);
    }

    /**
     * Get the selectable fields.
     *
     * @return array
     */
    protected function getSelectable() 
    {
        return empty($this->selectable) 
            ? $this->config['selectable']
            : array_merge($this->config['selectable'], $this->selectable);
    }

    /**
     * Get the sortable fields.
     *
     * @return array
     */
    protected function getSortable() 
    {
        return empty($this->sortable) 
            ? $this->config['sortable']
            : array_merge($this->config['sortable'], $this->sortable);
    }

    /**
     * Get the comparable fields.
     *
     * @return array
     */
    protected function getComparable() 
    {
        return empty($this->comparable) 
            ? $this->config['comparable']
            : array_merge($this->config['comparable'], $this->comparable);
    }

    /**
     * Perform a select query.
     *
     * @param  Builder  $query
     * @param  array  $selects
     * @return void
     */
    protected function processSelectQuery(Builder $query, array $selects) 
    {
        if (empty($selects)) {
            return;
        }

        foreach ($selects as $select) {
            $query->addSelect($select);
        }
    }

    /**
     * Perform a sort query.
     *
     * @param  Builder  $query
     * @param  array  $sorts
     * @return void
     */
    protected function processSortQuery(Builder $query, array $sorts) 
    {
        if (empty($sorts)) {
            return;
        }

        foreach ($sorts as $sort => $direction) {
            $query->orderBy($sort, $direction);
        }
    }

    /**
     * Perform a where query.
     *
     * @param  Builder  $query
     * @param  array  $criterias
     * @return void
     */
    protected function processCriteriaQuery(Builder $query, array $criterias) 
    {
        if (empty($criterias)) {
            return;
        }

        foreach ($criterias as list($field, $command, $value)) {
            
            switch ($command) {

                case 'between':
                    $query->whereBetween($field, $value);
                    break;
                case 'notbewteen':
                    $query->whereNotBetween($field, $value);
                    break;
                case 'wherein':
                    $query->whereIn($field, $value);
                    break;
                case 'wherenotin':
                    $query->whereNotIn($field, $value);
                    break;
                case 'is':
                    $query->whereNull($field);
                    break;
                case 'isnot':
                    $query->whereNotNull($field);
                    break;
                case 'date':
                    $query->whereDate($field, $value);
                    break;
                case 'month':
                    $query->whereMonth($field, $value);
                    break;
                case 'day':
                    $query->whereDay($field, $value);
                    break;
                case 'year':
                    $query->whereYear($field, $value);
                    break;
                case 'column':
                    $query->whereColumn($field, $value[0], $value[1]);
                    break;
                default:
                    $query->where($field, $command, $value);
                    break;

            }

        }
    }

    /**
     * Perform a skip query.
     *
     * @param  Builder  $query
     * @param  int  $skip
     * @return void
     */
    protected function processSkipQuery(Builder $query, $skip) 
    {
        $query->skip($skip);
    }

    /**
     * Perform a take query.
     *
     * @param  Builder  $query
     * @param  int  $take
     * @return void
     */
    protected function processTakeQuery(Builder $query, $take) 
    {
        $query->take($take);
    }

    /**
     * Perform a random query.
     *
     * @param  Builder  $query
     * @return void
     */
    protected function processRandomQuery(Builder $query) 
    {
        $query->inRandomOrder();
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
