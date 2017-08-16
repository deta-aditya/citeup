<?php

namespace App\Web\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Modules\Electrons\Auth\Requests\RegistrationRequest;
use App\Modules\Electrons\Auth\Requests\RegisterLombaLogikaRequest;
use App\Modules\Electrons\Auth\Requests\RegisterLombaDesainRequest;
use App\Modules\Electrons\Auth\Requests\RegisterSeminarItRequest;
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

        // $this->middleware('recaptcha')->only([
        //     'registerLombaLogika', 
        //     'registerLombaDesain',
        //     'registerSeminarIt',
        // ]);

        // Apply password grant middleware to register method
        // $this->middleware('grant')->only('register');
    }

    /**
     * Show the registration index page.
     *
     * @param  Activities  $activities
     * @return Response
     */
    public function index(Activities $activities)
    {
        $data = [
            'nav' => 'light',
            'activities' => $activities->getMultiple(['sort' => 'order:asc']),
        ];

        return view('auth.register.index', $data);
    }

    /**
     * Show the registration form page.
     *
     * @param  Activities   $activities
     * @param  string       $id
     * @param  string|null  $name
     * @return Response
     */
    public function form(Activities $activities, $id, $name = null)
    {
        $data = [
            'nav' => 'light',
            'activity' => $activities->getMultiple(['condition' => 'id:=:'. $id]),
        ];

        switch ($id) {
            case 1: $name = 'logika'; break;
            case 2: $name = 'desain'; break;
            case 3: $name = 'seminar'; break;
        }

        return view('auth.register.' . $name, $data);
    }

    /**
     * Handle a register request for lomba logika.
     *
     * @param  RegisterLombaLogikaRequest  $request
     * @param  Users                       $users
     * @param  Roles                       $roles
     * @param  Entries                     $entries
     * @return RedirectResponse
     */
    public function registerLombaLogika(RegisterLombaLogikaRequest $request, Users $users, Entries $entries, Roles $roles)
    {
        if ($users->isAlreadyRegistered($request->input('user_0_email'))) {
            return $this->toLogin();
        }

        $all = $request->all();

        $entryData = $this->extractPrefixedData($all, 'entry_');
        $leaderData = $this->extractPrefixedData($all, 'user_0_');
        $crew1Data = $this->extractPrefixedData($all, 'user_1_');
        $crew2Data = $this->extractPrefixedData($all, 'user_2_');

        $entry = $this->createEntry($entries, $entryData, 1);
        
        $leader = $this->registerUser($users, $roles, $leaderData, $entry->id, false);
        $this->registerUser($users, $roles, $crew1Data, $entry->id, true);
        $this->registerUser($users, $roles, $crew2Data, $entry->id, true);

        return $this->postRegistration($leader);
    }

    /**
     * Handle a register request for lomba desain grafis.
     *
     * @param  RegisterLombaDesainRequest  $request
     * @param  Users                       $users
     * @param  Roles                       $roles
     * @param  Entries                     $entries
     * @return RedirectResponse
     */
    public function registerLombaDesain(RegisterLombaDesainRequest $request, Users $users, Entries $entries, Roles $roles)
    {
        if ($users->isAlreadyRegistered($request->input('user_email'))) {
            return $this->toLogin();
        }

        $all = $request->all();

        $entryData = $this->extractPrefixedData($all, 'entry_');
        $userData = $this->extractPrefixedData($all, 'user_');

        $entryData['name'] = $userData['name'] = $request->input('name');

        $entry = $this->createEntry($entries, $entryData, 2);
        
        $user = $this->registerUser($users, $roles, $userData, $entry->id, false);

        return $this->postRegistration($user);
    }

    /**
     * Handle a register request for seminar it.
     *
     * @param  RegisterLombaDesainRequest  $request
     * @param  Users                       $users
     * @param  Roles                       $roles
     * @param  Entries                     $entries
     * @return RedirectResponse
     */
    public function registerSeminarIt(RegisterSeminarItRequest $request, Users $users, Entries $entries, Roles $roles)
    {
        if ($users->isAlreadyRegistered($request->input('user_email'))) {
            return $this->toLogin();
        }

        $all = $request->all();

        $entryData = $this->extractPrefixedData($all, 'entry_');
        $userData = $this->extractPrefixedData($all, 'user_');

        $entryData['name'] = $userData['name'] = $request->input('name');

        $entry = $this->createEntry($entries, $entryData, 3);
        
        $user = $this->registerUser($users, $roles, $userData, $entry->id, false);

        return $this->postRegistration($user);
    }

    /**
     * Redirect to login form.
     *
     * @return RedirectResponse
     */
    protected function toLogin()
    {
        return redirect()->route('login.form')->withErrors([
            'email' => 'E-mail Anda sudah terdaftar! Silahkan login.'
        ])->withInput();
    }

    protected function extractPrefixedData($data, $prefix)
    {
        $result = [];

        foreach ($data as $key => $value) {
            if (strpos($key, $prefix) !== false) 
                $result[str_replace($prefix, '', $key)] = $value;
        }

        return $result;
    }

    protected function createEntry($entryService, $entryData, $activityId)
    {
        $entryData['activity'] = $activityId;

        return $entryService->create($entryData);
    }

    protected function registerUser($userService, $roleService, $userData, $entryId, $crew)
    {
        $userData['entry'] = $entryId;

        if ($crew) {
            $userData['crew'] = $crew;
        }

        $user =  $userService->create($userData);

        $roleService->associate($user, Roles::ROLE_ENTRANT);

        return $user;
    }

    protected function postRegistration($user)
    {
        event(new Registered($user));

        $this->guard()->login($user);

        $this->passport();

        return redirect()->route('dashboard');
    }
}
