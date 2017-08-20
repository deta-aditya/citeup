<?php

namespace Tests\Feature\Api\Policy\HtmlContents;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\HtmlContent;

class PutHtmlContentsTest extends TestCase
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
            $user, 'PUT', '/html-contents/'. $content->id, $this->randomHtmlContentData()
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

        $this->grant($user, 'put-html-contents');

        $response = $this->requestToApi(
            $user, 'PUT', '/html-contents/'. $content->id, $this->randomHtmlContentData()
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
            $user, 'PUT', '/html-contents/'. $content->id, $this->randomHtmlContentData()
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
