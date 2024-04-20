<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_post_can_be_stored()
    {
        $this->withoutExceptionHandling();

        Storage::fake('public');

        $data = [
            'title' => 'My first post',
            'content' => 'This is my first post content',
            'image' => File::image('image.jpg'),
        ];

        $response = $this->post(route('posts.store'), $data);
        $response->assertOk();

        $this->assertDatabaseHas('posts', [
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => 'images/' . $data['image']->hashName(),
        ]);

        Storage::disk('public')->assertExists('images/' . $data['image']->hashName());
    }
}
