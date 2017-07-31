<?php

namespace Tests\Feature\Api\Policy\News;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\News;

class DeleteNewsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $news = $this->createFactoryNews();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'DELETE', '/news/'. $news->id
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
        $news = $this->createFactoryNews();

        $user = $this->randomCommittee();

        $this->grant($user, 'delete-news');

        $response = $this->requestToApi(
            $user, 'DELETE', '/news/'. $news->id
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
        $news = $this->createFactoryNews();

        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'DELETE', '/news/'. $news->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new news using factory.
     *
     * @return this
     */
    protected function createFactoryNews()
    {
        return factory(News::class)->create();
    }
}
