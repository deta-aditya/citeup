<?php

namespace App\Modules\Api\V1\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('put', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'email|unique:users',
            'password' => 'string|confirmed',
            'role' => 'int|exists:roles,id',
            'name' => 'string|max:191',
            'address' => 'string',
            'school' => 'string|max:191',
            'city' => 'string|max:191',
            'photo' => 'string|max:191',
            'phone' => 'string|max:15',
            'section' => 'string|max:191',
        ];
    }
}
