<?php

namespace App\Web\Front\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Config\Config;
use App\Modules\Electrons\Activities\ActivityService as Activities;
use App\Modules\Electrons\Activities\ScheduleService as Schedules;
use App\Modules\Electrons\Sponsors\SponsorService as Sponsors;
use App\Modules\Electrons\Faqs\FaqService as Faqs;

class FrontController extends Controller
{
    /**
     * Show the landing page.
     *
     * @param  Activities  $activities
     * @param  Faqs        $faqs
     * @param  Sponsors    $sponsors
     * @param  Config      $config
     * @return Response
     */
    public function root(Activities $activities, Faqs $faqs, Sponsors $sponsors, Config $config)
    {
        $data = [
            'config' => $config->all(),
            'sponsors' => $sponsors->getMultiple([]),
            'faqs' => $faqs->getMultiple(['take' => 5]),
            'activities' => $activities->getMultiple([]),
        ];

        return view('landing', $data);
    }

    /**
     * Show the activities page.
     *
     * @param  Activities  $activities
     * @param  Schedules   $schedules
     * @param  Config      $config
     * @param  string      $t
     * @return Response
     */
    public function activities(Activities $activities, Schedules $schedules, Config $config, $t = 'lomba-logika')
    {
        $activities = $activities->getMultiple([])->toArray();

        for ($i = 0; $i < count($activities); $i++) {
            $activities[$i]['schedules'] = $schedules->getMultiple([
                'activity' => $activities[$i]['id'],
                'sort' => 'held_at:asc'
            ]);
        }

        $data = [
            'config' => $config->all(),
            'activities' => $activities,
            'type' => $t,
        ];

        return view('front.activities', $data);
    }

    /**
     * Show the faqs page.
     *
     * @param  Faqs  $faqs
     * @return Response
     */
    public function faqs(Faqs $faqs)
    {
        $data = [
            'faqs' => $faqs->getMultiple([]),
        ];

        return view('front.faqs', $data);
    }

    /**
     * Show the test page.
     *
     * @return Response
     */
    public function test(Config $config)
    {
        //       
    }
}
