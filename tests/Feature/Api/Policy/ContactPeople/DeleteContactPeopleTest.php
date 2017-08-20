<?php

namespace Tests\Feature\Api\Policy\ContactPeople;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\ContactPerson;

class DeleteContactPeopleTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $contact = $this->createFactoryContactPerson();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'DELETE', '/contact-people/'. $contact->id
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
        $contact = $this->createFactoryContactPerson();

        $user = $this->randomCommittee();

        $this->grant($user, 'delete-contact-people');

        $response = $this->requestToApi(
            $user, 'DELETE', '/contact-people/'. $contact->id
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
        $contact = $this->createFactoryContactPerson();

        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'DELETE', '/contact-people/'. $contact->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new contact using factory.
     *
     * @return this
     */
    protected function createFactoryContactPerson()
    {
        return factory(ContactPerson::class)->create();
    }
}
