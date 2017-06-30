<?php

namespace App\Modules\Electrons\News;

use App\User;
use App\Modules\Models\News;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
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
     * Determine whether the user can view the news list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the news.
     *
     * @param  \App\User  $user
     * @param  News  $news
     * @return mixed
     */
    public function view(User $user, News $news)
    {
        return true;
    }

    /**
     * Determine whether the user can create news.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-news');
    }

    /**
     * Determine whether the user can update the news.
     *
     * @param  \App\User  $user
     * @param  News  $news
     * @return mixed
     */
    public function put(User $user, News $news)
    {
        return $user->hasKey('put-news');
    }

    /**
     * Determine whether the user can delete the news.
     *
     * @param  \App\User  $user
     * @param  News  $news
     * @return mixed
     */
    public function delete(User $news, News $news)
    {
        return $user->hasKey('delete-news');
    }
}
