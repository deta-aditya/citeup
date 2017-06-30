<?php

namespace App\Modules\Electrons\Activities;

use App\User;
use App\Modules\Models\Schedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
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
     * Determine whether the user can view the schedule list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the schedule.
     *
     * @param  \App\User  $user
     * @param  Schedule  $schedule
     * @return mixed
     */
    public function view(User $user, Schedule $schedule)
    {
        return true;
    }

    /**
     * Determine whether the user can create schedule.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-schedules');
    }

    /**
     * Determine whether the user can update the schedule.
     *
     * @param  \App\User  $user
     * @param  Schedule  $schedule
     * @return mixed
     */
    public function put(User $user, Schedule $schedule)
    {
        return $user->hasKey('put-schedules');
    }

    /**
     * Determine whether the user can delete the schedule.
     *
     * @param  \App\User  $user
     * @param  Schedule  $schedule
     * @return mixed
     */
    public function delete(User $user, Schedule $schedule)
    {
        return $user->hasKey('delete-schedules');
    }
}
