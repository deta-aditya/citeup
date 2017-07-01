<?php

namespace App\Modules\Api\V1\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class GrantKeysRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $accessor = $this->user();

        return $accessor->isAdmin() || $accessor->hasKey('post-users-keys');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'grant' => 'array',
            'grant.*' => 'int|exists:keys,id',
            'ungrant' => 'array',
            'ungrant.*' => 'int|exists:keys,id',
        ];
    }
}
