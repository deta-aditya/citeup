<?php

namespace App\Web\Front\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Config\Config;
use App\Modules\Electrons\Activities\ActivityService as Activities;
use App\Modules\Electrons\Activities\ScheduleService as Schedules;
use App\Modules\Electrons\Sponsors\SponsorService as Sponsors;
use App\Modules\Electrons\Faqs\FaqService as Faqs;
use App\Modules\Electrons\News\NewsService;
use App\Modules\Models\News;

class FrontController extends Controller
{
    /**
     * Show the landing page.
     *
     * @param  Activities   $activities
     * @param  Faqs         $faqs
     * @param  Sponsors     $sponsors
     * @param  NewsService  $news
     * @param  Config       $config
     * @return Response
     */
    public function root(Activities $activities, Faqs $faqs, Sponsors $sponsors, NewsService $news, Config $config)
    {
        $data = [
            'activities' => $activities->getMultiple([]),
            'config' => $config->all(),
            'faqs' => $faqs->getMultiple(['sort' => 'created_at:desc', 'take' => 5]),
            'news' => $news->getMultiple(['sort' => 'created_at:desc', 'take' => 4, 'with' => 'edits.user.profile']),
            'sponsors' => $sponsors->getMultiple([]),
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
     * Show the news page.
     *
     * @param  Request      $request
     * @param  NewsService  $news
     * @return Response
     */
    public function news(Request $request, NewsService $news)
    {
        $page = $request->query('p', 1);

        $take = 15;

        $skip = $take * ($page - 1);
        
        $news = $news->getMultiple(['sort' => 'created_at:desc']);

        $possible = [];

        for ($i = 1; $i < ceil($news->count() / $take); $i++) {
            $possible[] = $i;
        }
        
        $count = $news->count();

        $data = [
            'news' => $news->slice($skip, $take),
            'page' => [
                'possible' => $possible,
                'current' => $page,
                'previous' => $page > 1 ? $page - 1 : null,
                'next' => $page < count($possible) ? $page + 1 : null,
            ],
        ];

        return view('front.news.index', $data);
    }

    /**
     * Show the news page.
     *
     * @param  News  $news
     * @param  string  $slug
     * @return Response
     */
    public function newsItem(News $news, $slug = null)
    {
        $data = [
            'news' => $news->load('edits.user.profile')
        ];

        return view('front.news.item', $data);
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
