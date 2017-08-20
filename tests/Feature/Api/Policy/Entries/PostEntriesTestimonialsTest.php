<?php

namespace Tests\Feature\Api\Policy\Entries;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Entry;
use App\User;

class PostEntriesTestimonialsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt from admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $user = $this->randomAdmin();

        $entry = $this->createFactoryEntryFor($this->createFactoryUser());

        $response = $this->requestToApi(
            $user, 'POST', '/entries/'. $entry->id .'/testimonials', $this->randomAddData()
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

        $entry = $this->createFactoryEntryFor($this->createFactoryUser());

        $this->grant($user, 'post-entries-testimonials');

        $response = $this->requestToApi(
            $user, 'POST', '/entries/'. $entry->id .'/testimonials', $this->randomAddData()
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt on self.
     *
     * @return void
     */
    public function test200Self()
    {
        $user = $this->createFactoryUser();

        $entry = $this->createFactoryEntryFor($user);       

        $response = $this->requestToApi(
            $user, 'POST', '/entries/'. $entry->id .'/testimonials', $this->randomAddData()
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
        $user = $this->createFactoryUser();

        $this->createFactoryEntryFor($user);

        $entry = $this->createFactoryEntryFor($this->createFactoryUser());

        $response = $this->requestToApi(
            $user, 'POST', '/entries/'. $entry->id .'/testimonials', $this->randomAddData()
        );

        $response->assertStatus(403);
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

    /**
     * Generate a random add data.
     *
     * @return array
     */
    protected function randomAddData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'content' => $faker->text(191),
            'rating' => $faker->numberBetween(1, 5),
        ];
    }
}
