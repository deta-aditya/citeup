<?php

namespace Tests\Feature\Api\Policy\Alerts;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Alert;

class PutAlertsTest extends TestCase
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
            $this->randomAdmin(), 'PUT', '/alerts/'. $alert->id, $this->randomAlertData()
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

        $this->grant($user, 'put-alerts');

        $response = $this->requestToApi(
            $user, 'PUT', '/alerts/'. $alert->id, $this->randomAlertData()
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
            $user, 'PUT', '/alerts/'. $alert->id, $this->randomAlertData()
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
     * Generate a random alert data.
     *
     * @return array
     */
    protected function randomAlertData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'title' => $faker->sentence(5),
            'content' => $faker->text(191),
        ];
    }
}
