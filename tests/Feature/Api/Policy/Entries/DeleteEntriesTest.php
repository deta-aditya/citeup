<?php

namespace Tests\Feature\Api\Policy\Entries;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;
use App\Modules\Models\Entry;
use App\User;

class DeleteEntriesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt from admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $entry = $this->createFactoryEntry();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'DELETE', '/entries/' . $entry->id
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
        $entry = $this->createFactoryEntry();
        
        $user = $this->randomCommittee();

        $this->grant($user, 'delete-entries');

        $response = $this->requestToApi(
            $user, 'DELETE', '/entries/' . $entry->id
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
        $entry = $this->createFactoryEntry();

        $user = $this->createFactoryUser();

        $response = $this->requestToApi(
            $user, 'DELETE', '/entries/' . $entry->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new entry using factory.
     *
     * @return Entry
     */
    protected function createFactoryEntry()
    {
        return factory(Entry::class)->create();
    }
}
