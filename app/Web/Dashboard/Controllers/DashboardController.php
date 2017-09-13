<?php

namespace App\Web\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Users\UserService as Users;
use App\Modules\Electrons\Stages\StageService as Stages;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the dashboard page.
     * The whole part here will be controller by vue-router.
     *
     * @param  Users   $users
     * @param  string  $vue
     * @return Response
     */
    public function index(Users $users, $vue = '')
    {
        $user = auth()->user();

        $users->loadRelationships($user);

        return view('dashboard.app', [
            'user' => $user
        ]);
    }

    /**
     * Show the elimination page.
     *
     * @return Response
     */
    public function elimination(Stages $stages)
    {
        return view('elimination.app', [
            'entrant' => auth()->user()->entry,
            'elimination' => $stages->get(Stages::STAGE_ELIMINATION)
        ]);
    }
}
