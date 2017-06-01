<?php

namespace App\Modules\Electrons\Auth;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

trait AuthorizeToPassport 
{
    /**
     * Authorize the credentials to Laravel Passport.
     *
     * @return void
     */
    protected function passport() {
        
        $request = $this->catchPsrRequest();

        $response = $this->issuePassword($request);

        $this->storeTokens($this->decode($response));
    }

    /**
     * Get the instance of PSR-7 Request object via container.
     *
     * @return ServerRequestInterface
     */
    protected function catchPsrRequest()
    {
        return app('Psr\Http\Message\ServerRequestInterface');
    }

    /**
     * Issue the credentials to the Passport server with password grant type.
     *
     * @param  ServerRequestInterface  $request
     * @return ResponseInterface
     */
    protected function issuePassword(ServerRequestInterface $request)
    {
        return app('Laravel\Passport\Http\Controllers\AccessTokenController')
            ->issueToken($request);   
    }

    /**
     * Put tokens data to server session.
     *
     * @param  array  $tokenInfo
     * @return void
     */
    protected function storeTokens($tokenInfo)
    {
        session(['passport' => $tokenInfo]);
    }

    /**
     * Decode the response JSON to PHP array.
     *
     * @param  ResponseInterface  $response
     * @return array
     */
    protected function decode(ResponseInterface $response)
    {
        return json_decode((string) $response->getBody(), true);
    }
} 
