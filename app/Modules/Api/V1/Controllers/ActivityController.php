<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Activity;
use App\Modules\Electrons\Activities\ActivityService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Activities\ActivityInsertRequest;
use App\Modules\Api\V1\Requests\Activities\ActivityUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    use JsonApiController;

    /**
     * A activity service instance.
     *
     * @var ActivityService
     */
    protected $activities;

    /**
     * Create a new controller instance.
     *
     * @param  ActivityService  $activities
     * @return void
     */
    public function __construct(ActivityService $activities)
    {
        $this->activities = $activities;
    }

    /**
     * Get an array of activities data.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->respondJson(
            ['activities' => $this->activities->getMultiple($request->all())]
        );
    }

    /**
     * Get a activity data.
     *
     * @param  Request   $request
     * @param  Activity  $activity
     * @return Response
     */
    public function show(Request $request, Activity $activity)
    {
        $this->activities->loadRelationships($activity);

        return $this->respondJson(['activity' => $activity]);   
    }

    /**
     * Insert a new activity data.
     *
     * @param  ActivityInsertRequest  $request
     * @return Response
     */
    public function insert(ActivityInsertRequest $request)
    {
        $activity = $this->activities->create($request->all());

        return $this->respondJson(['activity' => $activity]);
    }

    /**
     * Update an activity data.
     *
     * @param  ActivityUpdateRequest  $request
     * @param  Activity               $activity
     * @return Response
     */
    public function update(ActivityUpdateRequest $request, Activity $activity)
    {
        $this->activities->update($activity, $request->all());

        return $this->respondJson(['activity' => $activity]);
    }
}
