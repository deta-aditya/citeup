<?php

namespace App\Modules\Electrons\Keys;

use App\Modules\Models\Key;
use App\Modules\Nucleons\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KeyService extends Service
{
    /**
     * The main model for the service.
     *
     * @var User
     */
    protected $model = Key::class;

    /**
     * Determine whether any of the given values are not one of the key ID.
     * 
     * @param  array  $ids
     * @return bool 
     */
    public function areInvalidId(array $keys)
    {
        try {
            $this->getModel()->query()->findOrFail($keys);
        } catch (ModelNotFoundException $e) {
            return true;
        }

        return false;
    }
}
