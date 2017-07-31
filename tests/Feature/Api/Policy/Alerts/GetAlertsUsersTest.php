<?php

namespace Tests\Feature\Api\Policy\Alerts;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Alert;

class GetAlertsUsersTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt on admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $alert = $this->createFactoryAlert();

        $response = $this->requestToApi(
            $this->randomAdmin(), 'GET', '/alerts/'. $alert->id .'/users'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful keyed attempt.
     *
     * @return void
     */
    public function test200Keyed()
    {
        $user = $this->randomCommittee();

        $alert = $this->createFactoryAlert();

        $this->grant($user, 'get-users');

        $response = $this->requestToApi(
            $user, 'GET', '/alerts/'. $alert->id .'/users'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt.
     *
     * @return void
     */
    public function test403()
    {
        $alert = $this->createFactoryAlert();
        
        $response = $this->requestToApi(
            $this->randomEntrant(), 'GET', '/alerts/'. $alert->id .'/users'
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new alert using factory.
     *
     * @return Alert
     */
    protected function createFactoryAlert()
    {
        return factory(Alert::class)->create();
    }
}
