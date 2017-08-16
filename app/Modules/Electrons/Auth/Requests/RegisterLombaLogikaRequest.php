<?php

namespace App\Modules\Electrons\Auth\Requests;

use App\Modules\Electrons\Shared\Requests\AlwaysAuthorize;
use Illuminate\Foundation\Http\FormRequest;

class RegisterLombaLogikaRequest extends FormRequest
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
            'entry_name' => 'required|string|max:191',
            'entry_agency' => 'required|string|max:191',
            'entry_city' => 'required|string|max:191',
            'user_0_name' => 'required|string|max:191|different:entry_name',
            'user_0_email' => 'required|string|email|max:191',
            'user_0_password' => 'required|string|min:6|confirmed',
            'user_0_birthplace' => 'required|string|max:191',
            'user_0_birthdate' => 'required|date_format:Y-m-d',
            'user_0_address' => 'required|string',
            'user_0_phone' => 'required|string|max:20',
            'user_1_name' => 'required|string|max:191|different:user_0_name|different:entry_name',
            'user_1_email' => 'required|string|email|max:191|different:user_0_email',
            'user_1_birthplace' => 'required|string|max:191',
            'user_1_birthdate' => 'required|date_format:Y-m-d',
            'user_1_address' => 'required|string',
            'user_1_phone' => 'required|string|max:20',
            'user_2_name' => 'required|string|max:191|different:user_0_name|different:user_1_name|different:entry_name',
            'user_2_email' => 'required|string|email|max:191|different:user_0_email|different:user_1_email',
            'user_2_birthplace' => 'required|string|max:191',
            'user_2_birthdate' => 'required|date_format:Y-m-d',
            'user_2_address' => 'required|string',
            'user_2_phone' => 'required|string|max:20',
        ];
    }
}
