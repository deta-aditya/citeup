<?php

namespace App\Modules\Api\V1\Requests\Keys;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'register' => 'array',
            'register.*' => 'int|exists:users,id',
            'unregister' => 'array',
            'unregister.*' => 'int|exists:users,id',
        ];
    }
}
