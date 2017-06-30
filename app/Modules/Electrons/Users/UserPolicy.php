<?php

namespace App\Modules\Electrons\Users;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Determine whether the user can view the user list.
     *
     * @param  \App\User  $accessor
     * @return mixed
     */
    public function get(User $accessor)
    {
        return $accessor->hasKey('get-users');
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $accessor
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $accessor, User $user)
    {
        return $accessor->hasKey('view-users') || (
                ($accessor->isEntrant() && $accessor->id === $user->id) || 
                ($accessor->isCommittee() && ! $user->isAdmin())
            );
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $accessor
     * @return mixed
     */
    public function post(User $accessor)
    {
        return $accessor->hasKey('post-users');
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $accessor
     * @param  \App\User  $user
     * @return mixed
     */
    public function put(User $accessor, User $user)
    {
        return $accessor->hasKey('put-users') || $accessor->id === $user->id;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $accessor
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $accessor, User $user)
    {
        return $accessor->hasKey('delete-users') && $accessor->id !== $user->id;
    }

    /**
     * Determine whether the user can grant keys owned by the user.
     *
     * @param  \App\User  $accessor
     * @param  \App\User  $user
     * @return mixed
     */
    public function keys(User $accessor, User $user)
    {
        return $accessor->hasKey('post-users-keys');
    }

    /**
     * Determine whether the user can see alerts of the user.
     *
     * @param  \App\User  $accessor
     * @param  \App\User  $user
     * @return mixed
     */
    public function alerts(User $accessor, User $user)
    {
        return $accessor->hasKey('post-users-alerts') || $accessor->id === $user->id;
    }

    /**
     * Determine whether the user can modify entries of the user.
     *
     * @param  \App\User  $accessor
     * @param  \App\User  $user
     * @return mixed
     */
    public function entries(User $accessor, User $user)
    {
        return $accessor->hasKey('post-users-entries');
    }
}
