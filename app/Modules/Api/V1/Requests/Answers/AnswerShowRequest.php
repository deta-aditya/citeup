<?php

namespace App\Modules\Api\V1\Requests\Answers;

use App\Modules\Models\Answer;
use Illuminate\Foundation\Http\FormRequest;

class AnswerShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('view-answers') || 
            ($user->isEntrant() && $user->attempts->search(function ($item, $key) {
                return $item->id === $this->route('answer')->attempt->id;
            }) !== false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
