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
        $answer = $this->route('answer');

        return $user->isAdmin() || $user->hasKey('view-answers') || 
            ($user->isEntrant() && $user->attempts->search(function ($item, $key) {
                return $item->id === $answer->attempt->id;
            }) !== false);
    }
}
