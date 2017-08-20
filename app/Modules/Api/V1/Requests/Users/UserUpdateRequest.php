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
        $accessor = $this->user();
        $user = $this->route('user');

        return $accessor->isAdmin() || 
            ($accessor->isCommittee() && $accessor->hasKey('put-users')) || 
            ($accessor->isEntrant() && $accessor->entry->id === $user->entry_id) || 
            $accessor->id === $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'email|unique:users|nullable',
            'name' => 'string|max:191',
            'photo' => 'string|max:191',
            'phone' => 'string|max:15',
            'section' => 'string|max:191',
        ];
    }
}
