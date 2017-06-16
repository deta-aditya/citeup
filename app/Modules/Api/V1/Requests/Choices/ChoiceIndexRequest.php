<?php

namespace App\Modules\Api\V1\Requests\Choices;

use App\Modules\Models\Choice;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class ChoiceIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Choice
     */
    protected $model = Choice::class;

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
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'question' => 'int|exists:questions,id',
        ];
    }
}
