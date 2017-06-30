<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Schedule;
use App\Modules\Electrons\Edits\EditService;
use App\Modules\Electrons\Activities\ScheduleService;
use App\Modules\Api\V1\Requests\Edits\EditIndexRequest;
use App\Modules\Api\V1\Requests\Schedules\ScheduleIndexRequest;
use App\Modules\Api\V1\Requests\Schedules\ScheduleInsertRequest;
use App\Modules\Api\V1\Requests\Schedules\ScheduleUpdateRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    use JsonApiController;

    /**
     * A schedule service instance.
     *
     * @var ScheduleService
     */
    protected $schedules;

    /**
     * Create a new controller instance.
     *
     * @param  ScheduleService  $schedules
     * @return void
     */
    public function __construct(ScheduleService $schedules)
    {
        $this->schedules = $schedules;
    }

    /**
     * Get an array of schedules data.
     *
     * @param  ScheduleIndexRequest  $request
     * @return Response
     */
    public function index(ScheduleIndexRequest $request)
    {
        return $this->respondJson(
            ['schedules' => $this->schedules->getMultiple($request->all())]
        );
    }

    /**
     * Get a schedule data.
     *
     * @param  Request   $request
     * @param  Schedule  $schedule
     * @return Response
     */
    public function show(Request $request, Schedule $schedule)
    {
        $this->authorize('view', $schedule);

        return $this->respondJson(['schedule' => $schedule]);   
    }

    /**
     * Insert a new schedule data.
     *
     * @param  ScheduleInsertRequest  $request
     * @return Response
     */
    public function insert(ScheduleInsertRequest $request)
    {
        $schedule = $this->schedules->create($request->all());

        return $this->respondJson(['schedule' => $schedule]);
    }

    /**
     * Update a schedule data.
     *
     * @param  ScheduleUpdateRequest  $request
     * @param  Schedule               $schedule
     * @return Response
     */
    public function update(ScheduleUpdateRequest $request, Schedule $schedule)
    {
        $this->schedules->update($schedule, $request->all());

        return $this->respondJson(['schedule' => $schedule]);
    }

    /**
     * Delete a schedule data.
     *
     * @param  Request   $request
     * @param  Schedule  $schedule
     * @return Response
     */
    public function remove(Request $request, Schedule $schedule)
    {
        $this->authorize('delete', $schedule);

        $this->schedules->remove($schedule);

        return $this->respondJson(['schedule' => $schedule]);
    }

    /**
     * Get edits of the given schedule.
     *
     * @param  EditIndexRequest   $request
     * @param  Schedule           $schedule
     * @param  EditService        $edits
     * @return Response
     */
    public function edits(EditIndexRequest $request, Schedule $schedule, EditService $edits)
    {
        $queries = $request->all();

        $queries['schedule'] = $schedule->id;

        return $this->respondJson(
            ['edits' => $edits->getMultiple($queries)]
        );
    }
}
