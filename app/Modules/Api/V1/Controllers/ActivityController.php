<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Activity;
use App\Modules\Electrons\Edits\EditService;
use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Activities\ScheduleService;
use App\Modules\Electrons\Activities\ActivityService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Activities\ActivityIndexRequest;
use App\Modules\Api\V1\Requests\Activities\ActivityInsertRequest;
use App\Modules\Api\V1\Requests\Activities\ActivityUpdateRequest;
use App\Modules\Api\V1\Requests\Activities\MakeScheduleRequest;
use App\Modules\Api\V1\Requests\Schedules\ScheduleIndexRequest;
use App\Modules\Api\V1\Requests\Edits\EditIndexRequest;
use App\Modules\Api\V1\Requests\Users\UserIndexRequest;
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
     * @param  ActivityIndexRequest  $request
     * @return Response
     */
    public function index(ActivityIndexRequest $request)
    {
        return $this->respondJson(
            ['activities' => $this->activities->getMultiple($request->all())]
        );
    }

    /**
     * Get an activity data.
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

    /**
     * Delete an activity data.
     *
     * @param  Request   $request
     * @param  Activity  $activity
     * @return Response
     */
    public function remove(Request $request, Activity $activity)
    {
        $this->activities->remove($activity);

        return $this->respondJson(['activity' => $activity]);
    }

    /**
     * Get the users who entered the given activity.
     * 
     * @param  UserIndexRequest  $request
     * @param  Activity          $activity
     * @param  UserService       $users
     * @param  Response
     */
    public function users(UserIndexRequest $request, Activity $activity, UserService $users)
    {
        $queries = $request->all();

        $queries['activity'] = $activity->id;

        return $this->respondJson(
            ['users' => $users->getMultiple($queries)]
        );
    }

    /**
     * Get the schedules of given activity.
     * 
     * @param  ScheduleIndexRequest  $request
     * @param  Activity              $activity
     * @param  ScheduleService       $schedules
     * @param  Response
     */
    public function schedules(ScheduleIndexRequest $request, Activity $activity, ScheduleService $schedules)
    {
        $queries = $request->all();

        $queries['activity'] = $activity->id;

        return $this->respondJson(
            ['schedules' => $schedules->getMultiple($queries)]
        );
    }

    /**
     * Insert a new schedule for the given activity.
     *
     * @param  MakeScheduleRequest   $request
     * @param  Activity              $activity
     * @param  ScheduleService       $schedules
     * @return Response
     */
    public function makeSchedule(MakeScheduleRequest $request, Activity $activity, ScheduleService $schedules)
    {
        $data = $request->all();

        $data['activity'] = $activity->id;

        $schedule = $schedules->create($data);

        return $this->respondJson(['schedule' => $schedule]);
    }

    /**
     * Get edits of the given activity.
     *
     * @param  EditIndexRequest   $request
     * @param  Activity           $activity
     * @param  EditService        $edits
     * @return Response
     */
    public function edits(EditIndexRequest $request, Activity $activity, EditService $edits)
    {
        $queries = $request->all();

        $queries['activity'] = $activity->id;

        return $this->respondJson(
            ['edits' => $edits->getMultiple($queries)]
        );
    }
}
