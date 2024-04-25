<?php

namespace Tests\Feature\Api;

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

        $this->withHeader('Accept', 'application/json');

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

        $dataCheck = [
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => 'images/' . $data['image']->hashName(),
        ];

        $this->postJson(route('api.posts.store'), $data)
            ->assertJson($dataCheck);

        $this->assertDatabaseHas('posts', $dataCheck);

        Storage::disk('public')->assertExists('images/' . $data['image']->hashName());
    }

    public function test_attribute_title_is_required_in_storing_posts()
    {
        $this->signIn();

        $data = [
            'title' => '',
        ];

        $this->post(route('api.posts.store'), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors('title');
    }

    /*public function test_attribute_image_is_image_file_in_storing_posts()
    {
        $this->signIn();

        $data = [
            'title' => 'Title',
            'image' => 'not-an-image-file',
        ];

        $results = $this->post(route('posts.store'), $data);
        $results->assertSessionHasErrors('image');
    }*/
}
