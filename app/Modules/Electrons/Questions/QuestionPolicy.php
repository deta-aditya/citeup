<?php

namespace App\Modules\Electrons\Questions;

use App\User;
use App\Modules\Models\Question;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
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
     * Determine whether the user can view the question list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return $user->hasKey('get-questions') || $user->isEntrant();
    }

    /**
     * Determine whether the user can view the question.
     *
     * @param  \App\User  $user
     * @param  Question  $question
     * @return mixed
     */
    public function view(User $user, Question $question)
    {
        return $user->hasKey('view-questions') || $user->isEntrant();
    }

    /**
     * Determine whether the user can start questions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-questions');
    }

    /**
     * Determine whether the user can finish the question.
     *
     * @param  \App\User  $user
     * @param  Question  $question
     * @return mixed
     */
    public function put(User $user, Question $question)
    {
        return $user->hasKey('put-questions');
    }

    /**
     * Determine whether the user can delete the question.
     *
     * @param  \App\User  $user
     * @param  Question  $question
     * @return mixed
     */
    public function delete(User $user, Question $question)
    {
        return $user->hasKey('delete-questions');
    }

    /**
     * Determine whether the user can add choices to the question.
     *
     * @param  \App\User  $user
     * @param  Question  $question
     * @return mixed
     */
    public function choices(User $user, Question $question)
    {
        return $user->hasKey('post-questions-choices');
    }
}
