<?php

namespace App\Modules\Electrons\Sponsors;

use App\User;
use App\Modules\Models\Sponsor;
use Illuminate\Auth\Access\HandlesAuthorization;

class SponsorPolicy
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
     * Determine whether the user can view the sponsor list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the sponsor.
     *
     * @param  \App\User  $user
     * @param  Sponsor  $sponsor
     * @return mixed
     */
    public function view(User $user, Sponsor $sponsor)
    {
        return true;
    }

    /**
     * Determine whether the user can create sponsor.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-sponsors');
    }

    /**
     * Determine whether the user can update the sponsor.
     *
     * @param  \App\User  $user
     * @param  Sponsor  $sponsor
     * @return mixed
     */
    public function put(User $user, Sponsor $sponsor)
    {
        return $user->hasKey('put-sponsors');
    }

    /**
     * Determine whether the user can delete the sponsor.
     *
     * @param  \App\User  $user
     * @param  Sponsor  $sponsor
     * @return mixed
     */
    public function delete(User $user, Sponsor $sponsor)
    {
        return $user->hasKey('delete-sponsors');
    }
}
