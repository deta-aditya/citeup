<?php

namespace App\Modules\Api\V1\Requests\Activities;

use Illuminate\Foundation\Http\FormRequest;

class MakeScheduleRequest extends FormRequest
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
            'description' => 'required|string|max:191',
            'held_at' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
