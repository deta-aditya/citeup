<?php

namespace App\Modules\Electrons\Shared\Services;

use Illuminate\Support\Facades\Config;

trait QueryConfigurations
{
    use HasMainModel;

    /**
     * Get the default value of certain query params.
     *
     * @param  string  $attr
     * @return array|int
     */
    public function getDefault($attr) 
    {
        return $this->getValuedConfig('defaults', $attr);
    }

    /**
     * Get the delimiter value of certain query params.
     *
     * @param  string  $attr
     * @return string
     */
    public function getDelimiter($attr) 
    {
        return $this->getValuedConfig('delimiters', $attr);
    }

    /**
     * Get the selectable fields.
     *
     * @return array
     */
    public function getSelectable() 
    {
        return $this->getConfig('selectable');
    }

    /**
     * Get the sortable fields.
     *
     * @return array
     */
    public function getSortable() 
    {
        return $this->getConfig('sortable');
    }

    /**
     * Get the comparable fields.
     *
     * @return array
     */
    public function getComparable() 
    {
        return $this->getConfig('comparable');
    }

    /**
     * Get the loadable fields.
     *
     * @return array
     */
    public function getLoadable() 
    {
        return $this->getConfig('loadable');
    }

    /**
     * Get the base configuration of specified type.
     *
     * @param  string  $type
     * @return mixed
     */
    public function getBase($type)
    {
        return config($this->getBaseConfigRoot($type));
    }

    /**
     * Get the config root string for base configuratuon.
     *
     * @param  string  $parent
     * @return string
     */
    protected function getBaseConfigRoot($parent)
    {
        return 'queries.base.' . $parent;
    }

    /**
     * Get the config root string.
     *
     * @param  string  $parent
     * @return string
     */
    protected function getConfigRoot($parent)
    {
        return 'queries.' . $this->getTableName() . '.' . $parent;
    }

    /**
     * Get a parameterized valued config.
     *
     * @param  string  $type
     * @param  string  $attr
     * @return string
     */
    protected function getValuedConfig($type, $attr)
    {
        return Config::has($this->getConfigRoot($type) . '.' . $attr)
            ? config($this->getConfigRoot($type) . '.' . $attr)
            : config($this->getBaseConfigRoot($type) . '.' . $attr);
    }

    /**
     * Get a basic config.
     *
     * @param  string  $type
     * @return string
     */
    protected function getConfig($type)
    {
        return ! Config::has($this->getConfigRoot($type))
            ? config($this->getBaseConfigRoot($type))
            : array_merge(
                config($this->getBaseConfigRoot($type)),
                config($this->getConfigRoot($type))
            );
    }
}
