<?php

namespace App\Modules\Api\V1\Requests\Keys;

use App\Modules\Models\Key;
use Illuminate\Foundation\Http\FormRequest;

class KeyDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin();
    }
}
