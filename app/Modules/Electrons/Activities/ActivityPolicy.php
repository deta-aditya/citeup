<?php

namespace App\Modules\Electrons\Activities;

use App\User;
use App\Modules\Models\Activity;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityPolicy
{
    use HandlesAuthorization;

    /**
     * The before hook.
     *
     * @param  User    $user
     * @param  string  $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the activity list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the activity.
     *
     * @param  \App\User  $user
     * @param  Activity  $activity
     * @return mixed
     */
    public function view(User $user, Activity $activity)
    {
        return true;
    }

    /**
     * Determine whether the user can create activity.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-activities');
    }

    /**
     * Determine whether the user can update the activity.
     *
     * @param  \App\User  $user
     * @param  Activity  $activity
     * @return mixed
     */
    public function put(User $user, Activity $activity)
    {
        return $user->hasKey('put-activities');
    }

    /**
     * Determine whether the user can delete the activity.
     *
     * @param  \App\User  $user
     * @param  Activity  $activity
     * @return mixed
     */
    public function delete(User $activity, Activity $activity)
    {
        return $user->hasKey('delete-activities');
    }

    /**
     * Determine whether the user can add schedules to the activity.
     *
     * @param  \App\User  $user
     * @param  Activity  $activity  
     * @return mixed
     */
    public function schedules(User $user, Activity $activity)
    {
        return $user->hasKey('post-activities-schedules');
    }
}
