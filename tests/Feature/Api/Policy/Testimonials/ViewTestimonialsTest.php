<?php

namespace Tests\Feature\Api\Policy\Testimonials;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Testimonial;

class ViewTestimonialsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $testimonial = $this->createFactoryTestimonial();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'GET', '/testimonials/'. $testimonial->id
        );

        $response->assertStatus(200);
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
