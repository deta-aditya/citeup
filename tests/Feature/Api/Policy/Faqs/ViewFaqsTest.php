<?php

namespace Tests\Feature\Api\Policy\Faqs;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Faq;

class ViewFaqsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $faq = $this->createFactoryFaq();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'GET', '/faqs/'. $faq->id
        );

        $response->assertStatus(200);
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
