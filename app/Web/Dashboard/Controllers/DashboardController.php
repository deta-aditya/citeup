<?php

namespace App\Web\Dashboard\Controllers;

use Carbon\Carbon;
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
     * Show the elimination page for Lomba Logika.
     *
     * @return Response
     */
    public function elimination(Stages $stages)
    {
        $user = auth()->user();
        $settings = app('App\Modules\Electrons\Settings\Settings');

        $isWarmingUp = Carbon::now()->diffInSeconds(Carbon::parse($settings->warming->start), false) < 0 &&
                    Carbon::now()->diffInSeconds(Carbon::parse($settings->warming->finish), false) >= 0;

        if (! $user->isEntrant() || $user->isEntrant() && $user->entry->activity_id != 1) {
            return redirect()->route('dashboard');
        }

        if (! ($user->canJoinElimination() || $isWarmingUp)) {
            return redirect()->route('dashboard', ['vue' => 'elimination']);
        }

        return view('elimination.app', [
            'entrant' => auth()->user()->entry,
            'elimination' => $stages->get(Stages::STAGE_ELIMINATION)
        ]);
    }
}
