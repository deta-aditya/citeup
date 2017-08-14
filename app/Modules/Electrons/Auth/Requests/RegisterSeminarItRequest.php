<?php

namespace App\Modules\Electrons\Auth\Requests;

use App\Modules\Electrons\Shared\Requests\AlwaysAuthorize;
use Illuminate\Foundation\Http\FormRequest;

class RegisterSeminarItRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'entry_agency' => 'string|max:191',
            'entry_city' => 'required|string|max:191',
            'entry_address' => 'required|string',
            'entry_phone' => 'required|string|max:20',
            'user_email' => 'required|string|email|max:191',
            'user_password' => 'required|string|min:6',
        ];
    }
}
