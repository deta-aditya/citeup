<?php

namespace Tests\Feature\Api\Policy\Testimonials;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Testimonial;

class DeleteTestimonialsTest extends TestCase
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
            $user, 'DELETE', '/testimonials/'. $testimonial->id
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

        $this->grant($user, 'delete-testimonials');

        $response = $this->requestToApi(
            $user, 'DELETE', '/testimonials/'. $testimonial->id
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
        
        $testimonial = $this->createFactoryTestimonial();

        $response = $this->requestToApi(
            $user, 'DELETE', '/testimonials/'. $testimonial->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new testimonial using factory.
     *
     * @return this
     */
    protected function createFactoryTestimonial()
    {
        return factory(Testimonial::class)->create();
    }
}
