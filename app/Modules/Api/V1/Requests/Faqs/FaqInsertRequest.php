<?php

namespace App\Modules\Api\V1\Requests\Faqs;

use App\Modules\Models\Faq;
use Illuminate\Foundation\Http\FormRequest;

class FaqInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-faqs');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'required|string|max:191',
            'answer' => 'required|string|max:191',
        ];
    }
}
