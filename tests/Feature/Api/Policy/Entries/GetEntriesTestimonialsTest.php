<?php

namespace Tests\Feature\Api\Policy\Entries;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Entry;
use App\User;

class GetEntriesTestimonialsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $user = $this->randomEntrant();

        $entry = $this->createFactoryEntryFor($this->createFactoryUser());

        $response = $this->requestToApi(
            $user, 'GET', '/entries/'. $entry->id .'/testimonials'
        );

        $response->assertStatus(200);
    }

    /**
     * Create a new entry for the specified user and return it.
     *
     * @param  User  $user
     * @return this
     */
    protected function createFactoryEntryFor(User $user)
    {
        $entry = factory(Entry::class)->create();

        resolve('App\Modules\Electrons\Activities\EntryService')->associate(
            $user, $entry
        );

        return $user->entry;
    }
}
