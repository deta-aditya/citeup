<?php

namespace Tests\Feature\Api\Policy\Faqs;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class PostFaqsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $response = $this->requestToApi(
            $this->randomAdmin(), 'POST', '/faqs', $this->randomFaqData()
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

        $this->grant($user, 'post-faqs');

        $response = $this->requestToApi(
            $user, 'POST', '/faqs', $this->randomFaqData()
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

        $response = $this->requestToApi(
            $user, 'POST', '/faqs', $this->randomFaqData()
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
            'answer' => $faker->text(191),
            'question' => $faker->text(191),
        ];
    }
}
