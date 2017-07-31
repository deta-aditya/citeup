<?php

namespace Tests\Feature\Api\Policy\Alerts;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Alert;
use App\User;

class ViewAlertsTest extends TestCase
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
            $this->randomAdmin(), 'GET', '/alerts/'. $alert->id
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

        $this->grant($user, 'view-alerts');

        $response = $this->requestToApi(
            $user, 'GET', '/alerts/'. $alert->id
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt on viewing announced alert.
     *
     * @return void
     */
    public function test200Announced()
    {
        $user = $this->randomEntrant();

        $alert = $this->createFactoryAlertFor($user);

        $response = $this->requestToApi(
            $user, 'GET', '/alerts/'. $alert->id
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt on viewing unannounced alert.
     *
     * @return void
     */
    public function test403Unannounced()
    {
        $accessor = $this->randomEntrant();

        $user = $this->createFactoryUser();

        $alert = $this->createFactoryAlertFor($user);

        $response = $this->requestToApi(
            $accessor, 'GET', '/alerts/'. $alert->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new alert using factory and announce it to specified user.
     *
     * @param  User  $user
     * @return Alert
     */
    protected function createFactoryAlertFor(User $user)
    {
        $alert = $this->createFactoryAlert();

        resolve('App\Modules\Electrons\Alerts\AlertService')->announce(
            $user, [$alert->id]
        );

        return $alert;
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
