<?php

namespace App\Modules\Electrons\Recaptcha;

use Closure;

class VerifyRecaptchaMiddleware
{
    /**
     * The recaptcha verifier instance.
     *
     * @var RecaptchaVerifier     
     */
    protected $captcha;

    /**
     * Create a new middleware instance.
     */
    public function __construct(RecaptchaVerifier $captcha)
    {
        $this->captcha = $captcha;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $verification = $this->captcha->verify($request->input('g-recaptcha-response'));

        if ($verification->success()) {
            return $next($request);
        }

        return back()->withInput()->withErrors($verification->errorCodes());
    }
}