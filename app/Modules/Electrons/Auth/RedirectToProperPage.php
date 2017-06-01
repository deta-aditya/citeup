<?php

namespace App\Modules\Electrons\Auth;

use App\User;

trait RedirectToProperPage 
{
    /**
     * Redirect properly based on the user's role.
     *
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectProperly(User $user)
    {
        return redirect('/home');
    }
}
