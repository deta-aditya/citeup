<?php

namespace App\Modules\Electrons\Recaptcha;

use GuzzleHttp\Client;

class VerificationResult
{
    protected $keys = [];

    public function __construct($response)
    {
        $this->keys = json_decode((string) $response->getBody(), true);
    }

    public static function make($response)
    {
        return new VerificationResult($response);
    }

    public function success()
    {
        return $this->keys['success'];
    }

    public function errorCodes()
    {
        return ['recaptcha' => $this->keys['error-codes']];
    }
}
