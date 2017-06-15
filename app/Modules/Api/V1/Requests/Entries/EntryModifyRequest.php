<?php

namespace App\Modules\Api\V1\Requests\Entries;

use Illuminate\Foundation\Http\FormRequest;

class EntryModifyRequest extends FormRequest
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
            'stage' => 'int|between:0,5',
            'status' => 'int|in:0,1',
        ];
    }
}
