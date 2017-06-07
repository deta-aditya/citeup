<?php

namespace App\Modules\Electrons\Auth;

use App\User;
use App\Modules\Electrons\Auth\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

trait LoginController
{
    use AuthenticatesUsers, AuthorizeToPassport, RedirectToProperPage;

    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically
        // throttle the login attempts for this application. We'll key this by
        // the username and the IP address of the client making these requests
        // into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of
        // attempts to login and redirect the user back to the login form. Of
        // course, when this user surpasses their maximum number of attempts
        // they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return Response|RedirectResponse
     */
    protected function authenticated(Request $request, User $user)
    {
        // Authorize the application to Laravel Passport
        $this->passport();
        
        // Redirect to the right page based on user's role
        return $this->redirectProperly($user);
    }
}
