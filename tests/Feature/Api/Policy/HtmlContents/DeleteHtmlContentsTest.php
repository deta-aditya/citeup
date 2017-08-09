<?php

namespace Tests\Feature\Api\Policy\HtmlContents;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\HtmlContent;

class DeleteHtmlContentsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $content = $this->createFactoryHtmlContent();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'DELETE', '/html-contents/'. $content->id
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
        $content = $this->createFactoryHtmlContent();

        $user = $this->randomCommittee();

        $this->grant($user, 'delete-html-contents');

        $response = $this->requestToApi(
            $user, 'DELETE', '/html-contents/'. $content->id
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
        $content = $this->createFactoryHtmlContent();

        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'DELETE', '/html-contents/'. $content->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new content using factory.
     *
     * @return this
     */
    protected function createFactoryHtmlContent()
    {
        return factory(HtmlContent::class)->create();
    }
}
