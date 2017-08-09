<?php

namespace App\Modules\Api\V1\Requests\HtmlContents;

use App\Modules\Models\HtmlContent;
use Illuminate\Foundation\Http\FormRequest;

class HtmlContentInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-html-contents');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'content' => 'required|string',
        ];
    }
}
