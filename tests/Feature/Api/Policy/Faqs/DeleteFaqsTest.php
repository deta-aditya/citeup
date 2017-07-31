<?php

namespace Tests\Feature\Api\Policy\Faqs;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Faq;

class DeleteFaqsTest extends TestCase
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
            $user, 'DELETE', '/faqs/'. $faq->id
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

        $this->grant($user, 'delete-faqs');

        $response = $this->requestToApi(
            $user, 'DELETE', '/faqs/'. $faq->id
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
            $user, 'DELETE', '/faqs/'. $faq->id
        );

        $response->assertStatus(403);
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
