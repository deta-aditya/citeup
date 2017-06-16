<?php

namespace App\Modules\Api\V1\Requests\Answers;

use Illuminate\Foundation\Http\FormRequest;

class AnswerInsertRequest extends FormRequest
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
            'choice' => 'required|int|exists:choices,id',
            'attempt' => 'required|int|exists:attempts,id',
        ];
    }
}
