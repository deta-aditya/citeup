<?php

namespace App\Modules\Api\V1\Requests\Answers;

use App\Modules\Models\Answer;
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
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-answers') || 
            ($user->isEntrant() && $user->attempts->search(function ($item, $key) {
                return $item->id == $this->input('attempt');
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
            'choice' => 'required|int|exists:choices,id',
            'attempt' => 'required|int|exists:attempts,id',
        ];
    }
}
