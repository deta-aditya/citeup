<?php

namespace App\Modules\Nucleons;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\Electrons\Shared\Services\QueryConfigurations;

abstract class Service
{
    /*
    |--------------------------------------------------------------------------
    | Base Service Class
    |--------------------------------------------------------------------------
    |
    | This class is responsible for providing interfaces for CRUD over 
    | available models, handling events, etc. In short, service classes handle 
    | almost everything related to business process.
    | There are some convenient features provided by this class:
    | 
    | 1)    Query string parser
    |       The query string parser handles REST API GET parameters
    |       under specified standard. The delimiters, defaults, and allowed 
    |       fields are configurable for convenience.
    |
    |       SELECTING
    |       ----------------
    |       fields: selectable[]       
    |
    |       > ?select=field1,field2,...
    |
    |       SORTING
    |       -------
    |       fields: sortable[]
    |       directions: asc, desc 
    |
    |       > ?sort=field1:direction,field2:direction,...       
    |
    |       CRITERIA/CONDITIONS
    |       -------------------
    |       fields: comparable[]
    |       commands: <, <=, =, >=, >, <>, like, between, notbetween,
    |                 in, notin, is(null, notnull), date, month, day,
    |                 year, column(<, <=, =, >=, >, <>)
    |
    |       > ?criteria=field1:command:value,field2:command:subvalue;subvalue,..
    |
    |       SKIP/OFFSET
    |       -----------
    |       > ?skip=numofskips
    |       
    |       TAKE/LIMIT
    |       ----------
    |       > ?take=numoftakes
    |
    |       RANDOM ORDER
    |       ------------
    |       Should exist without 'sort'.
    |       boolean: true, false
    |       
    |       > ?random=boolean
    |       
    |       WITH RELATED DATA
    |       -----------------
    |       fields: loadable[]
    |       
    |       > ?with=field1,field2,...
    |
    |       WITHOUT RELATED DATA
    |       --------------------
    |       Should exist without 'with'.
    |       boolean: true, false
    |
    |       > ?clean=boolean
    |
    */

    use QueryConfigurations;

    /**
     * The main model for the service.
     *
     * @var null
     */
    protected $model = null;

    /**
     * Parse the query string into the query builder and returns it.
     *
     * @param  Builder  $query
     * @param  array    $params
     * @return Builder
     */
    protected function parseQueryString(Builder $query, array $params)
    {
        list(
            $select, $sort, $criteria, $skip, $take, $random, $with, $clean
        ) = $this->parseParams($params);

        $this->processSelectQuery($query, $select);

        // Sort and random can't exists at the same time
        $random 
            ? $this->processRandomQuery($query)
            : $this->processSortQuery($query, $sort);

        $this->processCriteriaQuery($query, $criteria);

        $this->processSkipQuery($query, $skip);

        $this->processTakeQuery($query, $take);

        // Bypass with when clean presents
        $clean ?: $this->processLoadQuery($query, $with);

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
            array_has($params, 'with') 
                ? $this->parseLoadParams($params['with']) 
                : $this->getDefault('with'),
            array_has($params, 'clean') 
                ? ($params['clean'] === "true") 
                : $this->getDefault('clean'),
        ];
    }

    /**
     * Parse a select query params.
     *
     * @param  string  $select
     * @return array
     */
    protected function parseSelectParams($select) 
    {
        $selects = explode($this->getDelimiter('select'), $select);

        $selects = array_intersect($selects, $this->getSelectable());

        return array_merge($this->config['selectable'], $selects);
    }

    /**
     * Parse a sort query params.
     *
     * @param  string  $sort
     * @return array
     */
    protected function parseSortParams($sort) 
    {
        $items = explode($this->getDelimiter('sort.per_field'), $sort);
        $sortable = $this->getSortable();
        $arrSort = [];
        
        foreach ($items as $item) {
            
            list($field, $direction) = explode(
                $this->getDelimiter('sort.per_value'), $item
            );

            if (! in_array($field, $sortable)) {
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
    protected function parseCriteriaParams($criteria) 
    {
        $items = explode($this->getDelimiter('criteria.per_field'), $criteria);
        $comparable = $this->getComparable();
        $arrWhere = [];
        
        foreach ($items as $item) {
            
            list(
                $field, $command, $values
            ) = explode($this->getDelimiter('criteria.per_value'), $item);

            if (! in_array($field, $comparable)) {
                continue;
            }

            switch ($command) {

                case 'between': case 'notbetween': case 'in': case 'notin':
                case 'column':
                    $values = explode(
                        $this->getDelimiter('criteria.per_subvalue'), $values
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
     * Parse a load query params.
     *
     * @param  string  $with
     * @return array
     */
    protected function parseLoadParams($with)
    {
        $withs = explode($this->getDelimiter('with'), $with);

        $withs = array_intersect($withs, $this->getLoadable());

        return array_merge($this->config['loadable'], $withs);
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

        $query->select(array_shift($selects));

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
                case 'notbetween':
                    $query->whereNotBetween($field, $value);
                    break;
                case 'in':
                    $query->whereIn($field, $value);
                    break;
                case 'notin':
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
     * Perform a load relationship query.
     *
     * @param  Builder  $query
     * @param  array    $with
     * @return void
     */
    protected function processLoadQuery(Builder $query, array $with) 
    {
        if (empty($with)) {
            return;
        }

        foreach ($with as $relation) {
            $query->with($relation);
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
        return array_only($data, $this->getModel()->getFillable());
    }
}
