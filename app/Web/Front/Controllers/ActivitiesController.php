<?php

namespace App\Web\Front\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Stages\StageService;
use App\Modules\Electrons\Activities\ActivityService as Activities;

class ActivitiesController extends Controller
{
    /**
     * The activity service instance.
     *
     * @var Activities
     */
    protected $activities;

    /**
     * The navigation theme.
     *
     * @var string
     */
    protected $navtheme = 'white';

    /**
     * The view name.
     *
     * @var string
     */
    protected $view = 'front.activities';

    /**
     * Create a new controller instance.
     *
     * @param  Activities  $activities
     * @return void
     */
    public function __construct(Activities $activities)
    {
        $this->activities = $activities;
    }

    /**
     * Show the activities page.
     *
     * @param  Request  $request
     * @param  string   $t
     * @return Response
     */
    public function index(Request $request, $t = 'lomba-logika')
    {
        return view($this->view, $this->data($t));
    }

    /**
     * Return the data required in the view.
     *
     * @param  string  $type
     * @return array
     */
    protected function data($type)
    {
        return [
            'activities'    => $this->getActivities(),
            'regs_condition'=> $this->getRegsCondition(),
            'nav'           => $this->navtheme,
            'type'          => $type,
        ];
    }

    /**
     * Get the activities data.
     *
     * @return array
     */
    protected function getActivities()
    {
        $activities = $this->activities->getMultiple(['sort' => 'order:asc']);

        $this->getSchedules($activities);

        return $activities;
    }

    /**
     * Get the schedules of the given activities collection.
     *
     * @param  Collection  $activities
     * @return this
     */
    protected function getSchedules($activities)
    {
        $activities->load(['schedules' => function ($query) {
            $query->orderBy('held_at', 'asc');
        }]);

        return $this;
    }

    /**
     * Get the registration condition data.
     *
     * @param  int  $id
     * @return bool
     */
    protected function getRegsCondition()
    {
        $stage = resolve('stage.current');

        return [
            'competition' => $stage->isOn(StageService::STAGE_REGISTRATION),
            'non_competition' => ! ($stage->isOn(StageService::STAGE_PRE_REGISTRATION) || $stage->isOn(StageService::STAGE_POST_EVENT)),
        ];
    }

}
