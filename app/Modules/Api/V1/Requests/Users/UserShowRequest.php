<?php

namespace App\Modules\Api\V1\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserShowRequest extends FormRequest
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

        return $accessor->isAdmin() || $accessor->hasKey('view-users') || (
                ($accessor->isEntrant() && $accessor->id === $user->id) || 
                ($accessor->isCommittee() && ! $user->isAdmin())
            );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
