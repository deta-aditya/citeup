<?php

namespace App\Modules\Api\V1\Requests\Questions;

use App\Modules\Models\Question;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class QuestionIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Question
     */
    protected $model = Question::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('get', Question::class);
    }
}
