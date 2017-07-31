<?php

namespace Tests\Feature\Api\Policy\Faqs;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;
use App\Modules\Models\Faq;

class PutFaqsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $faq = $this->createFactoryFaq();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'PUT', '/faqs/'. $faq->id, $this->randomFaqData()
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
        $faq = $this->createFactoryFaq();

        $user = $this->randomCommittee();

        $this->grant($user, 'put-faqs');

        $response = $this->requestToApi(
            $user, 'PUT', '/faqs/'. $faq->id, $this->randomFaqData()
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
        $faq = $this->createFactoryFaq();

        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'PUT', '/faqs/'. $faq->id, $this->randomFaqData()
        );

        $response->assertStatus(403);
    }    

    /**
     * Generate a random faq data.
     *
     * @return array
     */
    protected function randomFaqData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'name' => $faker->text(191),
            'picture' => $faker->text(191),
        ];
    }

    /**
     * Create a new faq using factory.
     *
     * @return this
     */
    protected function createFactoryFaq()
    {
        return factory(Faq::class)->create();
    }
}
