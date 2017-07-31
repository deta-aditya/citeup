<?php

namespace Tests\Feature\Api\Policy\Faqs;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Faq;

class GetFaqsEditsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $user = $this->randomAdmin();

        $faq = $this->createFactoryFaq();

        $response = $this->requestToApi(
            $user, 'GET', '/faqs/'. $faq->id .'/edits'
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

        $faq = $this->createFactoryFaq();

        $this->grant($user, 'get-edits');

        $response = $this->requestToApi(
            $user, 'GET', '/faqs/'. $faq->id .'/edits'
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

        $faq = $this->createFactoryFaq();

        $response = $this->requestToApi(
            $user, 'GET', '/faqs/'. $faq->id .'/edits'
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
