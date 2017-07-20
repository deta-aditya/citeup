<?php

namespace App\Web\Front\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Config\Config;
use App\Modules\Electrons\Activities\ActivityService as Activities;

class FrontController extends Controller
{
    /**
     * Show the landing page.
     *
     * @param  Activities  $activities
     * @param  Config      $config
     * @return Response
     */
    public function root(Activities $activities, Config $config)
    {
        $data = [
            'config' => $config->all(),
            'activities' => $activities->getMultiple([])
        ];

        return view('landing', $data);
    }

    /**
     * Show the test page.
     *
     * @return Response
     */
    public function test(Config $config)
    {
        $config->set(['countdown' => ['active' => true, 'off' => '2017-08-22 12:00:00']]);

        return $config->all();
    }
}
