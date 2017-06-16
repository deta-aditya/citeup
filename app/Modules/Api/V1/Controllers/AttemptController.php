<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Attempt;
use App\Modules\Electrons\Attempts\AttemptService;
use App\Modules\Electrons\Questions\AnswerService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Attempts\AttemptIndexRequest;
use App\Modules\Api\V1\Requests\Attempts\AttemptStartRequest;
use App\Modules\Api\V1\Requests\Attempts\AttemptFinishRequest;
use App\Modules\Api\V1\Requests\Answers\AnswerIndexRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    use JsonApiController;

    /**
     * A attempt service instance.
     *
     * @var AttemptService
     */
    protected $attempts;

    /**
     * Create a new controller instance.
     *
     * @param  AttemptService  $attempts
     * @return void
     */
    public function __construct(AttemptService $attempts)
    {
        $this->attempts = $attempts;
    }

    /**
     * Get an array of attempts data.
     *
     * @param  AttemptIndexRequest  $request
     * @return Response
     */
    public function index(AttemptIndexRequest $request)
    {
        return $this->respondJson(
            ['attempts' => $this->attempts->getMultiple($request->all())]
        );
    }

    /**
     * Get an attempt data.
     *
     * @param  Request  $request
     * @param  Attempt  $attempt
     * @return Response
     */
    public function show(Request $request, Attempt $attempt)
    {
        return $this->respondJson(['attempt' => $attempt]);   
    }

    /**
     * Start a new attempt.
     *
     * @param  AttemptStartRequest  $request
     * @return Response
     */
    public function start(AttemptStartRequest $request)
    {
        $attempt = $this->attempts->start(
            $request->input('entry'), $request->input('started_at')
        );

        return $this->respondJson(['attempt' => $attempt]);
    }

    /**
     * Finish a given attempt.
     *
     * @param  AttemptFinishRequest  $request
     * @param  Attempt               $attempt
     * @return Response
     */
    public function finish(AttemptFinishRequest $request, Attempt $attempt)
    {
        $this->attempts->finish($attempt, $request->input('finished_at', null));

        return $this->respondJson(['attempt' => $attempt]);
    }

    /**
     * Delete an attempt data.
     *
     * @param  Request  $request
     * @param  Attempt  $attempt
     * @return Response
     */
    public function remove(Request $request, Attempt $attempt)
    {
        $this->attempts->remove($attempt);

        return $this->respondJson(['attempt' => $attempt]);
    }

    /**
     * Get the answers of given attempt.
     * 
     * @param  AnswerIndexRequest  $request
     * @param  Attempt             $attempt
     * @param  AnswerService       $answers
     * @param  Response
     */
    public function answers(AnswerIndexRequest $request, Attempt $attempt, AnswerService $answers)
    {
        $queries = $request->all();

        $queries['attempt'] = $attempt->id;

        return $this->respondJson(
            ['answers' => $answers->getMultiple($queries)]
        );
    }
}
