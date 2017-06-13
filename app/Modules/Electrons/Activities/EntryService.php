<?php

namespace App\Modules\Electrons\Activities;

use App\User;
use App\Modules\Models\Entry;
use App\Modules\Models\Activity;
use App\Modules\Nucleons\Service;

class EntryService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Entry
     */
    protected $model = Entry::class;

    /**
     * Create the entry for a user.
     *
     * @param  User          $user
     * @param  Activity|int  $activity
     * @param  array         $data
     * @return this
     */
    public function make(User $user, $activity, array $data = [])
    {
        $cleaned = $this->clean($data);

        if ($activity instanceof Activity) {
            $cleaned['activity_id'] = $activity->id;
        } else {
            $cleaned['activity_id'] = $activity;
        }

        $entry = $user->entry()->create($cleaned);

        return $this;
    }
}
