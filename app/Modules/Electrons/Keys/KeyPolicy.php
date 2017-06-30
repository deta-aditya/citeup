<?php

namespace App\Modules\Electrons\Keys;

use App\User;
use App\Modules\Models\Key;
use Illuminate\Auth\Access\HandlesAuthorization;

class KeyPolicy
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
     * Determine whether the user can view the key list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the key.
     *
     * @param  \App\User  $user
     * @param  Key  $key
     * @return mixed
     */
    public function view(User $user, Key $key)
    {
        return false;
    }

    /**
     * Determine whether the user can create key.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the key.
     *
     * @param  \App\User  $user
     * @param  Key  $key
     * @return mixed
     */
    public function put(User $user, Key $key)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the key.
     *
     * @param  \App\User  $user
     * @param  Key  $key
     * @return mixed
     */
    public function delete(User $key, Key $key)
    {
        return false;
    }

    /**
     * Determine whether the user can register the key to users.
     *
     * @param  \App\User  $user
     * @param  Key  $key  
     * @return mixed
     */
    public function users(User $user, Key $key)
    {
        return false;
    }
}
