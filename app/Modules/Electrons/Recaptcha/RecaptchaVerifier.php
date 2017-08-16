<?php

namespace App\Modules\Electrons\Recaptcha;

use GuzzleHttp\Client;

class RecaptchaVerifier
{
    protected $url = 'https://www.google.com/recaptcha/api/siteverify';

    protected $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function verify($responseToken)
    {
        return VerificationResult::make(
            $this->request($this->url, $this->secret(), $responseToken)
        );
    }

    public function request($url, $secret, $response)
    {
        return $this->http->post($url, [
            'form_params' => [
                'secret' => $secret,
                'response' => $response,
            ]
        ]);
    }

    public function secret()
    {
        return config('recaptcha.secret');
    }
}
