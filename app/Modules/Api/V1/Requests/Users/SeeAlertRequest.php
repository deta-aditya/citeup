<?php

namespace App\Modules\Api\V1\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class SeeAlertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('alerts',  $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'see' => 'array',
            'see.*' => 'int|exists:alerts,id',
            'unsee' => 'array',
            'unsee.*' => 'int|exists:alerts,id',
        ];
    }
}
