<?php

namespace Tests\Feature\Api\Policy\Alerts;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetAlertsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $response = $this->requestToApi(
            $this->randomAdmin(), 'GET', '/alerts', $this->usersParam()
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt using key.
     *
     * @return void
     */
    public function test200Keyed()
    {
        $user = $this->randomCommittee();

        $this->grant($user, 'get-alerts');

        $response = $this->requestToApi(
            $user, 'GET', '/alerts', $this->usersParam()
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt by normal user.
     *
     * @return void
     */
    public function test200Normal()
    {
        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'GET', '/alerts'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt to include 'users' parameter.
     *
     * @return void
     */
    public function test403WithUsers()
    {
        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'GET', '/alerts', $this->usersParam()
        );

        $response->assertStatus(403);
    }

    /**
     * Testing a forbidden attempt to include other user's ID on 'seenby' and 
     * 'unseenby' parameter.
     *
     * @return void
     */
    public function test403WithSeen()
    {
        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'GET', '/alerts', $this->seenParam()
        );

        $response->assertStatus(403);
    }    

    /**
     * Return a dangerous 'users' parameter.
     *
     * @return array
     */
    protected function usersParam()
    {
        return [
            'users' => ''. $this->createFactoryUser()->id
        ];
    }    

    /**
     * Return a dangerous 'seenby' and 'unseenby' parameter.
     *
     * @return array
     */
    protected function seenParam()
    {
        return [
            'seenby' => $this->createFactoryUser()->id,
            'unseenby' => $this->createFactoryUser()->id
        ];
    }
}
