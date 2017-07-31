<?php

namespace App\Modules\Electrons\Auth;

use App\User;
use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Users\RoleService;
use App\Modules\Electrons\Auth\Requests\RegistrationRequest;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

trait RegisterController
{
    use RegistersUsers, AuthorizeToPassport, RedirectToProperPage;

    /**
     * Handle a registration request for the application.
     *
     * @param  RegistrationRequest  $request
     * @param  UserService  $users
     * @return \Illuminate\Http\Response
     */
    public function register(RegistrationRequest $request, UserService $users, RoleService $roles)
    {
        event(new Registered($user = $users->create($request->all())));

        $roles->associate($user, RoleService::ROLE_ENTRANT);

        $this->guard()->login($user);

        return $this->registered($request, $user);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return mixed
     */
    protected function registered(Request $request, User $user)
    {
        // Authorize the application to Laravel Passport
        $this->passport();
        
        // Redirect to the right page based on user's role
        return $this->redirectProperly($user);
    }
}
