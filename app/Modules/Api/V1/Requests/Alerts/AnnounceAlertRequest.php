<?php

namespace App\Modules\Api\V1\Requests\Alerts;

use Illuminate\Foundation\Http\FormRequest;

class AnnounceAlertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('users', $this->route('alert'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'announce' => 'array',
            'announce.*' => 'int|exists:users,id',
            'unannounce' => 'array',
            'unannounce.*' => 'int|exists:users,id',
        ];
    }
}
