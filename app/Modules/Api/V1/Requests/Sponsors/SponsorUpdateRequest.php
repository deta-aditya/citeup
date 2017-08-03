<?php

namespace App\Modules\Api\V1\Requests\Sponsors;

use Illuminate\Foundation\Http\FormRequest;

class SponsorUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('put-sponsors');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|max:191',
            'picture' => 'string|max:191',
            'type' => 'int|between:1,2',
            'url' => 'string|max:191|nullable',
        ];
    }
}
