<?php

namespace Tests\Feature\Api\Policy\Alerts;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Alert;

class PostAlertsUsersTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/alerts/'. $alert->id .'/users', $this->randomAnnounceData() 
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

        $this->grant($user, 'post-alerts-users');

        $response = $this->requestToApi(
            $user, 'POST', '/alerts/'. $alert->id .'/users', $this->randomAnnounceData()
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
            $this->randomEntrant(), 'POST', '/alerts/'. $alert->id .'/users', $this->randomAnnounceData()
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

    /**
     * Generate a random announce data.
     *
     * @return array
     */
    protected function randomAnnounceData()
    {
        return [
            'announce' => [
                $this->createFactoryUser()->id
            ]
        ];
    }
}
