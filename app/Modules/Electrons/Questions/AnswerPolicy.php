<?php

namespace App\Modules\Electrons\Questions;

use App\User;
use App\Modules\Models\Answer;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
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
     * Determine whether the user can view the answer list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return $user->hasKey('get-answers') || 
            ($user->isEntrant() && $user->attempts->search(function ($item, $key) {
                return $item->id == request('attempt', null);
            }) !== false);
    }

    /**
     * Determine whether the user can view the answer.
     *
     * @param  \App\User  $user
     * @param  Answer  $answer
     * @return mixed
     */
    public function view(User $user, Answer $answer)
    {
        return $user->hasKey('view-answers') || 
            ($user->isEntrant() && $user->attempts->search(function ($item, $key) {
                return $item->id === $answer->attempt->id;
            }) !== false);
    }

    /**
     * Determine whether the user can start answers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-answers') || $user->isEntrant();
    }

    /**
     * Determine whether the user can delete the answer.
     *
     * @param  \App\User  $user
     * @param  Answer  $answer
     * @return mixed
     */
    public function delete(User $user, Answer $answer)
    {
        return $user->hasKey('delete-answers');
    }
}
