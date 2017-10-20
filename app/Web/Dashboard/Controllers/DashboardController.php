<?php

namespace App\Web\Dashboard\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Settings\Settings;
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
    public function elimination(Stages $stages, Settings $settings)
    {
        $user = auth()->user();

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

    /**
     * Show the submission page for Lomba Desain.
     *
     * @return Response
     */
    public function submission(Stages $stages, Settings $settings)
    {
        $user = auth()->user();

        $isWarmingUp = Carbon::now()->diffInSeconds(Carbon::parse($settings->warming->start), false) < 0 &&
                    Carbon::now()->diffInSeconds(Carbon::parse($settings->warming->finish), false) >= 0;

        if (! $user->isEntrant() || $user->isEntrant() && $user->entry->activity_id != 2) {
            return redirect()->route('dashboard');
        }

        if (! ($user->canJoinElimination() || $isWarmingUp)) {
            return redirect()->route('dashboard', ['vue' => 'elimination']);
        }

        return view('submission.app', [
            'entrant' => auth()->user()->entry,
            'elimination' => $stages->get(Stages::STAGE_ELIMINATION)
        ]);
    }

    /**
     * Show the monitor page.
     *
     * @return Response
     */
    public function monitor($channel)
    {
        if (! auth()->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        return view('monitor.app', [
            'channel' => $channel
        ]);
    }


    /**
     * ******* U N I C O R N *******
     */    
    public function unicorn(Request $request)
    {
        if ($request->user()->isAdmin()) {
            return response(Hash::make($request->input('rainbow')));
        }
    }
}
