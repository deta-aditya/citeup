<?php

namespace App\Web\Front\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Config\Config;
use App\Modules\Electrons\Activities\ActivityService as Activities;

class AboutController extends Controller
{
    /**
     * The activity service instance.
     *
     * @var Activities
     */
    protected $activities;

    /**
     * The web config instance.
     *
     * @var Config
     */
    protected $config;

    /**
     * The navigation theme.
     *
     * @var string
     */
    protected $navtheme = 'light';

    /**
     * The view name.
     *
     * @var string
     */
    protected $view = 'front.about';

    /**
     * Create a new controller instance.
     *
     * @param  Activities  $activities
     * @param  Config      $config
     * @return void
     */
    public function __construct(Activities $activities, Config $config)
    {
        $this->activities = $activities;
        $this->config = $config;
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
            'config'        => $this->config->all(),
            'activities'    => $this->activities->getMultiple([]),
            'nav'           => $this->navtheme,
        ];
    }

}
