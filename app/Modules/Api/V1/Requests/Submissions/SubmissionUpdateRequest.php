<?php

namespace App\Modules\Api\V1\Requests\Submissions;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('put', $this->route('submission'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'string',
            'picture' => 'string|max:191',
        ];
    }
}
