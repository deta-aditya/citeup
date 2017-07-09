<?php

namespace App\Web\Auth\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Activities\ActivityService as Activities;

class RegisterController extends Controller
{
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
}
