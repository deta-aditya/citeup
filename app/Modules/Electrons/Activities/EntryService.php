<?php

namespace App\Modules\Electrons\Activities;

use App\User;
use App\Modules\Models\Entry;
use App\Modules\Models\Activity;
use App\Modules\Nucleons\Service;

class EntryService extends Service
{
    /**
     * The just registered stage.
     */
    const STAGE_REGISTERED_ENTRANT = 0;

    /**
     * The "done test" stage.
     */
    const STAGE_TESTED_ENTRANT = 1;

    /**
     * The finalist stage.
     */
    const STAGE_FINALIST = 2;

    /**
     * The re-registered finalist stage.
     */
    const STAGE_REGISTERED_FINALIST = 3;

    /**
     * The "done test" finalist stage.
     */
    const STAGE_TESTED_FINALIST = 4;

    /**
     * The winner stage.
     */
    const STAGE_WINNER = 5;

    /**
     * The suspended/disqualified status.
     */
    const STATUS_SUSPENDED = 0;

    /**
     * The active status.
     */
    const STATUS_ACTIVE = 1;

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

    /**
     * Modify stage of the given entry.
     *
     * @param  Entry  $entry
     * @param  int    $stage
     * @return $this
     */
    public function modifyStage(Entry $entry, $stage)
    {
        if (! is_null($stage)) {
            
            $entry->stage = $stage;

            $entry->save();
        }

        return $this;
    }

    /**
     * Modify status of the given entry.
     *
     * @param  Entry  $entry
     * @param  int    $status
     * @return $this
     */
    public function modifyStatus(Entry $entry, $status)
    {
        if (! is_null($status)) {
            
            $entry->status = $status;

            $entry->save();
        }

        return $this;
    }
}
