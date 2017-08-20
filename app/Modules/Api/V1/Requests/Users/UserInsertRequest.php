<?php

namespace App\Modules\Api\V1\Requests\Users;

use App\Modules\Electrons\Users\RoleService;
use Illuminate\Foundation\Http\FormRequest;

class UserInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $accessor = $this->user();

        return $accessor->isAdmin() || $accessor->hasKey('post-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|int|exists:roles,id',
            'name' => 'required|string|max:191',
            'entry' => 'required_if:role,'. RoleService::ROLE_ENTRANT .'|int|exists:entries,id',
            'crew' => 'boolean',
            'photo' => 'string|max:191',
            'section' => 'required_if:role,'. RoleService::ROLE_COMMITTEE .'string|max:191',
        ];
    }
}
