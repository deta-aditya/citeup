<?php

namespace App\Web\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Modules\Electrons\Auth\Requests\RegistrationRequest;
use App\Modules\Electrons\Activities\ActivityService as Activities;
use App\Modules\Electrons\Activities\EntryService as Entries;
use App\Modules\Electrons\Users\ProfileService as Profiles;
use App\Modules\Electrons\Users\UserService as Users;
use App\Modules\Electrons\Users\RoleService as Roles;
use App\Modules\Electrons\Auth\AuthorizeToPassport;
use App\Http\Controllers\Controller;
use App\User;

class RegisterController extends Controller
{
    use RegistersUsers, AuthorizeToPassport;

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
     * Show the registration form page.
     *
     * @param  Activities  $activities
     * @return Response
     */
    public function form(Activities $activities)
    {
        $data = [
            'activities' => $activities->getMultiple([])
        ];

        return view('auth.register', $data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegistrationRequest  $request
     * @param  Users                $users
     * @param  Roles                $roles
     * @param  Entries              $entries
     * @param  Profiles             $profiles
     * @return RedirectResponse
     */
    public function register(
        RegistrationRequest $request, 
        Users $users, Roles $roles, 
        Entries $entries, Profiles $profiles)
    {
        // Check the email's availability on the user table.
        // Redirect immediately to login page if it is available.
        if ($users->isAlreadyRegistered($request->input('email'))) {
            return redirect()->route('login.form')->withErrors([
                'email' => 'E-mail Anda sudah terdaftar sebelumnya! Silahkan login.'
            ])->withInput();
        }

        // Register user and dispatch the built-in "Registered" event with it.
        event(new Registered($user = $users->create($request->all())));

        // The registered users will always be an entrant, so we associate the
        // registered user right away to prevent unwanted result.
        $roles->associate($user, Roles::ROLE_ENTRANT);

        // Ditto.
        $profiles->make($user, $request->all());

        // Ditto.
        $entries->make($user, $request->input('activity'));

        // Log the registered user in.
        $this->guard()->login($user);

        // Authorize the application to Laravel Passport.
        $this->passport();

        // Redirect to profile completion view on entrant app.
        return redirect('app/finishing');
    }

}
