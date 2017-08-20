<?php

namespace App\Modules\Api\V1\Requests\ContactPeople;

use App\Modules\Models\ContactPerson;
use Illuminate\Foundation\Http\FormRequest;

class ContactPersonInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-contact-people');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'phone' => 'required|string|max:191',
        ];
    }
}
