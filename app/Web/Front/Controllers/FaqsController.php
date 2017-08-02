<?php

namespace App\Web\Front\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Faqs\FaqService as Faqs;

class FaqsController extends Controller
{
    /**
     * The faqs service instance.
     *
     * @var Faqs
     */
    protected $faqs;

    /**
     * The navigation theme.
     *
     * @var string
     */
    protected $navtheme = 'white';

    /**
     * The view name.
     *
     * @var string
     */
    protected $view = 'front.faqs';

    /**
     * Create a new controller instance.
     *
     * @param  Faqs  $faqs
     * @return void
     */
    public function __construct(Faqs $faqs)
    {
        $this->faqs = $faqs;
    }

    /**
     * Show the faqs page.
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
            'faqs'  => $this->faqs->getMultiple([]),
            'nav'   => $this->navtheme,
        ];
    }

}
