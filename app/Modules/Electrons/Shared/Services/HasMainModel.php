<?php

namespace App\Modules\Electrons\Shared\Services;

trait HasMainModel
{
    /**
     * Get the main model.
     *
     * @return Model
     */
    public function getModel()
    {
        return new $this->model;
    }

    /**
     * Get the table name of the model.
     * The value is cached in the class for performance reason.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->getModel()->getTable();
    }
}
