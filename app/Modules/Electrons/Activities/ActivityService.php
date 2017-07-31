<?php

namespace App\Modules\Electrons\Activities;

use Carbon\Carbon;
use App\Modules\Models\Activity;
use App\Modules\Nucleons\Service;

class ActivityService extends Service
{
    /**
     * The URL to the default icon.
     *
     * @var string
     */
    protected $defaultIcon = 'storage/images/default.jpg';

    /**
     * The main model for the service.
     *
     * @var Activity
     */
    protected $model = Activity::class;

    /**
     * The default activities for application.
     *
     * @var array
     */
    protected $default = [
        ['name' => 'Lomba Logika', 'short_description' => 'Uji kemampuan berpikirmu dan teman-teman setimmu untuk menyelesaikan soal-soal logika berbasis ad-hoc yang seru dan menantang!'],
        ['name' => 'Lomba Desain Grafis', 'short_description' => 'Tunjukan bakat artistikmu di masa keemasan teknologi ini dengan mendesain poster terkeren yang pernah kamu buat!'],
        ['name' => 'Seminar IT', 'short_description' => 'Hadiri seminar teknologi informasi penuh inspirasi yang dibintangi oleh pembicara terbaik! Gratis untuk finalis kedua mata lomba.'],
    ];

    /**
     * Create all required activities.
     *
     * @return this
     */
    public function createAllRequired()
    {
        $now = Carbon::now()->toDateTimeString();

        $insertables = [];

        foreach ($this->default as $activity) {
            factory(Activity::class)->create($activity);
        }

        return $this;
    }

    /**
     * Get multiple activities with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        return $query->get();
    }

    /**
     * Create a new activity and return it.
     *
     * @param  array  $data
     * @return Activity
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        if (! array_has($cleaned, 'icon')) {
            $cleaned['icon'] = $this->defaultIcon;
        }

        $activity = Activity::create($cleaned);

        return $activity;
    }

    /**
     * Load mandatory relationships of the activity.
     *
     * @param  Activity  $activity
     * @return this
     */
    public function loadRelationships(Activity $activity)
    {
        $activity->load('schedules');

        return $this;
    }

    /**
     * Update an activity with new data.
     *
     * @param  Activity   $activity
     * @param  array      $data
     * @return this
     */
    public function update(Activity $activity, array $data)
    {
        $cleaned = $this->clean($data);
        
        foreach ($cleaned as $field => $value) {
            $activity->{$field} = $value;
        }

        $activity->save();

        return $this;
    }

    /**
     * Remove an activity from the database.
     *
     * @param  Activity  $activity
     * @return this
     */
    public function remove(Activity $activity)
    {
        $activity->delete();

        return $this;
    }

    /**
     * Determine whether any of the given values is an invalid ID.
     * 
     * @param  array  $ids
     * @return bool 
     */
    public function areInvalidId(array $ids)
    {
        try {
            $this->getModel()->query()->findOrFail($ids);
        } catch (ModelNotFoundException $e) {
            return true;
        }

        return false;
    }
}