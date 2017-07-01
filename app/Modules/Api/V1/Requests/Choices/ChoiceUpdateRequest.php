<?php

namespace App\Modules\Api\V1\Requests\Choices;

use Illuminate\Foundation\Http\FormRequest;

class ChoiceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('put-choices');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'string',
            'picture' => 'string|max:191',
        ];
    }
}
