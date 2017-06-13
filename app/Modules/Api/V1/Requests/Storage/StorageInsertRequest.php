<?php

namespace App\Modules\Api\V1\Requests\Storage;

use Illuminate\Foundation\Http\FormRequest;

class StorageInsertRequest extends FormRequest
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
            'object_id' => 'required|int',
            'object_type' => 'required|string',
            'file' => 'file|max:2048',
        ];
    }
}
