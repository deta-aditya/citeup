<?php

namespace App\Web\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * @param  string  $additional
     * @return Response
     */
    public function index($additional = null)
    {
        $user = auth()->user();

        $user->load('profile', 'role', 'entry');

        return view('dashboard.app', [
            'user' => $user
        ]);
    }
}
