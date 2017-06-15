<?php

namespace App\Modules\Electrons\Activities;

use App\Modules\Models\Schedule;
use App\Modules\Nucleons\Service;

class ScheduleService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Schedule
     */
    protected $model = Schedule::class;

    /**
     * Get multiple schedules with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        if (array_has($params, 'activity')) {
            $query->ofActivity($params['activity']);
        }

        return $query->get();
    }

    /**
     * Create a new schedule and return it.
     *
     * @param  array  $data
     * @return Schedule
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $cleaned['activity_id'] = $data['activity'];

        $schedule = Schedule::create($cleaned);

        return $schedule;
    }

    /**
     * Update a schedule with new data.
     *
     * @param  Schedule  $schedule
     * @param  array     $data
     * @return this
     */
    public function update(Schedule $schedule, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $schedule->{$field} = $value;
        }

        $schedule->save();

        return $this;
    }

    /**
     * Remove a schedule from the database.
     *
     * @param  Schedule  $schedule
     * @return this
     */
    public function remove(Schedule $schedule)
    {
        $schedule->delete();

        return $this;
    }
}
