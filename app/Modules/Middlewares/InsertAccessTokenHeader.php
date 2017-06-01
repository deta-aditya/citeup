<?php

namespace App\Modules\Middlewares;

use Auth;
use Closure;
use Illuminate\Http\Request;

class InsertAccessTokenHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->isEligibleForAuth($request)) {
            $this->tokenize($request);
        }

        return $next($request);
    }

    /**
     * Check whether the current request is eligible for tokenizing
     *
     * @param  Request  $request
     * @return bool
     */
    protected function isEligibleForAuth(Request $request) {
        return Auth::check() && session()->has('passport');
    }

    /**
     * Tokenize the request by attaching "Authorize" header to the request 
     *
     * @param  Request  $request
     * @return void
     */
    protected function tokenize(Request $request) {
        $request->header->add(['Authorize' => 'Bearer ' . 
            session()->get('passport')['access_token']]);
    }
}
