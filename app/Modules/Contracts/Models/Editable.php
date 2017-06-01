<?php

namespace App\Modules\Contracts\Models;

interface Editable
{
    /**
     * Get all of the tracked edits
     *
     * @return MorphMany
     */
    public function edits();
}
