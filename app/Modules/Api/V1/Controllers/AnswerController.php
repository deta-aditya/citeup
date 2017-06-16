<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Answer;
use App\Modules\Electrons\Questions\AnswerService;
use App\Modules\Api\V1\Requests\Answers\AnswerIndexRequest;
use App\Modules\Api\V1\Requests\Answers\AnswerInsertRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    use JsonApiController;

    /**
     * A answer service instance.
     *
     * @var AnswerService
     */
    protected $answers;

    /**
     * Create a new controller instance.
     *
     * @param  AnswerService  $answers
     * @return void
     */
    public function __construct(AnswerService $answers)
    {
        $this->answers = $answers;
    }

    /**
     * Get an array of answers data.
     *
     * @param  AnswerIndexRequest  $request
     * @return Response
     */
    public function index(AnswerIndexRequest $request)
    {
        return $this->respondJson(
            ['answers' => $this->answers->getMultiple($request->all())]
        );
    }

    /**
     * Get a answer data.
     *
     * @param  Request   $request
     * @param  Answer    $answer
     * @return Response
     */
    public function show(Request $request, Answer $answer)
    {
        return $this->respondJson(['answer' => $answer]);   
    }

    /**
     * Insert a new answer data.
     *
     * @param  AnswerInsertRequest  $request
     * @return Response
     */
    public function insert(AnswerInsertRequest $request)
    {
        $answer = $this->answers->create(
            $request->input('attempt'), $request->input('choice')
        );

        return $this->respondJson(['answer' => $answer]);
    }

    /**
     * Delete a answer data.
     *
     * @param  Request   $request
     * @param  Answer    $answer
     * @return Response
     */
    public function remove(Request $request, Answer $answer)
    {
        $this->answers->remove($answer);

        return $this->respondJson(['answer' => $answer]);
    }
}
