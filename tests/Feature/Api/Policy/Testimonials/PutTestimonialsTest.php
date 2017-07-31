<?php

namespace Tests\Feature\Api\Policy\Testimonials;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Testimonial;
use App\Modules\Models\Activity;
use App\User;

class PutTestimonialsTest extends TestCase
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

        $testimonial = $this->createFactoryTestimonial();

        $response = $this->requestToApi(
            $user, 'PUT', '/testimonials/'. $testimonial->id, $this->randomTestimonialData()
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

        $testimonial = $this->createFactoryTestimonial();

        $this->grant($user, 'put-testimonials');

        $response = $this->requestToApi(
            $user, 'PUT', '/testimonials/'. $testimonial->id, $this->randomTestimonialData()
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

        $testimonial = $this->createFactoryTestimonial($entry);

        $response = $this->requestToApi(
            $user, 'PUT', '/testimonials/'. $testimonial->id, $this->randomTestimonialData()
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

        $testimonial = $this->createFactoryTestimonial();

        $this->createFactoryEntryFor($user);

        $response = $this->requestToApi(
            $user, 'PUT', '/testimonials/'. $testimonial->id, $this->randomTestimonialData()
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new testimonial using factory.
     *
     * @param  Entry|null  $entry
     * @return this
     */
    protected function createFactoryTestimonial($entry = null)
    {
        return factory(Testimonial::class)->create(
            is_null($entry) ? [] : ['entry_id' => $entry->id]
        );
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
     * @return array
     */
    protected function randomTestimonialData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'content' => $faker->text(191),
            'rating' => $faker->numberBetween(1, 5),
        ];
    }
}
