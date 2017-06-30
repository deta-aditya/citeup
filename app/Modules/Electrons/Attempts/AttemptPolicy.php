<?php

namespace App\Modules\Electrons\Attempts;

use App\User;
use App\Modules\Models\Attempt;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttemptPolicy
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
     * Determine whether the user can view the attempt list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return $user->hasKey('get-attempts') || 
            $user->entry->id == request('entry', $user->entry->id);
    }

    /**
     * Determine whether the user can view the attempt.
     *
     * @param  \App\User  $user
     * @param  Attempt  $attempt
     * @return mixed
     */
    public function view(User $user, Attempt $attempt)
    {
        return $user->hasKey('view-attempts') || $user->entry->id === $attempt->entry->id;
    }

    /**
     * Determine whether the user can start attempts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-attempts') || $user->isEntrant();
    }

    /**
     * Determine whether the user can finish the attempt.
     *
     * @param  \App\User  $user
     * @param  Attempt  $attempt
     * @return mixed
     */
    public function put(User $user, Attempt $attempt)
    {
        return $user->hasKey('put-attempts') || (
                $user->isEntrant() && 
                ($user->entry->id === $attempt->entry->id)
            );
    }

    /**
     * Determine whether the user can delete the attempt.
     *
     * @param  \App\User  $user
     * @param  Attempt  $attempt
     * @return mixed
     */
    public function delete(User $user, Attempt $attempt)
    {
        return $user->hasKey('delete-attempts');
    }

    /**
     * Determine whether the user can add answers to the attempt.
     *
     * @param  \App\User  $user
     * @param  Attempt  $attempt
     * @return mixed
     */
    public function answers(User $user, Attempt $attempt)
    {
        return $user->hasKey('post-attempts-answers') || $user->isEntrant();
    }
}
