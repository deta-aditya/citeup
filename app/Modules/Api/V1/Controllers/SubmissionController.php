<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Submission;
use App\Modules\Electrons\Submissions\SubmissionService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Submissions\SubmissionIndexRequest;
use App\Modules\Api\V1\Requests\Submissions\SubmissionInsertRequest;
use App\Modules\Api\V1\Requests\Submissions\SubmissionUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    use JsonApiController;

    /**
     * A submission service instance.
     *
     * @var SubmissionService
     */
    protected $submissions;

    /**
     * Create a new controller instance.
     *
     * @param  SubmissionService  $submissions
     * @return void
     */
    public function __construct(SubmissionService $submissions)
    {
        $this->submissions = $submissions;
    }

    /**
     * Get an array of submissions data.
     *
     * @param  SubmissionIndexRequest  $request
     * @return Response
     */
    public function index(SubmissionIndexRequest $request)
    {
        return $this->respondJson(
            ['submissions' => $this->submissions->getMultiple($request->all())]
        );
    }

    /**
     * Get an submission data.
     *
     * @param  Request     $request
     * @param  Submission  $submission
     * @return Response
     */
    public function show(Request $request, Submission $submission)
    {
        return $this->respondJson(['submission' => $submission]);   
    }

    /**
     * Insert a new submission data.
     *
     * @param  SubmissionInsertRequest  $request
     * @return Response
     */
    public function insert(SubmissionInsertRequest $request)
    {
        $submission = $this->submissions->create($request->all());

        return $this->respondJson(['submission' => $submission]);
    }

    /**
     * Update a submission data.
     *
     * @param  SubmissionUpdateRequest  $request
     * @param  Submission               $submission
     * @return Response
     */
    public function update(SubmissionUpdateRequest $request, Submission $submission)
    {
        $this->submissions->update($submission, $request->all());

        return $this->respondJson(['submission' => $submission]);
    }

    /**
     * Delete a submission data.
     *
     * @param  Request  $request
     * @param  Submission    $submission
     * @return Response
     */
    public function remove(Request $request, Submission $submission)
    {
        $this->submissions->remove($submission);

        return $this->respondJson(['submission' => $submission]);
    }
}
