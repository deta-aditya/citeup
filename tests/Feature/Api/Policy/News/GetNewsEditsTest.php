<?php

namespace Tests\Feature\Api\Policy\News;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\News;

class GetNewsEditsTest extends TestCase
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

        $news = $this->createFactoryNews();

        $response = $this->requestToApi(
            $user, 'GET', '/news/'. $news->id .'/edits'
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

        $news = $this->createFactoryNews();

        $this->grant($user, 'get-edits');

        $response = $this->requestToApi(
            $user, 'GET', '/news/'. $news->id .'/edits'
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

        $news = $this->createFactoryNews();

        $response = $this->requestToApi(
            $user, 'GET', '/news/'. $news->id .'/edits'
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
