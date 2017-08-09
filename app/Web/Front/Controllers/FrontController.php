<?php

namespace App\Web\Front\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\ContactPeople\ContactPersonService as ContactPeople;
use App\Modules\Electrons\Activities\ActivityService as Activities;
use App\Modules\Electrons\Activities\ScheduleService as Schedules;
use App\Modules\Electrons\Sponsors\SponsorService as Sponsors;
use App\Modules\Electrons\News\NewsService as News;
use App\Modules\Electrons\Faqs\FaqService as Faqs;

class FrontController extends Controller
{
    /**
     * The activity service instance.
     *
     * @var Activities
     */
    protected $activities;

    /**
     * The faq service instance.
     *
     * @var Faqs
     */
    protected $faqs;

    /**
     * The sponsor service instance.
     *
     * @var Sponsors
     */
    protected $sponsors;

    /**
     * The news service instance.
     *
     * @var News
     */
    protected $news;

    /**
     * The contact people service instance.
     *
     * @var ContactPeople
     */
    protected $contacts;

    /**
     * The navigation theme.
     *
     * @var string
     */
    protected $navtheme = 'dark';

    /**
     * The view name.
     *
     * @var string
     */
    protected $view = 'landing';

    /**
     * The activities query parameter.
     * 
     * @var array
     */
    protected $activitiesQuery = ['sort' => 'order:asc'];

    /**
     * The faqs query parameter.
     * 
     * @var array
     */
    protected $faqsQuery = ['sort' => 'created_at:desc', 'take' => 5];

    /**
     * The news query parameter.
     * 
     * @var array
     */
    protected $newsQuery = ['sort' => 'created_at:desc', 'take' => 4, 'with' => 'edits.user.profile'];

    /**
     * Create a new controller instance.
     *
     * @param  Activities  $activities
     * @param  Faqs        $faqs
     * @param  Sponsors    $sponsors
     * @param  News        $news
     * @return void
     */
    public function __construct(Activities $activities, Faqs $faqs, News $news, 
        Sponsors $sponsors, ContactPeople $contacts)
    {
        $this->activities = $activities;
        $this->faqs = $faqs;
        $this->news = $news;
        $this->sponsors = $sponsors;
        $this->contacts = $contacts;
    }

    /**
     * Show the landing page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view($this->view, $this->data());
    }

    /**
     * Return the data required in the view.
     *
     * @return array
     */
    protected function data()
    {
        return [
            'activities'    => $this->activities->getMultiple($this->activitiesQuery),
            'faqs'          => $this->faqs->getMultiple($this->faqsQuery),
            'news'          => $this->news->getMultiple($this->newsQuery),
            'sponsors'      => $this->sponsors->getMultiple(['type' => Sponsors::TYPE_SPONSOR]),
            'media_partners'=> $this->sponsors->getMultiple(['type' => Sponsors::TYPE_MEDIA_PARTNER]),
            'contact_people'=> $this->contacts->multiple(['take' => 4]),
            'nav'           => $this->navtheme,
        ];
    }
}
