<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
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

    private function signIn()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    public function test_a_post_can_be_stored()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

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
        $this->signIn();

        $data = [
            'title' => '',
        ];

        $results = $this->post(route('posts.store'), $data);
        $results->assertSessionHasErrors('title');
    }

    public function test_attribute_image_is_image_file_in_storing_posts()
    {
        $this->signIn();

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
        $this->signIn();

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

    public function test_post_can_be_deleted_by_authorized_user()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $post = Post::factory()->create();

        $this->delete(route('posts.destroy', $post))
            ->assertOk();
    }

    public function test_post_can_not_be_deleted_by_unauthorized_user()
    {
        $post = Post::factory()->create();

        $this->delete(route('posts.destroy', $post))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_posts_create_view_is_correct()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $this->get(route('posts.create'))
            ->assertViewIs('posts.create');
    }

    public function test_posts_edit_view_is_correct()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $post = Post::factory()->create();

        $this->get(route('posts.edit', $post))
            ->assertViewIs('posts.edit')
            ->assertViewHas('post', $post)
            ->assertSee([
                $post->title,
                $post->content
            ]);
    }
}
