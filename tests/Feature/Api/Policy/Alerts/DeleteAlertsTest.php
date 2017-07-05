<?php

namespace Tests\Feature\Api\Policy\Alerts;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Alert;

class DeleteAlertsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $alert = $this->createFactoryAlert();

        $response = $this->requestToApi(
            $this->randomAdmin(), 'DELETE', '/alerts/'. $alert->id
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

        $alert = $this->createFactoryAlert();

        $this->grant($user, 'delete-alerts');

        $response = $this->requestToApi(
            $user, 'DELETE', '/alerts/'. $alert->id
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
        $user = $this->randomEntrant();

        $alert = $this->createFactoryAlert();

        $response = $this->requestToApi(
            $user, 'DELETE', '/alerts/'. $alert->id
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
