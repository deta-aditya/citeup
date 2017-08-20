<?php

namespace App\Modules\Electrons\Settings;

use App\Modules\Electrons\Settings\Category;
use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    /**
     * Determine how the collection should be cloned.
     *
     * @return void
     */
    public function __clone()
    {
        foreach ($this->items as $key => $item) {

            if (! $item instanceof Category) {
                $this->items[$key] = $item;
                continue;
            }

            $this->items[$key] = new Category;

            foreach ($item->getProperties() as $property => $value) {
                $this->items[$key]->{$property} = $value;
            }
        }
    }
}
