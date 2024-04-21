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

        $this->post(route('posts.store'), $data);

        $this->assertDatabaseHas('posts', [
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => 'images/' . $data['image']->hashName(),
        ]);

        Storage::disk('public')->assertExists('images/' . $data['image']->hashName());
    }

    public function test_attribute_title_is_required_in_storing_posts()
    {
        $data = [
            'title' => '',
        ];

        $results = $this->post(route('posts.store'), $data);
        $results->assertSessionHasErrors('title');
    }

    public function test_attribute_image_is_image_file_in_storing_posts()
    {
        $data = [
            'title' => 'Title',
            'image' => 'not-an-image-file',
        ];

        $results = $this->post(route('posts.store'), $data);
        $results->assertSessionHasErrors('image');
    }
}
