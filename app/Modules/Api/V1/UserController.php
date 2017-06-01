<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Electrons\Users\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
    public function index(UserService $users)
    {
        $this->users = $users;
    }

    /**
     * Get an array of users with custom conditions
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return response()->json($this->users->getMultiple($request->all()));
    }
}
