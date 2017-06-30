<?php

namespace App\Modules\Electrons\Activities;

use App\User;
use App\Modules\Models\Entry;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntryPolicy
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
     * Determine whether the user can view the entry.
     *
     * @param  \App\User  $user
     * @param  Entry  $entry
     * @return mixed
     */
    public function view(User $user, Entry $entry)
    {
        return $user->hasKey('view-entries') || $user->entry->id === $entry->id;
    }

    /**
     * Determine whether the user can modify the entry.
     *
     * @param  \App\User  $user
     * @param  Entry  $entry
     * @return mixed
     */
    public function post(User $user, Entry $entry)
    {
        return $user->hasKey('post-entries');
    }

    /**
     * Determine whether the user can add submissions to the entry.
     *
     * @param  \App\User  $user
     * @param  Entry  $entry  
     * @return mixed
     */
    public function submissions(User $user, Entry $entry)
    {
        return $user->hasKey('post-entries-submissions') || 
            $user->entry->id === $entry->id;
    }

    /**
     * Determine whether the user can add documents to the entry.
     *
     * @param  \App\User  $user
     * @param  Entry  $entry  
     * @return mixed
     */
    public function documents(User $user, Entry $entry)
    {
        return $user->hasKey('post-entries-documents') ||
            $user->entry->id === $entry->id;
    }

    /**
     * Determine whether the user can add testimonials to the entry.
     *
     * @param  \App\User  $user
     * @param  Entry  $entry  
     * @return mixed
     */
    public function testimonials(User $user, Entry $entry)
    {
        return $user->hasKey('post-entries-testimonials') ||
            $user->entry->id === $entry->id;
    }

    /**
     * Determine whether the user can start attempts in the entry.
     *
     * @param  \App\User  $user
     * @param  Entry  $entry  
     * @return mixed
     */
    public function attempts(User $user, Entry $entry)
    {
        return $user->hasKey('post-entries-attempts') ||
            $user->entry->id === $entry->id;
    }
}
