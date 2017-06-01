<?php

namespace App\Modules\Electrons\Shared\Requests;

trait AlwaysAuthorize 
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
