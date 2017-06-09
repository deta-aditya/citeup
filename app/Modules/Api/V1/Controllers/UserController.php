<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Users\RoleService;
use App\Modules\Electrons\Users\ProfileService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use JsonApiController;

    /**
     * A user service instance
     *
     * @var UserService
     */
    protected $users;

    /**
     * Create a new controller instance
     *
     * @param  UserService  $users
     * @return void
     */
    public function __construct(UserService $users)
    {
        $this->users = $users;
    }

    /**
     * Get an array of users data
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->respondJson(
            ['users' => $this->users->getMultiple($request->all())]
        );
    }

    /**
     * Insert a new user data
     *
     * @param  Request         $request
     * @param  RoleService     $roles
     * @param  ProfileService  $profiles
     * @return Response
     */
    public function insert(
        Request $request, 
        RoleService $roles, 
        ProfileService $profiles)
    {
        $user = $this->users->create($request->all());

        $roles->associateRole($user, $request->input('role'));

        $profiles->makeProfile($user, $request->all());

        if ($user->isEntrant()) {
            //
        }

        return $this->respondJson(['user' => $user]);
    }

}
