<?php

namespace App\Modules\Electrons\Submissions;

use App\User;
use App\Modules\Models\Submission;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionPolicy
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
     * Determine whether the user can view the submission list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return $user->hasKey('get-submissions') || 
            $user->entry->id == request('entry', $user->entry->id);
    }

    /**
     * Determine whether the user can view the submission.
     *
     * @param  \App\User  $user
     * @param  Submission  $submission
     * @return mixed
     */
    public function view(User $user, Submission $submission)
    {
        return $user->hasKey('view-submissions') || $user->entry->id === $submission->entry->id;
    }

    /**
     * Determine whether the user can create submission.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-submissions') || $user->isEntrant();
    }

    /**
     * Determine whether the user can update the submission.
     *
     * @param  \App\User  $user
     * @param  Submission  $submission
     * @return mixed
     */
    public function put(User $user, Submission $submission)
    {
        return $user->hasKey('put-submissions') || (
                $user->isEntrant() && 
                ($user->entry->id === $submission->entry->id)
            );
    }

    /**
     * Determine whether the user can delete the submission.
     *
     * @param  \App\User  $user
     * @param  Submission  $submission
     * @return mixed
     */
    public function delete(User $user, Submission $submission)
    {
        return $user->hasKey('delete-submissions');
    }
}
