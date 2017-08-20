<?php

namespace Tests\Feature\Api\Policy\HtmlContents;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetHtmlContentsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $response = $this->requestToApi(
            $this->randomEntrant(), 'GET', '/html-contents'
        );

        $response->assertStatus(200);
    }
}
