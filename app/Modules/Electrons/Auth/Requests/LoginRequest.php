<?php

namespace App\Modules\Electrons\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Electrons\Shared\Requests\AlwaysAuthorize;

class LoginRequest extends FormRequest
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
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
