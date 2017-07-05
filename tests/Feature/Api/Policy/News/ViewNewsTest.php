<?php

namespace Tests\Feature\Api\Policy\News;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\News;

class ViewNewsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $news = $this->createFactoryNews();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'GET', '/news/'. $news->id
        );

        $response->assertStatus(200);
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
