<?php

namespace App\Web\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Modules\Electrons\Auth\Requests\LoginRequest;
use App\Modules\Electrons\Activities\ActivityService as Activities;
use App\Modules\Electrons\Activities\EntryService as Entries;
use App\Modules\Electrons\Users\UserService as Users;
use App\Modules\Electrons\Users\RoleService as Roles;
use App\Modules\Electrons\Auth\AuthorizeToPassport;
use App\Http\Controllers\Controller;
use App\User;

class LoginController extends Controller
{
    use AuthenticatesUsers, AuthorizeToPassport;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        // Apply password grant middleware to register method
        $this->middleware('grant')->only('register');
    }

    /**
     * Show the login form page.
     *
     * @return Response
     */
    public function form()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     * @return Response
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

        // Authorize the application to Laravel Passport.
        $this->passport();
        
        // Redirect to the right page.
        return redirect('app');
    }

}
