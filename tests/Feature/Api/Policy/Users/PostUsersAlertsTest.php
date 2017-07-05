<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Alert;
use App\User;

class PostUsersAlertsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $user = $this->randomEntrant();

        $this->createFactoryAlertFor($user);

        $response = $this->requestToApi(
            $this->randomAdmin(), 'POST', '/users/'. $user->id .'/alerts', $this->randomSeeData()
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

        $other = $this->randomEntrant();

        $this->grant($user, 'post-users-alerts')
             ->createFactoryAlertFor($other);

        $response = $this->requestToApi(
            $user, 'POST', '/users/'. $other->id .'/alerts', $this->randomSeeData()
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt by self.
     *
     * @return void
     */
    public function test200Self()
    {
        $user = $this->randomEntrant();

        $this->createFactoryAlertFor($user);

        $response = $this->requestToApi(
            $user, 'POST', '/users/'. $user->id .'/alerts', $this->randomSeeData()
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

        $other = $this->createFactoryUser();

        $this->createFactoryAlertFor($other);

        $response = $this->requestToApi(
            $user, 'POST', '/users/'. $other->id .'/alerts', $this->randomSeeData()
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new alert using factory and announce it to specified user.
     *
     * @param  User  $user
     * @return this
     */
    protected function createFactoryAlertFor(User $user)
    {
        $alert = factory(Alert::class)->create();

        resolve('App\Modules\Electrons\Alerts\AlertService')->announce(
            $user, [$alert->id]
        );

        return $this;
    }

    /**
     * Generate a random see data.
     *
     * @return array
     */
    protected function randomSeeData()
    {
        return [
            'see' => [
                Alert::inRandomOrder()->first()->id
            ]
        ];
    }
}
