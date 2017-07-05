<?php

namespace Tests\Feature\Api\Policy\Alerts;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class PostAlertsTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/alerts', $this->randomAlertData()
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

        $this->grant($user, 'post-alerts');

        $response = $this->requestToApi(
            $user, 'POST', '/alerts', $this->randomAlertData()
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

        $response = $this->requestToApi(
            $user, 'POST', '/alerts', $this->randomAlertData()
        );

        $response->assertStatus(403);
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
