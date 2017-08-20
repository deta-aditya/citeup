<?php

namespace Tests\Feature\Api\Policy\HtmlContents;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class PostHtmlContentsTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/html-contents', $this->randomHtmlContentData()
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

        $this->grant($user, 'post-html-contents');

        $response = $this->requestToApi(
            $user, 'POST', '/html-contents', $this->randomHtmlContentData()
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
            $user, 'POST', '/html-contents', $this->randomHtmlContentData()
        );

        $response->assertStatus(403);
    }    

    /**
     * Generate a random content data.
     *
     * @return array
     */
    protected function randomHtmlContentData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'name' => $faker->text(191),
            'content' => $faker->paragraphs(3, true),
        ];
    }
}
