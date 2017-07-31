<?php

namespace App\Modules\Api\V1\Requests\Users;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UserDeleteRequest extends FormRequest
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

        return ($accessor->isAdmin() || $accessor->hasKey('delete-users')) && 
            $accessor->id !== $user->id;
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
