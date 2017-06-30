<?php

namespace App\Modules\Electrons\Questions;

use App\User;
use App\Modules\Models\Choice;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChoicePolicy
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
     * Determine whether the user can view the choice list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return $user->hasKey('get-choices') || $user->isEntrant();
    }

    /**
     * Determine whether the user can view the choice.
     *
     * @param  \App\User  $user
     * @param  Choice  $choice
     * @return mixed
     */
    public function view(User $user, Choice $choice)
    {
        return $user->hasKey('view-choices') || $user->isEntrant();
    }

    /**
     * Determine whether the user can start choices.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-choices');
    }

    /**
     * Determine whether the user can finish the choice.
     *
     * @param  \App\User  $user
     * @param  Choice  $choice
     * @return mixed
     */
    public function put(User $user, Choice $choice)
    {
        return $user->hasKey('put-choices');
    }

    /**
     * Determine whether the user can delete the choice.
     *
     * @param  \App\User  $user
     * @param  Choice  $choice
     * @return mixed
     */
    public function delete(User $user, Choice $choice)
    {
        return $user->hasKey('delete-choices');
    }
}
