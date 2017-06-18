<?php

namespace App\Modules\Api\V1\Requests\Attempts;

use Illuminate\Foundation\Http\FormRequest;

class AddAnswersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'answers' => 'required|array',
            'answers.*' => 'int|exists:choices,id',
        ];
    }
}
