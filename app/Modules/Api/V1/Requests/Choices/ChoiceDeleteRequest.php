<?php

namespace App\Modules\Api\V1\Requests\Choices;

use Illuminate\Foundation\Http\FormRequest;

class ChoiceDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('delete-choices');
    }
}
