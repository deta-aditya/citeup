<?php

namespace App\Modules\Api\V1\Requests\Galleries;

use Illuminate\Foundation\Http\FormRequest;

class GalleryInsertRequest extends FormRequest
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
            'caption' => 'required|string|max:191',
            'picture' => 'required|string|max:191',
        ];
    }
}
