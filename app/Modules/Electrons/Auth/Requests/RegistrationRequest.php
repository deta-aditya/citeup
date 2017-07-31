<?php

namespace App\Modules\Electrons\Auth\Requests;

use App\Modules\Electrons\Shared\Requests\AlwaysAuthorize;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    use AlwaysAuthorize;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
