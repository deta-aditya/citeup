<?php

namespace App\Modules\Api\V1\Requests\Answers;

use App\Modules\Models\Answer;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class AnswerIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Answer
     */
    protected $model = Answer::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('get-answers') || 
            ($user->isEntrant() && $user->attempts->search(function ($item, $key) {
                return $item->id == $this->input('attempt', null);
            }) !== false);
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'question' => 'int|exists:questions,id',
            'choice' => 'int|exists:choices,id',
            'attempt' => 'int|exists:attempts,id',
        ];
    }
}
