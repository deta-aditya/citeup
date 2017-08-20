<?php

namespace Tests\Feature\Api\Policy\ContactPeople;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\ContactPerson;

class ViewContactPeopleTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $contact = $this->createFactoryContactPerson();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'GET', '/contact-people/'. $contact->id
        );

        $response->assertStatus(200);
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
