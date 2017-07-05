<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;
use App\User;

class PostUsersEntriesTest extends TestCase
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

        $this->createFactoryEntryFor($user);

        $response = $this->requestToApi(
            $this->randomAdmin(), 'POST', '/users/'. $user->id .'/entries', $this->randomModifyData()
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

        $this->grant($user, 'post-users-entries')
             ->createFactoryEntryFor($other);

        $response = $this->requestToApi(
            $user, 'POST', '/users/'. $other->id .'/entries', $this->randomModifyData()
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

        $response = $this->requestToApi(
            $user, 'POST', '/users/'. $other->id .'/entries', $this->randomModifyData()
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new entry for the specified user.
     *
     * @param  User  $user
     * @return this
     */
    protected function createFactoryEntryFor(User $user)
    {
        $activity = factory(Activity::class)->create();

        resolve('App\Modules\Electrons\Activities\EntryService')->make(
            $user, $activity
        );

        return $this;
    }

    /**
     * Generate a random modify data.
     *
     * @return array
     */
    protected function randomModifyData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'stage' => $faker->numberBetween(0, 5),
            'status' => $faker->randomElement([0, 1]),
        ];
    }
}
