<?php

namespace Tests\Feature\Api\Policy\Testimonials;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;
use App\User;

class PostTestimonialsTest extends TestCase
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

        $response = $this->requestToApi(
            $user, 'POST', '/testimonials', $this->randomTestimonialData()
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

        $this->grant($user, 'post-testimonials');

        $response = $this->requestToApi(
            $user, 'POST', '/testimonials', $this->randomTestimonialData()
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt by entrant.
     *
     * @return void
     */
    public function test200Entrant()
    {
        $user = $this->createFactoryUser();

        $entry = $this->createFactoryEntryFor($user);

        $response = $this->requestToApi(
            $user, 'POST', '/testimonials', $this->randomTestimonialData($entry)
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

        $response = $this->requestToApi(
            $user, 'POST', '/testimonials', $this->randomTestimonialData()
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
        $activity = factory(Activity::class)->create();

        resolve('App\Modules\Electrons\Activities\EntryService')->make(
            $user, $activity
        );

        return $user->entry;
    }

    /**
     * Generate a random testimonial data.
     *
     * @param  Entry|null  $entry
     * @return array
     */
    protected function randomTestimonialData($entry = null)
    {
        $faker = resolve('Faker\Generator');

        if (is_null($entry)) {
            $entry = $this->createFactoryEntryFor($this->createFactoryUser());
        }

        return [
            'entry' => $entry->id,
            'content' => $faker->text(191),
            'rating' => $faker->numberBetween(1, 5),
        ];
    }
}
