<?php

namespace App\Web\Front\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Config\Config;
use App\Modules\Electrons\Activities\ActivityService as Activities;
use App\Modules\Electrons\Activities\ScheduleService as Schedules;

class ActivitiesController extends Controller
{
    /**
     * The activity service instance.
     *
     * @var Activities
     */
    protected $activities;

    /**
     * The schedule service instance.
     *
     * @var Schedules
     */
    protected $schedule;

    /**
     * The web config instance.
     *
     * @var Config
     */
    protected $config;

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
     * @param  Config      $config
     * @return void
     */
    public function __construct(Activities $activities, Schedules $schedules, Config $config)
    {
        $this->activities = $activities;
        $this->schedules = $schedules;
        $this->config = $config;
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
            'config'        => $this->config->all(),
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
        $stage = $this->config->get('stage')['name'];

        return [
            'competition' => $stage === 'Pendaftaran',
            'non_competition' => ! ($stage === 'Pra-Pendaftaran' || $stage === 'Paska Acara'),
        ];
    }

}
