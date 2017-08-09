<?php

namespace Tests\Feature\Api\Policy\HtmlContents;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\HtmlContent;

class ViewHtmlContentsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $content = $this->createFactoryHtmlContent();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'GET', '/html-contents/'. $content->id
        );

        $response->assertStatus(200);
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
