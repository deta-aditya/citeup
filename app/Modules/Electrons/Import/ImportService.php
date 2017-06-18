<?php

namespace App\Modules\Electrons\Imports;

use App\Modules\Nucleons\Service;

class ImportService extends Service
{
    /**
     * Import data to the application by given type.
     * 
     * @param  array   $data
     * @param  string  $type
     * @return this
     */
    public function importData(array $data, $type)
    {
        return $this;
    }
}
