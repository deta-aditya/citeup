<?php

namespace App\Web\Front\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontController extends Controller
{
    /**
     * Show the landing page.
     *
     * @return Response
     */
    public function root()
    {
        return view('landing');
    }
}
