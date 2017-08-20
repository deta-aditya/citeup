<?php

namespace App\Modules\Api\V1\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntrantProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isEntrant() && 
            $this->route('entry')->id === $this->user()->entry->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|max:191|nullable',
            'agency' => 'string|max:191|nullable',
            'city' => 'string|max:191|nullable',
            'users' => 'array',
            'users.*.id' => 'int|exists:users,id',
            'users.*.name' => 'string|max:191|nullable',
            'users.*.email' => 'string|email|max:191|nullable',
            'users.*.birthplace' => 'string|max:191|nullable',
            'users.*.birthdate' => 'date_format:Y-m-d|nullable',
            'users.*.address' => 'string|nullable',
            'users.*.phone' => 'string|max:20|nullable',
            'users.*.photo' => 'string|nullable',
        ];
    }
}
