<?php

namespace App\Modules\Electrons\Alerts;

use App\User;
use App\Modules\Models\Alert;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlertPolicy
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
     * Determine whether the user can view the alert list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return $user->hasKey('get-alerts') || (
            ! request()->has('users') && 
            request('seenby', $user->id) == $user->id && 
            request('unseenby', $user->id) == $user->id
        );
    }

    /**
     * Determine whether the user can view the alert.
     *
     * @param  \App\User  $user
     * @param  Alert  $alert
     * @return mixed
     */
    public function view(User $user, Alert $alert)
    {
        return $user->hasKey('view-alerts') || 
            $alert->users->search(function ($item, $key) use ($user)) {
                return $item->id === $user->id;
            }) !== false;
    }

    /**
     * Determine whether the user can create alert.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-alerts');
    }

    /**
     * Determine whether the user can update the alert.
     *
     * @param  \App\User  $user
     * @param  Alert  $alert
     * @return mixed
     */
    public function put(User $user, Alert $alert)
    {
        return $user->hasKey('put-alerts');
    }

    /**
     * Determine whether the user can delete the alert.
     *
     * @param  \App\User  $user
     * @param  Alert  $alert
     * @return mixed
     */
    public function delete(User $alert, Alert $alert)
    {
        return $user->hasKey('delete-alerts');
    }

    /**
     * Determine whether the user can announce the alert to users.
     *
     * @param  \App\User  $user
     * @param  Alert  $alert  
     * @return mixed
     */
    public function users(User $user, Alert $alert)
    {
        return $user->hasKey('post-alerts-users');
    }
}
