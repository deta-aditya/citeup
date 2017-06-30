<?php

namespace App\Modules\Electrons\Galleries;

use App\User;
use App\Modules\Models\Gallery;
use Illuminate\Auth\Access\HandlesAuthorization;

class GalleryPolicy
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
     * Determine whether the user can view the gallery list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the gallery.
     *
     * @param  \App\User  $user
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function view(User $user, Gallery $gallery)
    {
        return true;
    }

    /**
     * Determine whether the user can create gallery.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-galleries');
    }

    /**
     * Determine whether the user can update the gallery.
     *
     * @param  \App\User  $user
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function put(User $user, Gallery $gallery)
    {
        return $user->hasKey('put-galleries');
    }

    /**
     * Determine whether the user can delete the gallery.
     *
     * @param  \App\User  $user
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function delete(User $gallery, Gallery $gallery)
    {
        return $user->hasKey('delete-galleries');
    }
}
