<?php

namespace App\Modules\Api\V1\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Users\RoleService;
use App\Modules\Electrons\Users\ProfileService;
use App\Modules\Electrons\Activities\EntryService;
use App\Modules\Electrons\Storage\StorageService;
use App\Modules\Electrons\Keys\KeyService;
use App\Modules\Electrons\Alerts\AlertService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Users\UserIndexRequest;
use App\Modules\Api\V1\Requests\Users\UserInsertRequest;
use App\Modules\Api\V1\Requests\Users\UserUpdateRequest;
use App\Modules\Api\V1\Requests\Users\GrantKeysRequest;
use App\Modules\Api\V1\Requests\Users\SeeAlertRequest;
use App\Modules\Api\V1\Requests\Keys\KeyIndexRequest;
use App\Modules\Api\V1\Requests\Alerts\AlertIndexRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use JsonApiController;

    /**
     * A user service instance.
     *
     * @var UserService
     */
    protected $users;

    /**
     * Create a new controller instance.
     *
     * @param  UserService  $users
     * @return void
     */
    public function __construct(UserService $users)
    {
        $this->users = $users;
    }

    /**
     * Get an array of users data.
     *
     * @param  UserIndexRequest  $request
     * @return Response
     */
    public function index(UserIndexRequest $request)
    {
        return $this->respondJson(
            ['users' => $this->users->getMultiple($request->all())]
        );
    }

    /**
     * Get a user data.
     *
     * @param  Request  $request
     * @param  User     $user
     * @return Response
     */
    public function show(Request $request, User $user)
    {
        $this->users->loadRelationships($user);

        return $this->respondJson(['user' => $user]);   
    }

    /**
     * Insert a new user data.
     *
     * @param  UserInsertRequest  $request
     * @param  RoleService        $roles
     * @param  ProfileService     $profiles
     * @param  EntryService       $entries
     * @return Response
     */
    public function insert(
        UserInsertRequest $request, 
        RoleService $roles, 
        ProfileService $profiles,
        EntryService $entries)
    {
        $user = $this->users->create($request->all());

        $roles->associate($user, $request->input('role'));

        $profiles->make($user, $request->all());

        if ($user->isEntrant()) {
            $entries->make($user, $request->input('activity'), $request->all());
        }

        return $this->respondJson(['user' => $user]);
    }

    /**
     * Update a user data.
     *
     * @param  UserUpdateRequest  $request
     * @param  User               $user
     * @param  RoleService        $roles
     * @param  ProfileService     $profiles
     * @return Response
     */
    public function update(
        UserUpdateRequest $request, 
        User $user,
        RoleService $roles, 
        ProfileService $profiles)
    {
        $this->users->update($user, $request->all());

        $roles->associate($user, $request->input('role', $user->role));

        $profiles->update($user, $request->all());

        return $this->respondJson(['user' => $user]);
    }

    /**
     * Delete a user data.
     *
     * @param  Request         $request
     * @param  User            $user
     * @param  StorageService  $storages
     * @return Response
     */
    public function remove(Request $request, User $user, StorageService $storages)
    {
        $this->users->remove($user);

        $storages->destroy('images', $user->id, 'profile');

        return $this->respondJson(['user' => $user]);
    }

    /**
     * Get keys owned by the given user.
     *
     * @param  KeyIndexRequest  $request
     * @param  User              $user
     * @param  KeyService        $keys
     * @return Response
     */
    public function keys(KeyIndexRequest $request, User $user, KeyService $keys)
    {
        $queries = $request->all();

        $queries['users'] = $user->id;

        return $this->respondJson(
            ['keys' => $keys->getMultiple($queries)]
        );
    }

    /**
     * Modify keys ownership to the given user.
     *
     * @param  GrantKeysRequest  $request
     * @param  User              $user
     * @param  KeyService        $keys
     * @return Response
     */
    public function grantKeys(GrantKeysRequest $request, User $user, KeyService $keys)
    {
        $keys->grant($user, $request->input('grant', []))
             ->ungrant($user, $request->input('ungrant', []));

        return $this->respondJson(
            ['keys' => $keys->getMultiple(['users' => $user->id])]
        );
    }

    /**
     * Get alerts announced to the given user.
     *
     * @param  AlertIndexRequest  $request
     * @param  User               $user
     * @param  AlertService       $alerts
     * @return Response
     */
    public function alerts(AlertIndexRequest $request, User $user, AlertService $alerts)
    {
        $queries = $request->all();

        $queries['users'] = $user->id;

        return $this->respondJson(
            ['alerts' => $alerts->getMultiple($queries)]
        );
    }

    /**
     * See or unsee alerts by the given user.
     *
     * @param  SeeAlertRequest  $request
     * @param  User             $user
     * @param  AlertService     $alerts
     * @return Response
     */
    public function seeAlerts(SeeAlertRequest $request, User $user, AlertService $alerts)
    {
        $alerts->see($user, $request->input('see', []))
             ->unsee($user, $request->input('unsee', []));

        return $this->respondJson(
            ['alerts' => $alerts->getMultiple(['users' => $user->id])]
        );
    }
}
