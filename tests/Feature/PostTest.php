<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_post_can_be_stored()
    {
        $this->withoutExceptionHandling();

        $data = [
            'title' => 'My first post',
            'content' => 'This is my first post content',
            'image' => 'image.jpg',
        ];

        $response = $this->post(route('posts.store'), $data);

        $response->assertOk();

        $this->assertDatabaseHas('posts', $data);
    }
}
