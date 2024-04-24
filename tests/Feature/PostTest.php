<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_a_post_can_be_stored()
    {
        $this->withoutExceptionHandling();

        $data = [
            'title' => 'My first post',
            'content' => 'This is my first post content',
            'image' => File::image('image.jpg'),
        ];

        $this->post(route('posts.store'), $data)->assertOk();

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

    public function test_a_post_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        $data = [
            'title' => 'My first post updated',
            'content' => 'This is my first post content updated',
            'image' => File::image('image.jpg'),
        ];

        $this->put(route('posts.update', $post), $data)->assertOk();

        $this->assertDatabaseHas('posts', [
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => 'images/' . $data['image']->hashName(),
        ]);

        $this->assertEquals($post->id, Post::first()->id);
    }

    public function test_route_posts_index_is_correct_view_with_posts()
    {
        $this->withoutExceptionHandling();

        $posts = Post::factory(20)->create();

        $this->get(route('posts.index'))
            ->assertViewIs('posts.index')
            ->assertViewHas('posts', $posts)
            ->assertSee([
                $posts->first()->title,
                $posts->first()->content
            ]);
    }

    public function test_route_posts_show_is_correct_view_with_his_own_post()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        $this->get(route('posts.show', $post))
            ->assertViewIs('posts.show')
            ->assertViewHas('post', $post)
            ->assertSee([
                $post->title,
                $post->content
            ]);
    }
}
