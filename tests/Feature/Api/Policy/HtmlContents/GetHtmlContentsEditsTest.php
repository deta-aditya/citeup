<?php

namespace Tests\Feature\Api\Policy\HtmlContents;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\HtmlContent;

class GetHtmlContentsEditsTest extends TestCase
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

        $content = $this->createFactoryHtmlContent();

        $response = $this->requestToApi(
            $user, 'GET', '/html-contents/'. $content->id .'/edits'
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

        $content = $this->createFactoryHtmlContent();

        $this->grant($user, 'get-edits');

        $response = $this->requestToApi(
            $user, 'GET', '/html-contents/'. $content->id .'/edits'
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

        $content = $this->createFactoryHtmlContent();

        $response = $this->requestToApi(
            $user, 'GET', '/html-contents/'. $content->id .'/edits'
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
