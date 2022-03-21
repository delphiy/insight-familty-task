<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\ArticleService;
use Tests\TestCase;

class ArticleServiceTest extends TestCase
{
    public function testUnauthorisedUsersCannotAccessHomePage()
    {
        $response = $this->get('/');
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testAuthorisedUsersCanAccessHomePage()
    {
        $user = User::factory()->make();
        $this->actingAs($user);
        $response = $this->get('/');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testArticleResponseContainCorrectKeys()
    {
        $articleService = new ArticleService();
        $articles = $articleService->fetchArticles()['articles'];

        $this->assertArrayHasKey('title', (array)$articles[0]);
        $this->assertArrayHasKey('image_url', (array)$articles[0]);
        $this->assertArrayHasKey('date', (array)$articles[0]);
        $this->assertArrayHasKey('original_url', (array)$articles[0]);
    }

    //We might do more test to check pagination
}
