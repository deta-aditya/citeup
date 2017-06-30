<?php

namespace App\Modules\Api\V1\Requests\News;

use App\Modules\Models\News;
use Illuminate\Foundation\Http\FormRequest;

class NewsInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('post', News::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:191',
            'picture' => 'string|max:191',
            'content' => 'required|string',
        ];
    }
}
