<?php

namespace App\Modules\Electrons\Testimonials;

use App\User;
use App\Modules\Models\Testimonial;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestimonialPolicy
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
     * Determine whether the user can view the testimonial list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the testimonial.
     *
     * @param  \App\User  $user
     * @param  Testimonial  $testimonial
     * @return mixed
     */
    public function view(User $user, Testimonial $testimonial)
    {
        return true;
    }

    /**
     * Determine whether the user can create testimonial.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-testimonials') || $user->isEntrant();
    }

    /**
     * Determine whether the user can update the testimonial.
     *
     * @param  \App\User  $user
     * @param  Testimonial  $testimonial
     * @return mixed
     */
    public function put(User $user, Testimonial $testimonial)
    {
        return $user->hasKey('put-testimonials') || (
                $user->isEntrant() && 
                ($user->entry->id === $testimonial->entry->id)
            );
    }

    /**
     * Determine whether the user can delete the testimonial.
     *
     * @param  \App\User  $user
     * @param  Testimonial  $testimonial
     * @return mixed
     */
    public function delete(User $user, Testimonial $testimonial)
    {
        return $user->hasKey('delete-testimonials');
    }
}
